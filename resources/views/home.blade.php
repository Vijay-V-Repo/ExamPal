@extends('layouts.main')

@section('title', 'Home')

@section('content')
    <div>
        <div class="container">
            <div class="row mt-3">
                <div class="col-lg-6 pr-0 pt-5 mt-3">
                    <div>
                        <h1>Exams<br>For<br>EveryOne!
                        </h1>
                        <div>
                            <a class="btn btn-success px-4 py-2" style="background-color: #0c8b51;font-size: 18px;line-height: 38px;font-weight: 800" href="{{ route('register') }}">GET STARTED</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 pl-5" style="margin-top: 6rem">
                    <div class="pl-5">
                        <img style="-webkit-animation: mover 6s infinite  alternate;animation: mover 6s infinite  alternate;" src="{{ ('assets/main/images/test12345.gif') }}" alt="Exam GIF">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection