<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Quiz</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="{{ asset('assets/exam/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/exam/css/fontawesome-all.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/exam/css/style.css') }}">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body>

<!-- Top Bar -->

<div class="quiz-top-area text-center">

	<div style="float: left; padding-left: 50px; ">
		<div class="dropdown">
			<button onclick="open_dropdown()" class="dropbtn">
				<p style="text-align: center;"><i class='far fa-user-circle'></i></p>
			</button>
			<div id="Dropdown-info" class="dropdown-content">
				<a href="#home">Name : {{ auth()->user()->name }}</a>
				<a href="#about">Logout</a>
			</div>
		</div>
	</div>

	<div style="text-align: center; padding-right: 140px;">
		<h1> {{ $exam_title }} </h1>
	</div>

	<div class="quiz-countdown text-center ul-li">
		<ul>
			<li class="minutes">
				<span class="count-down-number" id="countdown_minutes"></span>
			</li>

			<li class="seconds">
				<span class="count-down-number" id="countdown_seconds"></span>
			</li>
		</ul>

	</div>

</div>

<!-- Top Bar Ends -->

<!-- Content Area Starts-->

<div class="wrapper position-relative">
	<div class="wizard-content-1 clearfix">
		<div class="step-inner-content clearfix position-relative">
			<!--Note-->

			<div class="form-area position-relative">
				<class class="wizard-forms clearfix position-relative">
					<div class="quiz-title text-center">

						<!--cards Area starts-->

						<!-- Guidelines Area - starts -->
						<div class="card1 my-5" id="before_start" style="width: 100%">
							<span>Guidelines</span>
							<p> {!! $guidelines !!} </p>
							<div style = "margin: auto;">
								<button class="button" type="button" onclick="welcome()">Start</button>
							</div> <br><br>
						</div>

						<!-- Guidelines Area Ends -->

						<div class="card-group d-none" id="after_start">

							<!-- Questions Navigation List Area - starts -->

							<div class="card1" style="padding: 40px 25px;">
								<div>
									<div style="padding-left: 7px;">
										<button class="button" style="float : left; ">Questions</button>
									</div>
									<br><br><br>
									<ul class="pagination pagination-lg">
										@for($i = 1; $i <= $total_questions; $i++)
											<li class="page-item @if($current_question === $i) disabled @endif" id="questions_list_question_{{ $i }}" onclick="gotoQuestion({{ $i }})">
												<a class="page-link" href="javascript:void(0);" id="questions_list_item_question_{{ $i }}" style="width: 65px; @if(array_key_exists($i, $marked)) background-color: #3fce2c;color: white @elseif(in_array($i, $bookmarks, false)) background-color: #f0fc03;color: white @endif">
													{{ $i }}
												</a>
											</li>
											@if(!($i % 3))
									</ul>
									<br>
									<ul class="pagination pagination-lg">
									@endif
									@endfor
								</div>
							</div>

							<!-- Questions Navigation List Area - Ends -->

							<!-- Question and Options Area - starts -->

							<div class="card2">

								<span>Question <span id="question_no">{{ $current_question }}</span></span>

								<p id="question">{{ $question['question'] }}</p>

								<div class="quiz-option-selector clearfix">
									<ul id="options">
										@foreach($question['options'] as $option => $value)
											<li>
												<label class="start-quiz-item">
													<input type="radio" name="question_{{ $current_question }}" id="question_{{ $current_question }}_option_{{ $option }}" value="{{ $value }}" onclick="markOption({{ $option }})" class="exp-option-box" @if(array_key_exists($current_question, $marked ?? []) && $marked[$current_question] == $option) checked @endif>
													<span class="exp-number text-uppercase">{{ $option }}</span>
													<span class="exp-label"> {{ $value }} </span>
													<span class="checkmark-border"></span>
												</label>
											</li>
										@endforeach
									</ul>
								</div>
							</div>
							<!-- Question and Options Area Ends -->
						</div>

						<!--cards Area Ends -->

					</div>
				</class>
			</div>

			<!-- Footer starts -->

			<div class="footer" id="before_start_footer">
				<div class="w3-light-grey w3-round-large"
					 style="width: 100%; margin: auto; border-top-style: outset; border-top-color: #999; border-top-width: 5px; box-shadow: 6px 0px #999;">
					<div class="w3-container  w3-round-large"
						 style="width: 100%; background-color: rgb(64, 216, 50); color:white; height: 20px;">
					</div>
				</div>
			</div>

			<div class="footer d-none" id="after_start_footer">

				<div class="w3-light-grey w3-round-large"
					 style="width: 80%; margin: auto; border-top-style: outset; border-top-color: #999; border-top-width: 3px; box-shadow: 6px 0px #999;">
					<div class="w3-container  w3-round-large" id="completed_percentage"
						 style="width: {{ $completed_percentage }}%; background-color: rgb(64, 216, 50); color:white">{{ $completed_percentage }}%
					</div>
				</div>

				<div class="actions clearfix" style="padding-bottom: 20px; ">
					<ul>
						<li class="@if($current_question == 1) d-none @endif" id="prev_question_li">
							<span class="js-btn-next" onclick="previousQuestion()">Previous Question</span>
						</li>
						<li>
							<span id="next_question_span" class="js-btn-next" onclick="@if($current_question == $total_questions) submitExam() @else nextQuestion() @endif">@if($current_question == $total_questions)Submit! @else Next Question  @endif </span>
						</li>
					</ul>
				</div>

			</div>
		</div>
	</div>
