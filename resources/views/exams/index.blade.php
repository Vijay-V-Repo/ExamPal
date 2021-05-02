@extends('layouts.main')

@section('title', 'Exams')

@section('content')
    <div class = "card3">
        <div class="text-right">
            <a href="{{ route('exams.create') }}" class="btn btn-primary mb-3">Create New Exam</a>
        </div>
        <table class="table table-bordered" style="border: 2px solid #0c8b51;">
            <thead>
            <tr>
                <th></th>
                <th>Title</th>
                <th>Total Time</th>
                <th>Total Marks</th>
                <th>Start after</th>
                <th>Due before</th>
                <th>Total questions</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($exams as $exam)
                <tr>
                    <td><img src="{{ $exam->image }}" class="img-thumbnail" width="100px" height="100px" alt="Exam Image"></td>
                    <td style="padding-top: 2.5rem !important;">{{ $exam->title }}</td>
                    <td style="padding-top: 2.5rem !important;">{{ $exam->total_time }}</td>
                    <td style="padding-top: 2.5rem !important;">{{ $exam->total_marks }}</td>
                    <td style="padding-top: 2.5rem !important;">{{ $exam->start_after }}</td>
                    <td style="padding-top: 2.5rem !important;">{{ $exam->due }}</td>
                    <td style="padding-top: 2.5rem !important;">{{ $exam->questions()->count() }}</td>
                    <td style="padding-top: 2.5rem !important;">
                        <div class="btn-group" style="margin-right: 0; margin-left: 0">
                            <a href="{{ route('exams.show', $exam) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                            @if(auth()->user()->isTeacher())
                                <a href="{{ route('exams.edit', $exam) }}" class="btn btn-warning ml-4" ><i class="fa fa-pencil-square"></i> </a>
                                <form method="post" action="{{ route('exams.destroy', $exam) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger ml-4" type="submit"><i class="fa fa-trash"></i></button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

