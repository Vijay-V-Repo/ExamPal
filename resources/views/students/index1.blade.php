@extends('layouts.main')

@section('title', 'Students')

@section('content')
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>{{--Image col --}}</th>
            <th>Name</th>
            <th>E-mail Address</th>
            <th>{{-- Invite Col --}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($students as $student)
            <tr>
                <td><img src="{{ $student->avatar }}" class="image rounded-circle" ></td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#assign-modal" data-student-id="{{ $student->id }}">
                        Assign Exam
                    </button>
                </td>
        @endforeach
        </tbody>
    </table>

    @if(auth()->user()->isTeacher())
        <div class="modal fade" id="assign-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Assign Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('students.assign_exam') }}">
                            @csrf
                            <select name="exam_id" class="form-control custom-select" required>
                            <option value>Select an Exam</option>
                            @foreach(\App\Models\Exam::assign_exam_dropdown() as $exam)
                                <option value="{{ $exam->id }}">{{ $exam->title }}</option>
                            @endforeach
                            </select>
                            <input type="hidden" name="student_id" id="student_id" value>
                            <button class="btn btn-primary">Assign!</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@push('js')
@if(auth()->user()->isTeacher())
<script>
    $('#assign-modal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget)
        $('#student_id').val(button.data('student-id'))
    })
</script>
@endif
@endpush