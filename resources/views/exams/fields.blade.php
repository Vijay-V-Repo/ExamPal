<div class="container">
    <div class="card3" style="text-align: center; height: auto">
        <h2 class="ml-5 pl-5" style="text-align: center;"> @if(Route::is('exams.create'))Create @else Edit @endif Exam</h2>
        <div class="col-md-10 text-center">
        <div class="form-group row justify-content-center">
            <label for="title" class="col-md-4 col-form-label text-right" style="font-size: 18px;line-height: 30px;font-weight: 600;color: #505050;">Exam Title: </label>
            <div class="col-md-4 px-0">
                <input required type="text" id="title" name="title" class="form-control " value="{{ old('title') ?? ((isset($exam) ? $exam->title : null)) }}">
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label for="guidelines" class="col-md-4 col-form-label text-right" style="font-size: 18px;line-height: 30px;font-weight: 600;color: #505050;">Guidelines/Instructions: </label>
            <div class="col-md-4 px-0">
                <textarea id="guidelines" name="guidelines" rows="3" cols="40" class="form-control">{{ old('guidelines') ?? ((isset($exam) ? $exam->guidelines : null)) }}</textarea>
            </div>
        </div>

        <div class="form-group row justify-content-end">
            <label for="total_time" class="col-md-4 col-form-label text-right" style="font-size: 18px;line-height: 30px;font-weight: 600;color: #505050;">Total Duration : </label>
            <div class="col-md-4 px-0">
                <input required type="number" id="total_time" name="total_time" class="form-control ml-2" value="{{ old('total_time') ?? ((isset($exam) ? $exam->total_time : null)) }}">
            </div>
            <span class="col-md-2 ml-1 text-left mt-2" style="font-size: 18px;line-height: 30px;font-weight: 600;color: #505050;">Minutes</span>
        </div>

        <div class="form-group row justify-content-center">
            <label for="start_after" class="col-md-4 col-form-label text-right" style="font-size: 18px;line-height: 30px;font-weight: 600;color: #505050;">Start After : </label>
            <div class="col-md-4 px-0">
                <input required type="datetime-local" class="form-control" id="start_after" name="start_after" value="{{ old('start_after') ?? ((isset($exam) ? $exam->start_after_field : null)) }}">
            </div>
        </div>

        <div class="form-group row justify-content-center">
            <label for="due" class="col-md-4 col-form-label text-right" style="font-size: 18px;line-height: 30px;font-weight: 600;color: #505050;">Due Before : </label>
            <div class="col-md-4 px-0">
                <input required type="datetime-local" class="form-control" id="due" name="due" value="{{ old('due') ?? ((isset($exam) ? $exam->due_field: null)) }}">
            </div>
        </div>


        <div class="form-group row justify-content-center">
            <label for="image" class="col-md-4 col-form-label text-right" style="font-size: 18px;line-height: 30px;font-weight: 600;color: #505050;">Image : </label>
            <div class="col-md-4 px-0 custom-file">
                <input type="file" class="custom-file-input" id="image" name="image">
                <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
            </div>
        </div>
        </div>

    </div><br>

    <div class="card2 mb-5">

        <div id="questions" style="text-align: center">
            <h2 style="text-align: center;" >Questions</h2>
            @if(isset($exam) && count($exam->questions))
                <input type="hidden" name="questions_count" id="questions_count" value="{{ count($exam->questions) }}">
                @foreach($exam->questions as $question)
                    <div id="q_{{ $question->number }}_question" class="col-md-10 text-center">
                        <h4 class="text-primary @if(!$loop->first) mt-5 @endif" style="margin-left: 9rem">Question {{ $question->number }}</h4>
                        <div class="form-group row justify-content-center">
                            <label for="question_{{ $question->number }}" class="col-md-4 col-form-label text-right" style="font-size: 18px;line-height: 30px;font-weight: 600;color: #505050;">Question :</label>
                            <div class="col-md-4 px-0">
                                <textarea required id="question_{{ $question->number }}" name="question_{{ $question->number }}" class="form-control ">{{ old('question_' . $question->number) ?? $question->question }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <label for="questions_{{ $question->number }}_marks" class="col-md-4 col-form-label text-right" style="font-size: 18px;line-height: 30px;font-weight: 600;color: #505050;">Marks :</label>
                            <div class="col-md-4 px-0">
                                <input required type="number" name="question_{{ $question->number }}_marks" id="questions_{{ $question->number }}_marks" class="form-control" value="{{ old('question_' . $question->number . '_marks')  ?? $question->marks}}">
                            </div>
                        </div>
                        <div id="q_{{ $question->number }}" class="col-md-12">
                            @foreach($question->options as $option_no => $option_value)
                                <div id="question_{{ $question->number }}_{{ $option_no }}" class="form-group row justify-content-center" style="margin-left: 8rem !important;">
                                    <div class="form-check">
                                        <input required type="radio" name="question_{{ $question->number }}_options" id="q_{{ $question->number }}_option_{{ $option_no }}" value="{{ $option_no }}" class="form-check-input ml-2" style="border: 0;width: 10%;height: 2em;" @if(!is_null(old('question_' . $question->number . '_options')) ? old('question_' . $question->number . '_options') == $option_no : $question->answer == $option_no) checked @endif>
                                        <label class="form-check-label" for="q_{{ $question->number }}_option_{{ $option_no }}">
                                            <input required type="text" name="question_{{ $question->number }}_{{ $option_no }}" placeholder="Option {{ $option_no }}" class="form-control ml-5" value="{{ old('question_' . $question->number . '_' . $option_no) ?? $option_value }}">
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if(count($question->options) < 4)
                            <button type="button" id="add-option-{{ $question->number }}" onclick="add_option({{ $question->number }})" class="btn btn-outline-dark my-2" style="margin-left: 9rem"><i class="fa fa-plus"></i> Add Option</button>
                        @endif
                        <input type="hidden" name="questions_{{ $question->number }}_options_count" id="questions_{{ $question->number }}_options_count" value="{{ count($question->options) }}">
                    </div>
                @endforeach

            @else
                <input type="hidden" name="questions_count" id="questions_count" value="1">
                <div id="q_1_question" class="col-md-10 text-center">
                    <h4 class="text-primary" style="margin-left: 9rem">Question 1</h4>
                    <div class="form-group row justify-content-center">
                        <label for="question_1" class="col-md-4 col-form-label text-right" style="font-size: 18px;line-height: 30px;font-weight: 600;color: #505050;">Question :</label>
                        <div class="col-md-4 px-0">
                            <textarea required id="question_1" name="question_1" class="form-control">{{ old('question_1') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row justify-content-center">
                        <label for="questions_1_marks" class="col-md-4 col-form-label text-right" style="font-size: 18px;line-height: 30px;font-weight: 600;color: #505050;">Marks :</label>
                        <div class="col-md-4 px-0">
                            <input required type="number" name="question_1_marks" id="questions_1_marks" class="form-control">
                        </div>
                    </div>
                    <div id="q_1" class="col-md-12">
                        <div id="question_1_1" class="form-group row justify-content-center" style="margin-left: 8rem !important;">
                            <div class="form-check">
                                <input required type="radio" name="question_1_options" id="q_1_option_1" value="1" class="form-check-input ml-2" style="border: 0;width: 10%;height: 2em;">
                                <label class="form-check-label" for="q_1_option_1">
                                    <input required type="text" name="question_1_1" placeholder="Option 1" class="form-control ml-5">
                                </label>
                            </div>
                        </div>
                        <div id="question_1_2" class="form-group row justify-content-center" style="margin-left: 8rem !important;">
                            <div class="form-check">
                                <input required type="radio" name="question_1_options" id="q_1_option_2" value="2" class="form-check-input ml-2" style="border: 0;width: 10%;height: 2em;">
                                <label class="form-check-label" for="q_1_option_2">
                                    <input required type="text" name="question_1_2" placeholder="Option 2" class="form-control ml-5">
                                </label>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-option-1" onclick="add_option(1)" class="btn btn-outline-dark my-2" style="margin-left: 9rem"><i class="fa fa-plus"></i> Add Option</button>
                    <input type="hidden" name="questions_1_options_count" id="questions_1_options_count" value="2">
                </div>
            @endif
        </div>
        <div class="text-center mt-3">
            <div class="btn-group col-md-6">
                <button type="button" id="add-question" class="btn btn-info" style="width: 5%; font-size: 1.25rem" onclick="add_question()"><i class="fa fa-plus"> Add Question!</i> </button><br><br>
                <button class="btn btn-primary ml-3" type="submit" style="width: 5%; font-size: 1.25rem">Save!</button>
            </div>
        </div>

    </div>
</div>

