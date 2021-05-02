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
    }

    recognition.addEventListener("end", endSpeechRecognition);
    function endSpeechRecognition() {
        console.log("Speech recognition service disconnected");
        start_recognition();
    }

    recognition.addEventListener("result", resultOfSpeechRecognition);
    function resultOfSpeechRecognition(event) {
        const current = event.resultIndex;
        if (synth.speaking){
            console.log("Currently speaking. Please speak after voice is ended")
            return;
        }
        transcript = event.results[current][0].transcript.toLowerCase().trim();

        if (is_stopped){
            if (!transcript.includes("start")) {
                speak(messages.recognitionStopped)
                return;
            }
            startRecognition();
            return;
        }
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
                // speak("Going to fire " + commands_array[$i][1])
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

function startRecognition() {
    recognition.start()
}

function stopRecognition() {
    recognition.stop()
}