function welcome() {
    console.log("Firing welcome")
    speak(messages.welcome);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "{{ route('submission.welcome') }}",
        data: {
            "exam_id": exam_id,
},
    type: "POST",
        success: function( response ) {
        if (response.status === "success"){
            transcript = '';
            start_recognition();
        }else if(response.status === "error"){
            speak(messages.ajaxError.replace(':error:', response.message))
        }
    }
})
}