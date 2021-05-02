const synth = window.speechSynthesis;

var voices = [];

const getVoices = () => {
    voices = synth.getVoices();
};

if (synth.onvoiceschanged !== undefined) {
    synth.onvoiceschanged = getVoices;
}


// Speak
function speak(text) {
    if (synth.speaking) {
        // console.error('Already speaking...');
    }

    // Get speak text
    const speakText = new SpeechSynthesisUtterance(text);
    speakText.onstart = e => {
        console.log("Speaking " + text)

    }

    // Speak end
    speakText.onend = e => {
        // console.log('Done speaking...');
        // start_recognition_again();
    };

    // Speak error
    speakText.onerror = e => {
        console.error('Something went wrong');
    };

    // Loop through voices
    voices.forEach(voice => {
        if (voice.lang == 'en-US') {
            speakText.voice = voice;
            return
        }
    });

    // Speak
    speakText.rate = 0.9
    synth.speak(speakText);
}
