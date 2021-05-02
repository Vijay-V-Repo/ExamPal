var start;
var interval;

function timer( endTime) {
	var countdownHours = document.querySelector('.hours .count-down-number');
	var countdownMinutes = document.querySelector('.minutes .count-down-number');
	var countdownSeconds = document.querySelector('.seconds .count-down-number');

		start = start + 1000;
		var duration = endTime - start;
		if (duration < 0 ){
			stopTimer();
			return
		}
		var hours = Math.floor((duration % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var minutes = Math.floor((duration % (1000 * 60 * 60)) / (1000 * 60));
		var seconds = Math.floor((duration % (1000 * 60)) / 1000);
		countdownHours.innerHTML = hours;
		countdownMinutes.innerHTML = minutes;
		countdownSeconds.innerHTML = seconds;
}

function stopTimer(){
	alert("Exam ended");
	console.log("exam end")
	clearInterval(interval);
}

function countdown(startTime, endTime) {
	start = startTime
	console.log(startTime, endTime)
	var Wizard = {
		init: function () {
			this.Basic.init();
		},

		Basic: {
			init: function () {

				this.preloader();
				this.countDown();

			},
			preloader: function () {
				jQuery(window).on('load', function () {
					jQuery('#preloader').fadeOut('slow', function () {
						jQuery(this).remove();
					});
				});
			},
			countDown: function () {
				if ($('.quiz-countdown').length > 0) {
					interval = setInterval(timer,1000, endTime);
				}
			},
		}
	}
	jQuery(document).ready(function () {
		Wizard.init();
	});
}