<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmissionQuestionStoreRequest;
use App\Models\Exam;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    protected $submission;
    protected $exam;

    public function exam_view(Exam $exam)
    {
        $return = $this->verify($exam->id);

        if ($return){
            return redirect()->route('exams.index')->with(['danger' => $return['message']]);
        }

        $question = $this->exam->getQuestionByNumber($this->submission->current_question);

        $data = [
            'guidelines' => $this->exam->guidelines,
            'exam_title' => $this->exam->title,
            'current_question' => $this->submission->current_question,
            'exam_id' => $this->exam->id,
            'exam_started' => $this->submission->started_at ? 'true' : 'false',
            'start_time' => $this->submission->started_at,
            'total_exam_time' => $this->exam->total_time,
            'marked' => $this->submission->answers ?? [],
            'bookmarks' => $this->submission->bookmarks ?? [],
            'messages' => json_decode(file_get_contents(resource_path('messages/speeches.json')), true),
            'commands' => json_decode(file_get_contents(resource_path('messages/commands.json')), true),
            'question' => [
                'question' => $question->question,
                'options' =>  $question->options,
            ],
            'total_questions' => $this->exam->questions()->count(),
            'completed_percentage' => (int)((count($this->submission->answers ?? []) / $this->exam->questions()->count()) * 100),
        ];


        return view('exam', $data);
    }

    public function start_exam()
    {
        if ($response = $this->verify())
        {
            return $response;
        }

        $questions = [];

        foreach ($this->exam->questions as $question)
        {
            $questions[$question->number] = [
                'question' => $question->question,
                'options' => $question->options,
                'marks' => $question->marks,
            ];
        }

        if (is_null($this->submission->started_at)) {
            $this->submission->update(
                [
                    'started_at' => now(),
                ]
            );
        }

        return [
            'status' => 'success',
            'questions' => $questions,
        ];
    }


    public function current_question_updater(Request $request)
    {
        if ($response = $this->verify())
        {
            return $response;
        }

        $this->submission->update(
            [
                'current_question' => $request->question_id,
            ]
        );

        return [
            'status' => 'success',
        ];
    }


    public function bookmark(Request $request)
    {
        if ($response = $this->verify())
        {
            return $response;
        }

        if ($request->action === 'add')
        {
            $bookmarks = $this->submission->bookmarks;
            if (($key = array_search($request->question, $bookmarks ?? [])) !== false) {
                unset($bookmarks[$key]);
            }

            $this->submission->update(
                [
                    'bookmarks' => $bookmarks,
                ]
            );
        }
        elseif($request->action === 'remove'){
            $bookmarks = $this->submission->bookmarks;
            if ((array_search($request->question, $bookmarks ?? [])) !== false) {
                $bookmarks[] = $request->question;
            }

            $this->submission->update(
                [
                    'bookmarks' => $bookmarks,
                ]
            );
        }

        return [
            'status' => 'success',
        ];
    }

    public function question_submission(SubmissionQuestionStoreRequest $request)
    {
        if ($response = $this->verify())
        {
            return $response;
        }

        if (!$question = $this->exam->getQuestionByNumber($request->question_id)) {
            return [
                'status' => 'error',
                'message' => 'Question not found',
            ];
        }

        if (!isset($question->options[$request->option_no])){
            return [
                'status' => 'error',
                'message' => 'Option not found',
            ];
        }

        $existing = $this->submission->answers ?? [];
        $existing[$request->question_id] = $request->option_no;

        $this->submission->update([
            'answers' =>  $existing,
        ]);

        return [
            'status' => 'success',
        ];
    }

    public function exam_submission()
    {
        if ($response = $this->verify())
        {
            return $response;
        }

        $marks = 0;
        foreach ($this->submission->answers as $question => $answer){
            if ($this->exam->getQuestionByNumber($question)->answer == $answer){
                $marks += $this->exam->getQuestionByNumber($question)->marks;
            }
        }

        $this->submission->update(
            [
                'marks' => $marks,
                'submitted_at' => now(),
            ]
        );

        return [
            'status' => 'success',
            'marks' => $marks,
            'total_marks' => $this->exam->total_marks,
        ];

    }

    public function verify($exam_id = null)
    {
        if (is_null($exam_id))
        {
            $exam_id = \request()->get('exam_id');
        }


        if (!$exam_id ||
            (!$this->exam = Exam::find($exam_id)) ||
            !auth()->user()->enrolledExams()->where('exam_student.exam_id',$this->exam->id)->exists())
        {
            abort(401);
        }

        if ($this->submission = auth()->user()->submissions()->firstWhere('exam_id', $exam_id)){
            if ($this->submission->submitted_at || ($this->submission->started_at && $this->submission->started_at->addMinutes($this->exam->total_time + 2) < now())) {
                return [
                    'status' => 'error',
                    'message' => 'Sorry! Exam Ended!',
                ];
            }
        }
        else{
            auth()->user()->submissions()->create(
                [
                    'exam_id' => $this->exam->id,
                ]
            );
            $this->submission = auth()->user()->submissions()->firstWhere('exam_id', $exam_id);
        }

        return false;
    }
}
