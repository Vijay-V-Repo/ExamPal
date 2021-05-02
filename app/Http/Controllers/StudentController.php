<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'students' => User::students(),
        ];

        return view('students.index', $data);
    }

    /**
     * Assign an exam to the student
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assign_exam(Request $request)
    {
        $request->validate(
            [
                'student_id' => ['required', 'numeric'],
                'exam_id' => ['required', 'numeric'],
            ]
        );

        $student = User::findOrFail($request->student_id);

        if (!$student->isStudent()){
            abort(403);
        }

        if ($student->enrolledExams()->where('exam_student.exam_id', $request->exam_id)->exists()){
            return redirect()->back()->with(['danger' => 'Student already assigned to that exam']);
        }

        $student->enrolledExams()->attach($request->exam_id);
        return redirect()->back()->with(['success' => 'Student assigned to exam successfully']);
    }


}
