@extends('layouts.main')

@section('title', 'Students')

@section('content')
    <div class="card3">
        <table class="table table-bordered" style="border: 2px solid #0c8b51;">
            <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>E-mail Address</th>
                <th> Action </th>
            </tr>
            </thead>
            <tbody>
            @foreach($students as $student)
                <tr>
                    <td><img src="{{ $student->avatar }}" class="img-thumbnail rounded-circle" width="100px" height="100px" alt="Avatar" ></td>
                    <td style="padding-top: 2.5rem !important;">{{ $student->name }}</td>
                    <td style="padding-top: 2.5rem !important;">{{ $student->email }}</td>
                    <td style="padding-top: 2.5rem !important;">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#assign-modal" data-student-id="{{ $student->id }}">
                            Assign Exam
                        </button>
                    </td>
            @endforeach
            </tbody>
        </table>
    </div>


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
                        <input type="hidden" name="student_id" id="student_id" value><br><br>
                        <div class="row justify-content-center">
                        <button class="btn btn-primary px-3 mr-2">Assign!</button>
                        <button type="button" class="btn btn-secondary px-3 ml-2" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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