</div>

<!-- Content Area Ends -->

<!-- Drop Down - Account Info - starts -->

<script src="{{ asset('assets/exam/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('assets/exam/js/bootstrap.min.js') }}"></script>

<script>
	function open_dropdown() {
		if ($('#Dropdown-info').hasClass('show'))
		{
			$('#Dropdown-info').removeClass('show')
		}
		else{
			$('#Dropdown-info').addClass('show')
		}
	}

</script>

<script>

	var current_question = {{ $current_question }};
	var transcript = '';
	var exam_id = {{ $exam_id }}
	var exam_started = {{ $exam_started }}
	var exam_start_time = {!! $start_time ? 'new Date("' . $start_time->format(' Y m d H:i:s') . '")' : 'false' !!}
	var total_exam_time = {{ $total_exam_time }}
	var total_questions = {{ $total_questions }}
	var remaining_secs;
	var is_voice_recognition_active = false
	var is_welcomed = false
	var end_said_count = 0
	var guidelines = "{!! str_replace("\r\n", '', $guidelines) !!}"
	var marked = {!! $marked ? json_encode($marked) : '{}' !!}
	var questions = {}
	var messages = JSON.parse('{!! json_encode($messages) !!}')
	var commands = {!! json_encode($commands) !!}
	var bookmarks = [ @if(isset($bookmarks) && count($bookmarks)) @foreach($bookmarks as $bookmark) {{$bookmark . ', '}}@endforeach @endif]
	var alert_audio = new Audio('{{ asset('assets/main/mic_alert.wav') }}')


	$(function () {
		if (exam_started){
			remaining_secs = Math.round((total_exam_time * 60) - ((new Date() - exam_start_time) / 1000))
			timer()
		}

	})

	$(document).keyup(function(e) {
		if (e.key === "Escape") {
			if (!is_welcomed){
				return
			}
			stopRecognition()
		}
	});

	$(document).keydown(function(e) {
		if (e.key === "Escape") {
			if (!is_welcomed){
				welcome();
				return
			}
			startRecognition();
		}
	});





	/****** Speech Synthesis ******/
	const synth = window.speechSynthesis;
	var voices = [];

	const getVoices = () => {
		voices = synth.getVoices();
	};

	if (synth.onvoiceschanged !== undefined) {
		synth.onvoiceschanged = getVoices;
	}


	function speak(text) {

		const speakText = new SpeechSynthesisUtterance(text);

		voices.forEach(voice => {
			if (voice.lang == 'en-US') {
				speakText.voice = voice;
				return
			}
		});

		if (synth.speaking) {
			// console.error('Already speaking...');
		}

		speakText.onerror = e => {
			console.error('Something went wrong');
		};

		speakText.onstart = e => {
			console.log("Speaking " + text)

		}

		speakText.rate = 0.9
		synth.speak(speakText);
	}





	/****** Speech Recognition ******/
	const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

	if(SpeechRecognition) {
		console.log("Your Browser supports speech Recognition");

		var recognition = new SpeechRecognition();
		recognition.continuous = false;
		recognition.lang = 'en-US';
		recognition.continuous = true;

		recognition.addEventListener("start", startSpeechRecognition);

		function startSpeechRecognition() {
			console.log("Voice activated, SPEAK");
			alert_audio.play()
		}

		recognition.addEventListener("end", endSpeechRecognition);
		function endSpeechRecognition() {
			console.log("Speech recognition service disconnected");
			alert_audio.play()
		}

		recognition.addEventListener("result", resultOfSpeechRecognition);
		function resultOfSpeechRecognition(event) {
			const current = event.resultIndex;

			if (synth.speaking){
				console.log("Currently speaking. Please speak after voice is ended")
				return;
			}

			transcript = event.results[current][0].transcript.toLowerCase().trim();

			textToSpeak = "You said " + transcript
			speak(textToSpeak)
			console.log(textToSpeak)

			var commands_array = Object.keys(commands).map((key) => [String(key), commands[key]]);
			let flag = false
			for (let $i = 0; $i < commands_array.length; $i++) {
				if (transcript.includes(commands_array[$i][0])) {
					flag = true
					console.log("Going to fire " + commands_array[$i][1])
					if (!exam_started){
						if (!(commands_array[$i][1] === 'startExam' || commands_array[$i][1] === 'readGuidelines')){
							speak("Exam not started yet!")
							return;
						}
					}

					if (end_said_count && !(transcript.includes('end') || transcript.includes('submit'))){
						end_said_count = 0;
					}

					window[commands_array[$i][1]]();
					return;
				}
			}

			if (!flag){
				speak(messages.retrySpeech)
			}
		}

	}
	else {
		console.log("Your Browser does not support speech Recognition");
	}



	function welcome() {
		console.log("Welcome To Exam :)")
		is_welcomed = true
		speak(messages.welcome);

		if (!exam_started){
			speak("These are the guidelines given. They are, " + guidelines.replace(/(<([^>]+)>)/ig, ''))
		}
		else {
			startExam();
		}
	}


	function startRecognition() {
		if (!synth.speaking && !is_voice_recognition_active) {
			is_voice_recognition_active = true
			transcript = '';
			recognition.start()
		}
	}


	function stopRecognition() {
		if (is_voice_recognition_active){
			recognition.stop()
			is_voice_recognition_active = false
		}
	}


	function startExam() {
		$('#before_start').addClass('d-none')
		$('#before_start_footer').addClass('d-none')
		$('#after_start').removeClass('d-none')
		$('#after_start_footer').removeClass('d-none')

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			url: "{{ route('submission.start_exam') }}",
			data: {
				"exam_id": exam_id,
			},
			type: "POST",
			success: function( response ) {

				if (response.status === "success"){
					if (!exam_started){
						remaining_secs = total_exam_time * 60
						timer()
					}

					questions = response.questions
					exam_started = true
					readQuestion();
				}
				else if(response.status === "error"){
					speak(messages.ajaxError.replace(':error:', response.message))
				}
			}
		})
	}


	function readOptions() {
		let options_array = Object.keys(questions[current_question.toString()]["options"]).map((key) => [String(key), questions[current_question.toString()]["options"][key]]);

		for (let $i = 0; $i < options_array.length; $i++) {
			speak(messages.readOptions.replace(":option:", options_array[$i][0]).replace(":option_value:", options_array[$i][1]))
		}

		if (marked[current_question.toString()] !== undefined){
			speak(messages.questionAlreadyMarked.replace(":option:", marked[current_question.toString()]).replace(":option_value:", questions[current_question.toString()]["options"][marked[current_question.toString()]]))
		}
	}


	function readQuestion() {
		var question_no = current_question.toString()
		var question = questions[question_no]

		speak(messages.readQuestion.replace(":question_number:", " " + question_no + " ").replace(":question:", question.question).replace(':marks:', question.marks))

		readOptions();
	}

	function changeQuestionHTML(previous_question) {
		$('#questions_list_question_' + previous_question).removeClass('disabled')
		$('#questions_list_question_' + current_question).addClass('disabled')

		$('#question_no').html(current_question);
		$('#question').html(questions[current_question.toString()]['question']);

		let html = ''
		let options_array = Object.keys(questions[current_question.toString()]["options"]).map((key) => [String(key), questions[current_question.toString()]["options"][key]]);

		for (let $i = 0; $i < options_array.length; $i++) {
			html += '<li>'
			html += '<label class="start-quiz-item">'
			html += `<input type="radio" name="question_${current_question}" id="question_${current_question}_option_${options_array[$i][0]}" value="${options_array[$i][0]}" class="exp-option-box" onclick="markOption(${options_array[$i][0]})">`
			html +=	`<span class="exp-number text-uppercase">${options_array[$i][0]}</span>`
			html +=	`<span class="exp-label"> ${options_array[$i][1]} </span>`
			html += '<span class="checkmark-border"></span>'
			html += '</label>'
			html += '</li>'
		}

		$('#options').html(html)

		if (marked[current_question.toString()] !== undefined){
			$('#question_' + current_question + '_option_' + marked[current_question.toString()]).prop("checked", true).change();
		}

		if (current_question == total_questions){
			$('#next_question_span').html('Submit!')
			$('#next_question_span').attr('onclick', 'submitExam()')
		}
		else{
			$('#next_question_span').html('Next Question ')
			$('#next_question_span').attr('onclick', 'nextQuestion()')
		}

		if (current_question == 1){
			$("#prev_question_li").addClass('d-none')
		}
		else {
			$("#prev_question_li").removeClass('d-none')
		}

		currentQuestionUpdater();
	}

	function currentQuestionUpdater() {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			url: "{{ route('submission.current_question') }}",
			data: {
				"exam_id": exam_id,
				"question_id": current_question,
			},
			type: "POST",
			success: function( response ) {
				if (response.status === "success"){
					return;
				}else if(response.status === "error"){
					speak(messages.ajaxError.replace(':error:', response.message))
				}
			}
		})
	}


	function nextQuestion() {
		if (questions[(current_question+1).toString()] === undefined){
			speak(messages.questionsEnded);
			return;
		}
		speak("Going to next question")
		setTimeout(function(){
			current_question++;
			readQuestion();
			changeQuestionHTML(current_question - 1);

		}, 3500);
	}


	function previousQuestion() {
		if (questions[(current_question-1).toString()] === undefined){
			speak(messages.noPreviousQuestion);
			return;
		}
		speak("Going to previous question")
		setTimeout(function(){
			current_question--;
			changeQuestionHTML(current_question + 1);
			readQuestion();
		}, 3500);
	}



	function markOption(option = null) {
		if (option === null){
			option = transcript.replace("one", '1').replace("two", '2').replace("to", '2').replace("three", '3').replace("four", "4").match(/\b[1234]{1}\b/i);
			if (option === null) {
				speak(messages.optionInvalid);
				readOptions();
				return;
			}
			option = option[0];

			if (questions[current_question.toString()]["options"][option] === undefined) {
				speak(messages.optionNotFound.replace(':option:', option));
				readOptions();
				return;
			}
		}

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			url: "{{ route('submission.question_submission') }}",
			data: {
				"exam_id": exam_id,
				"question_id": current_question,
				"option_no": option
			},
			type: "POST",
			success: function( response ) {
				if (response.status === "success"){
					setTimeout(function(){
						marked[current_question] = option;
						$('#question_' + current_question + '_option_' + marked[current_question.toString()]).prop("checked", true).change();
						speak(messages.markOption.replace(':option:', option).replace(':question_no:', current_question.toString()).replace(':value:', questions[current_question.toString()]["options"][option]));
						setTimeout(function(){
							nextQuestion();
							let completed_percentage = Math.floor((Object.keys(marked).length / total_questions) * 100)
							$("#completed_percentage").css('width', `${completed_percentage}%`)
							$("#completed_percentage").html(`${completed_percentage}%`)
							$("#questions_list_item_question_" + current_question.toString()).css('background-color', '#3fce2c')
							$("#questions_list_item_question_" + current_question.toString()).css('color', 'white')
						}, 2500);
					}, 1500);
				}else if(response.status === "error"){
					speak(messages.ajaxError.replace(':error:', response.message))
				}
			}
		})
	}

	function gotoQuestion(question_number = null) {
		if (question_number == null){
			question_number = wordToNumber(transcript).match(/\b\d{1,2}\b/i)
			if (question_number === null) {
				speak(messages.questionInvalid);
				return;
			}

			question_number = question_number[0]
		}

		if (questions[question_number] === undefined){
			speak(messages.questionNotFound.replace(':question_no:', question_number).replace(':last_question_number:', Object.keys(questions).length.toString()));
			return;
		}

		setTimeout(function(){
			speak(messages.gotoQuestion.replace(':question_no:', question_number));
			let previous_question = current_question
			current_question = Number(question_number)
			changeQuestionHTML(previous_question);
			readQuestion();
		}, 4500);
	}

	function wordToNumber(str) {
		let units = ['PLACEHOLDER', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];

		let tens = ['PLACEHOLDER', 'PLACEHOLDER', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

		let flag = false

		tens.forEach((ten, index) => {
			if (str.includes(ten)) {
				units.forEach((unit, i) => {
					if (str.includes(unit)) {
						str = str.replace(ten + ' ' + unit, index.toString() + i.toString())
						flag = true
					}
				})
				if (!flag) {
					str = str.replace(ten, index + '0')
				}
				flag = true
				return;
			}
		})

		if (!flag) {
			units.forEach((unit, i) => {
				if (str.includes(unit)) {
					str = str.replace(unit, i.toString());
					return;
				}
			});
		}

		return str
	}


	function endExam() {
		end_said_count += 1
		if (end_said_count >= 3){
			submitExam();
		}
		else {
			speak(messages.stopExamSayCount.replace(':times:', end_said_count === 2 ? ` 1 more time` : `2 more times`))
		}
	}

	function submitExam() {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			url: "{{ route('submission.exam_submission') }}",
			data: {
				"exam_id": exam_id,
			},
			type: "POST",
			success: function( response ) {
				if (response.status === "success"){
					setTimeout(function(){
						speak(messages.examSubmit.replace(':marks:', response.marks).replace(':total_marks:', response.total_marks))
					}, 2000);

					$('#before_start').html('<h2 class="mt-5"><br><br><br>Hoooooooooooyah! <br>You have scored ' + response.marks + '/ ' + response.total_marks + '<h2>')


					$('#after_start').addClass('d-none')
					$('#after_start_footer').addClass('d-none')
					$('#before_start').removeClass('d-none')
					$('#before_start_footer').removeClass('d-none')
					$('#countdown_minutes').html('')
					$('#countdown_seconds').html('')
				}
			}
		})
	}


	function bookmarkQuestion() {
		let flag = false
		bookmarks.forEach(bookmark => {
			if (bookmark === current_question){
				flag = true
				return;
			}
		})
		if (flag)
		{
			speak(messages.alreadyBookmarked.replace(":question_no:", current_question.toString()));
			return;
		}


		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			url: "{{ route('submission.bookmark') }}",
			data: {
				"exam_id": exam_id,
				"action": 'add',
				"question": current_question
			},
			type: "POST",
			success: function( response ) {
				if (response.status === "success"){
					setTimeout(function(){
						speak(messages.bookmarkQuestion.replace(":question_no:", current_question.toString()));
						bookmarks.push(current_question);
						if (marked[current_question.toString()] === undefined)
						{
							$("#questions_list_item_question_" + current_question.toString()).css('background-color', '#f0fc03')
							$("#questions_list_item_question_" + current_question.toString()).css('color', 'white')
						}
					}, 1500);
				}else if(response.status === "error"){
					speak(messages.ajaxError.replace(':error:', response.message))
				}
			}
		})
	}


	function removeBookmarkQuestion() {
		flag = false
		bookmarks.forEach(bookmark => {
			if (bookmark === current_question){
				flag = true
				return;
			}
		})
		if (!flag){
			speak(messages.notBookmarked.replace(":question_no:", current_question.toString()));
			return;
		}

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			url: "{{ route('submission.bookmark') }}",
			data: {
				"exam_id": exam_id,
				"action": 'remove',
				"question": current_question
			},
			type: "POST",
			success: function( response ) {
				if (response.status === "success"){
					setTimeout(function(){
						speak(messages.bookmarkRemoved.replace(":question_no:", current_question.toString()));
						bookmarks.splice($.inArray(current_question, bookmarks), 1);
						if (marked[current_question.toString()] === undefined) {
							$("#questions_list_item_question_" + current_question.toString()).css('background-color', '')
							$("#questions_list_item_question_" + current_question.toString()).css('color', '')
						}
					}, 1500);
				}else if(response.status === "error"){
					speak(messages.ajaxError.replace(':error:', response.message))
				}
			}
		})

	}

	function readBookmarks() {
		if (!bookmarks.length){
			speak(messages.noBookmarks)
			return;
		}
		speak(messages.readBookmarksBefore.replace(":bookmarks_count:", bookmarks.length));
		bookmarks.forEach(bookmark => {
			speak(messages.readBookmark.replace(":question_no:", bookmark));
		})
	}


	function timer() {
		var timer = setInterval(function() {
			let mins = Math.floor(remaining_secs / 60)
			let secs = remaining_secs % 60

			$('#countdown_minutes').html(mins)
			$('#countdown_seconds').html(secs)

			remaining_secs--
			if (remaining_secs < 0 || end_said_count >=3) {
				clearInterval(timer);
				setTimeout(function () {
					submitExam()
				}, 1000)
			}

			if (remaining_secs === 5 * 60 || remaining_secs === 2 * 60){
				speak(messages.timeRemainingAlert.replace(':minutes:', remaining_secs / 60))
			}

			if (remaining_secs === 60 || remaining_secs === 30){
				speak(messages.fewSecondsRemaining.replace(':seconds:', remaining_secs));
			}
		}, 1000)
	}

</script>
</body>
</html>