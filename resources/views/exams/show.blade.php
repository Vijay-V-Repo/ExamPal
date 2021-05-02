@extends('layouts.main')

@section('title', $exam->title)

@section('content')
    <div class="container mb-5">
        <div class="card1 mb-5">
            <h2 style = "text-align: center;">Exam</h2>

            <div class="form-group row justify-content-center" style="margin-bottom: 0">
                <label for="title" class="col-md-6 col-form-label text-right px-0" style="font-size: 18px;line-height: 30px;font-weight: 600;color: #505050;">Title :</label>
                <div class="col-md-6 px-0 text-left">
                    <p class="mt-1 ml-2" style="font-size: 1.25rem">{{ $exam->title }}</p>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="margin-bottom: 0">
                <label for="guidelines" class="col-md-6 col-form-label text-right px-0" style="font-size: 18px;line-height: 30px;font-weight: 600;color: #505050;">Guidelines :</label>
                <div class="col-md-6 px-0 text-left">
                    <p class="mt-1 ml-2" style="font-size: 1.25rem">{!! $exam->guidelines !!}</p>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="margin-bottom: 0">
                <label for="total_time" class="col-md-6 col-form-label text-right px-0" style="font-size: 18px;line-height: 30px;font-weight: 600;color: #505050;">Total Duration :</label>
                <div class="col-md-6 px-0 text-left">
                    <p class="mt-1 ml-2" style="font-size: 1.25rem">{{ $exam->total_time }}<span class="ml-2" style="font-size: 18px;line-height: 30px;font-weight: 600;color: #505050;">Minutes</span></p>
                </div>
            </div>


            <div class="form-group row justify-content-center" style="margin-bottom: 0">
                <label for="start_after" class="col-md-6 col-form-label text-right px-0" style="font-size: 18px;line-height: 30px;font-weight: 600;color: #505050;">Start After :</label>
                <div class="col-md-6 px-0 text-left">
                    <p class="mt-1 ml-2" style="font-size: 1.25rem">{{ $exam->start_after }}</p>
                </div>
            </div>

            <div class="form-group row justify-content-center" style="margin-bottom: 0">
                <label for="due" class="col-md-6 col-form-label text-right px-0" style="font-size: 18px;line-height: 30px;font-weight: 600;color: #505050;">Due Before :</label>
                <div class="col-md-6 px-0 text-left">
                    <p class="mt-1 ml-2" style="font-size: 1.25rem">
                    {{ $exam->due }}
                </div>
            </div>

            @if(auth()->user()->isStudent() && is_null($submission))
                @if(\Carbon\Carbon::createFromFormat('d/m/Y  H:i', $exam->due)->isFuture())
                    <a href="{{ route('exam.start', $exam) }}" class="btn btn-primary px-5 ml-5" style="font-size: 1.25rem">Start Exam</a>
                @else
                    <span class="badge badge-danger ml-3" style="font-size: 1.25rem">Not Attended</span>
                @endif
            @endif

        </div>

        @if(!(auth()->user()->isStudent() && is_null($submission)))
            <div class="card2">
                @if(auth()->user()->isTeacher())
                    <div id="questions">
                        <h4 class="ml-5" style="text-align: center;">Questions</h4>
                        @foreach($exam->questions as $question)
                            <div id="q_{{ $question->number }}" class="mb-5">
                                <div class="form-group">
                                    <div class="row mb-2">
                                        <strong class="col-md-6" style="margin-left: 12rem">{{ $question->number }}. {{ $question->question }}</strong>
                                        <div class="col-md-2 text-left" style="margin-left: 4rem"><strong>{{ $question->marks }} marks </strong></div>
                                    </div>
                                    <ul class="list-group" style="margin-left: 12rem">
                                        @foreach($question->options as $option_no => $option_value)
                                            <li class="list-group-item col-md-10">{{ $option_no }}.  {{ $option_value }} @if($question->answer == $option_no) <i class="fa fa-check text-success ml-1 mt-1" style="font-size: 1.5rem"></i> @endif </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if(auth()->user()->isStudent())
                    @if(!is_null($submission))
                        @php($marked = $submission->answers ?? [])
                        <div id="questions">
                            <h2 class="text-center ml-3">Exam Results</h2>
                            <div class="form-group row justify-content-center" style="margin-bottom: 0">
                                <label class="col-md-6 col-form-label text-right px-0" style="font-size: 18px;line-height: 30px;font-weight: 600;color: #505050;">Submitted At :</label>
                                <div class="col-md-6 px-0 text-left">
                                    <p class="mt-1 ml-2" style="font-size: 1.25rem">
                                        {{ $submission->submitted_at ?? 'Auto Submitted' }}
                                    </p>
                                </div>
                            </div>
                            <div class="form-group row justify-content-center" style="margin-bottom: 0">
                                <label class="col-md-6 col-form-label text-right px-0" style="font-size: 18px;line-height: 30px;font-weight: 600;color: #505050;">Questions Attended :</label>
                                <div class="col-md-6 px-0 text-left">
                                    <p class="mt-1 ml-2" style="font-size: 1.25rem">
                                        {{ count($submission->answers ?? []) }} / {{ $exam->questions()->count() }}
                                    </p>
                                </div>
                            </div>
                            <div class="form-group row justify-content-center" style="margin-bottom: 0">
                                <label class="col-md-6 col-form-label text-right px-0" style="font-size: 18px;line-height: 30px;font-weight: 600;color: #505050;">Marks Scored :</label>
                                <div class="col-md-6 px-0 text-left">
                                    <p class="mt-1 ml-2" style="font-size: 1.25rem">
                                        {{ $submission->marks ?? 0 }} / {{ $exam->total_marks }}
                                    </p>
                                </div>
                            </div>
                            <h2 class="ml-5 mt-4 text-primary" style="text-align: center;">Questions</h2>
                            @foreach($exam->questions as $question)
                                <div id="q_{{ $question->number }}" class="mb-5">
                                    <div class="form-group">
                                        <div class="row mb-2">
                                            <strong class="col-md-6" style="margin-left: 12rem">{{ $question->number }}. {{ $question->question }}</strong>
                                            <div class="col-md-2 text-left" style="margin-left: 4rem"><strong>{{ $question->marks }} marks </strong></div>
                                        </div>
                                        <ul class="list-group" style="margin-left: 12rem">
                                            @foreach($question->options as $option_no => $option_value)
                                                <li class="list-group-item col-md-10">{{ $option_no }}.  {{ $option_value }} @if($question->answer == $option_no) <i class="fa fa-check text-success ml-1 mt-1" style="font-size: 1.5rem"></i>  @elseif(isset($marked[$question->number]) && $marked[$question->number] == $option_no)  <i class="fa fa-times text-danger ml-1 mt-1" style="font-size: 1.5rem"></i> @endif</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif
            </div>
        @endif
    </div>


@endsection

