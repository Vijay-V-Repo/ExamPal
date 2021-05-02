@extends('layouts.main')

@section('title', 'Edit Exam')

@section('content')
    <form action="{{ route('exams.update', $exam) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')
        @foreach($errors->all() as $error)
            {{ $error }}
        @endforeach
        @include('exams.fields')
    </form>
@endsection

@push('js')
    <script>
        var no_of_questions = {{ isset($exam) ? count($exam->questions) : 1 }}

        function add_question()
        {
            no_of_questions++

            $("#questions_count").attr('value', no_of_questions)

            let html = ''
            html += `<div id="q_${no_of_questions}_question" class="col-md-10 text-center">`
            html += `<h4 class="text-primary mt-5" style="margin-left: 9rem">Question ${no_of_questions}</h4>`
            html += `<div class="form-group row justify-content-center">`
            html += `<label for="question_${no_of_questions}" class="col-md-4 col-form-label text-right" style="font-size: 18px;line-height: 30px;font-weight: 600;color: #505050;">Question :</label>`
            html += `<div class="col-md-4 px-0">`
            html += `<textarea required id="question_${no_of_questions}" name="question_${no_of_questions}" class="form-control"></textarea>`
            html += `</div>`
            html += `</div>`
            html += `<div class="form-group row justify-content-center">`
            html += `<label for="questions_${no_of_questions}_marks" class="col-md-4 col-form-label text-right" style="font-size: 18px;line-height: 30px;font-weight: 600;color: #505050;">Marks :</label>`
            html += `<div class="col-md-4 px-0">`
            html += `<input required type="number" name="question_${no_of_questions}_marks" id="questions_${no_of_questions}_marks" class="form-control">`
            html += `</div>`
            html += `</div>`
            html += `<div id="q_${no_of_questions}" class="col-md-12">`
            html += `<div id="question_${no_of_questions}_1" class="form-group row justify-content-center" style="margin-left: 8rem !important;">`
            html += `<div class="form-check">`
            html += `<input required type="radio" name="question_${no_of_questions}_options" id="q_${no_of_questions}_option_1" value="1" class="form-check-input ml-2" style="border: 0;width: 10%;height: 2em;">`
            html += `<label class="form-check-label" for="q_${no_of_questions}_option_1">`
            html += `<input required type="text" name="question_${no_of_questions}_1" placeholder="Option 1" class="form-control ml-5">`
            html += `</label>`
            html += `</div>`
            html += `</div>`
            html += `<div id="question_${no_of_questions}_2" class="form-group row justify-content-center" style="margin-left: 8rem !important;">`
            html += `<div class="form-check">`
            html += `<input required type="radio" name="question_${no_of_questions}_options" id="q_${no_of_questions}_option_2" value="2" class="form-check-input ml-2" style="border: 0;width: 10%;height: 2em;">`
            html += `<label class="form-check-label" for="q_${no_of_questions}_option_2">`
            html += `<input required type="text" name="question_${no_of_questions}_2" placeholder="Option 2" class="form-control ml-5">`
            html += `</label>`
            html += `</div>`
            html += `</div>`
            html += `</div>`
            html += `<button type="button" id="add-option-${no_of_questions}" onclick="add_option(${no_of_questions})" class="btn btn-outline-dark my-2" style="margin-left: 9rem"><i class="fa fa-plus"></i> Add Option</button>`
            html += `<input type="hidden" name="questions_${no_of_questions}_options_count" id="questions_${no_of_questions}_options_count" value="2">`
            html += `</div>`

            $('#questions').append(html)
        }

        function add_option(question) {
            let current_options = $('[id^="question_' + question + '_"]').length

            if (current_options === 4){
                console.log('Only 4 options per question is allowed')
                return
            }

            current_options++
            $("#questions_" + question + "_options_count").attr('value', current_options)

            let html = ''
            html += `<div id="question_${question}_${current_options}" class="form-group row justify-content-center" style="margin-left: 8rem !important;">`
            html += `<div class="form-check">`
            html += `<input required type="radio" name="question_${question}_options" id="q_${question}_option_${current_options}" value="${current_options}" class="form-check-input ml-2" style="border: 0;width: 10%;height: 2em;">`
            html += `<label class="form-check-label" for="q_${question}_option_${current_options}">`
            html += `<input required type="text" name="question_${question}_${current_options}" placeholder="Option ${current_options}" class="form-control ml-5">`
            html += `</label>`
            html += `</div>`
            html += `</div>`
            $("#q_" + question).append(html)
            if (current_options >= 4){
                $('#add-option-' + question.toString()).fadeOut('slow')
            }
        }
    </script>
@endpush