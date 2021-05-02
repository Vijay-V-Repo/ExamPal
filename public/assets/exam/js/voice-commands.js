function startExam() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "{{ route('submission.start_exam') }}",
        data: {
            "exam_id": exam_id
        },
        type: "POST",
        success: function( response ) {
            if (response.status === "success"){
                // speak(messages.markOption.replace(':option:', option).replace(':question_no:', current_question.toString()).replace(':value:', questions[current_question.toString()]["options"][option]));
                questions = response.questions
                exam_started = true
            }else if(response.status === "error"){
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
    speak(messages.readQuestion.replace(":question_number:", " " + question_no + " ").replace(":question:", question.question))

    readOptions();

}


function nextQuestion() {
    if (questions[(current_question+1).toString()] === undefined){
        speak(messages.questionsEnded);
        return;
    }
    speak("Going to next question")
    current_question++;
    readQuestion();
}


function previousQuestion() {
    if (questions[(current_question-1).toString()] === undefined){
        speak(messages.noPreviousQuestion);
        return;
    }
    speak("Going to previous question")
    current_question--;
    readQuestion();
}


function markOption() {
    let option = transcript.replace("one", '1').replace("two", '2').replace("to", '2').replace("three", '3').replace("four", "4").match(/\b[1234]{1}\b/i);
    if (option === null){
        speak(messages.optionInvalid);
        readOptions();
        return;
    }
    option = option[0];

    if (questions[current_question.toString()]["options"][option] === undefined){
        speak(messages.optionNotFound.replace(':option:', option));
        readOptions();
        return;
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
            speak(messages.markOption.replace(':option:', option).replace(':question_no:', current_question.toString()).replace(':value:', questions[current_question.toString()]["options"][option]));
            marked[current_question] = option;
            nextQuestion();
        }else if(response.status === "error"){
            speak(messages.ajaxError.replace(':error:', response.message))
        }
    }
})
}


function bookmarkQuestion() {
    flag = false
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
    speak(messages.bookmarkQuestion.replace(":question_no:", current_question.toString()));
    console.log("Bookmarking question " + current_question.toString());
    bookmarks.push(current_question);


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
    speak(messages.bookmarkRemoved.replace(":question_no:", current_question.toString()));
    console.log("Removing bookmark question " + current_question.toString());
    bookmarks.splice($.inArray(current_question, bookmarks), 1);



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




function gotoQuestion()
{
    let question_number = wordToNumber(transcript).match(/\b\d{1,2}\b/i)
    if (question_number === null){
        speak(messages.questionInvalid);
        return;
    }

    question_number = question_number[0]

    if (questions[question_number]=== undefined){
        speak(messages.questionNotFound.replace(':question_no:', question_number).replace(':last_question_number:', Object.keys(questions).length.toString()));
        return;
    }


    speak(messages.gotoQuestion.replace(':question_no:', question_number));
    current_question = Number(question_number)
    readQuestion();
}