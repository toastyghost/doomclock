$.fn.doomclock = function() {
	if (this[0].tagName === 'TIME') {
		var now = new Date(),
			date = new Date($(this).attr('datetime')),
			diff = (date - now) / 1000;

		if (diff > 0) {
			var countdown = {
				days: Math.floor(diff/86400),
				hours: ('0' + Math.floor(diff/3600) % 24).slice(-2),
				minutes: ('0' + Math.floor(diff/60) % 60).slice(-2),
				seconds: ('0' + Math.floor(diff % 60)).slice(-2)
			};

			this[0].innerHTML = '<span id="doomclock-days">' + countdown.days + '</span> days<br>' +
				'<span id="doomclock-hours">' + countdown.hours + '</span>:' +
				'<span id="doomclock-minutes">' + countdown.minutes + '</span>:' +
				'<span id="doomclock-seconds">' + countdown.seconds + '</span>';

			var days = document.getElementById('doomclock-days'),
				hours = document.getElementById('doomclock-hours'),
				minutes = document.getElementById('doomclock-minutes'),
				seconds = document.getElementById('doomclock-seconds');

			setInterval(function() {
				if (seconds.innerHTML == 0) {
					seconds.innerHTML = 59;
					if (minutes.innerHTML == 0) {
						minutes.innerHTML = 59;
						if (hours.innerHTML == 0) {
							hours.innerHTML = 23;
							if (days.innerHTML > 0) {
								--days.innerHTML;
							}
						} else {
							--hours.innerHTML;
							if (hours.innerHTML < 10) {
								hours.innerHTML = ('0' + hours.innerHTML).slice(-2);
							}
						}
					} else {
						--minutes.innerHTML;
						if (minutes.innerHTML < 10) {
							minutes.innerHTML = ('0' + minutes.innerHTML).slice(-2);
						}
					}
				} else {
					--seconds.innerHTML;
					if (seconds.innerHTML < 10) {
						seconds.innerHTML = ('0' + seconds.innerHTML).slice(-2);
					}
				}
			}, 1000);
		} else {
			this[0].innerHTML = "It's here!";
		}
			
	} else {
		throw "jQuery.doomclock: Invalid tagName. You must invoke doomclock on a <time> element.";
	}
}