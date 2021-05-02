<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamRequest;
use App\Models\Exam;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data = [
            'exams' => auth()->user()->exams,
        ];

        return view('exams.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('exams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ExamRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ExamRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('images/exams', 'public');
        }
        $exam = Exam::create($data + ['created_by' => auth()->id()]);

        $marks = 0;

        foreach ($request->questions as $n => $q){
            $data = [
                'question' => $q['question'],
                'number' => $n,
                'marks' => $q['marks'],
                'answer' => $q['answer'],
            ];
            $marks += $q['marks'];
            foreach ($q['options'] as $o_n => $o){
                $data['option' . $o_n] = $o;
            }
            $exam->questions()->create($data);
        }

        $exam->update(['total_marks' => $marks]);

        session()->flash('success', 'Exam Stored Successfully');
        return redirect()->route('exams.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Exam $exam)
    {

        if (auth()->user()->isStudent()) {
            $submission = auth()->user()->submissions()->firstWhere('exam_id',$exam->id);
            if (!($submission &&
                ($submission->submitted_at ||
                    ($submission->started_at && $submission->started_at->addMinutes($exam->total_time + 2) < now())
                )))
            {
                $submission = null;
            }

            if ($submission && is_null($submission->marks)){
                $marks = 0;
                foreach ($submission->answers as $question => $answer){
                    if ($exam->getQuestionByNumber($question)->answer == $answer){
                        $marks += (int)$exam->getQuestionByNumber($question)->marks;
                    }
                }

                $submission->update(
                    [
                        'marks' => $marks,
                    ]
                );
            }
        }
        else{
            $submission = null;
        }


        $data = [
            'exam' => $exam,
            'submission' => $submission,
        ];

        return view('exams.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Exam $exam)
    {
        $data = [
            'exam' => $exam,
        ];

        return view('exams.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ExamRequest $request
     * @param \App\Models\Exam $exam
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ExamRequest $request, Exam $exam)
    {
        $data = $request->validated();

        if ($request->hasFile('image')){
            if (!is_null($exam->image) && file_exists(public_path($exam->image))) {
                unlink(public_path($exam->image));
            }
            $data['image'] = $request->file('image')->store(public_path('storage/images/exams'));
        }
        $exam->update($data);

        $exam->questions()->delete();

        $marks = 0;

        foreach ($request->questions as $n => $q){
            $data = [
                'question' => $q['question'],
                'number' => $n,
                'marks' => $q['marks'],
                'answer' => $q['answer'],
            ];
            $marks += $q['marks'];
            foreach ($q['options'] as $o_n => $o){
                $data['option' . $o_n] = $o;
            }
            $exam->questions()->create($data);
        }

        $exam->update(['total_marks' => $marks]);

        session()->flash('success', 'Exam Updated Successfully');
        return redirect()->route('exams.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exam $exam)
    {
        $exam->questions()->delete();
        $exam->delete();

        session()->flash('success', 'Exam Deleted Successfully');
        return redirect()->route('exams.index');
    }
}
