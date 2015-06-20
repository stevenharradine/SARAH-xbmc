require (['../../js/jquery-1.6.2.min'], function ($) {
	require({
		baseUrl: '../../js/'
	}, [
		"navigation",
		"add",
		"edit"
	], function( 
		nav,
		add,
		edit
	) {
		var prevRunTimeSeconds = 0;
		var playerid = -1;

		updateActivePlayers();
		updatePlayer ();

		function leadingZero (val) {
			return (val < 10 ? '0' : '') + val;
		}
		function formateTime (time) {
			return leadingZero (time.hours) + ":" + leadingZero (time.minutes) + ":" + leadingZero (time.seconds);
		}
		function timeToSeconds (time) {
			return ((time['hours'] * 60) + time['minutes'] * 60) + time['seconds'];
		}

		function getUrl () {
			return jQuery ('.remote').attr('data-url');
		}

		function updateActivePlayers () {
			var temp = 'xbmc.php?remote_url=' + getUrl() + '&action=getActivePlayers';

			jQuery.getJSON (temp, function ( data ) {
				playerid = data.result[0].playerid;
			});
		}

		function updatePlayer () {
			var temp = 'xbmc.php?remote_url=' + getUrl() + '&playerid=' + playerid;

			jQuery.getJSON (temp, function ( data ) {
				currRunTimeSeconds = timeToSeconds (data.result.time);

				// if the clock is less then it a good indicator a new track was loaded (scrubbing will also invoke this)
				if (currRunTimeSeconds < prevRunTimeSeconds) {
					updateTrack ();
					updateTotalTime ();
				}

				updateActivePlayers();

				prevRunTimeSeconds = currRunTimeSeconds;

				jQuery (".progressBar-progress").css ("width", data.result.percentage + "%").html(formateTime (data.result.time));
			});

			setTimeout (function(){updatePlayer()}, 1000);	
		}
		function updateTrack () {
			var temp = 'xbmc.php?remote_url=' + getUrl() + '&action=getTrack&playerid=' + playerid;

			jQuery.getJSON (temp, function ( data ) {
				jQuery (".nowPlaying").html (data.result.item.label);
			});
		}
		function updateTotalTime () {
			var temp = 'xbmc.php?remote_url=' + getUrl() + '&action=getTotalTime&playerid=' + playerid;

			jQuery.getJSON (temp, function ( data ) {
				if (timeToSeconds (data.result.time) == 0) {
					jQuery (".progressBar-totalTime").html ("Fetching . . .");
					setTimeout (function(){updateTotalTime()}, 1000);
				} else {
					jQuery (".progressBar-totalTime").html (formateTime (data.result.time));
				}
			});
		}

		function getVolume() {
			return parseInt (jQuery("#volLevel").val());
		}

		function setVolume ( level ) {
			level = level < 0 ? 0 : level;
			level = level > 100 ? 100 : level;

			jQuery.ajax({
				url: 'http://' + getUrl() + '/jsonrpc?request={"jsonrpc":"2.0","method":"Application.SetVolume","params":{"volume":' + level + '},"id":1}',
			});

			jQuery("#volLevel").val( level );
		}

		jQuery (".remote a").bind ("click", function ( event ) {
			event.preventDefault();
			var url = jQuery (this).attr ("href");

			url = url.replace ("{\"playerid\":1", "{\"playerid\":" + playerid);

			jQuery.ajax({
				url: url,
			});
		});

		jQuery ("#remote-select").bind ("change", function ( event ) {
			location.href = 'index.php?remote_id=' + jQuery (this).val();
		});

		jQuery ("#setVol").bind ("click", function () {
			setVolume ( getVolume() );
		});

		jQuery (".volUp").bind ("click", function ( event ) {
			event.preventDefault();

			setVolume (getVolume() + 1);
		});

		jQuery (".volDown").bind ("click", function ( event ) {
			event.preventDefault();

			setVolume (getVolume() - 1);
		});

		jQuery ("html").keydown(function (e) {
			var code = e.keyCode || e.which;
			
			switch (code) {
				case 8:	// backspace key
					jQuery ("a.back").click();
					e.preventDefault();
					break;
				case 13:	// enter key
					jQuery ("a.enter").click();
					e.preventDefault();
					break;
				case 32:	// space bar
					jQuery ("a.pauseplay").click();
					e.preventDefault();
					break;
				case 37:	// left key
					jQuery ("a.left").click();
					e.preventDefault();
					break;
				case 38:	// up key
					jQuery ("a.up").click();
					e.preventDefault();
					break;
				case 39:	// right key
					jQuery ("a.right").click();
					e.preventDefault();
					break;
				case 40:	// down key
					jQuery ("a.down").click();
					e.preventDefault();
					break;
				case 77:	// m key
					jQuery ("a.menu").click();
					e.preventDefault();
					break;
				case 83:	// s key
					jQuery ("a.stop").click();
					e.preventDefault();
					break;
				case 187:	// equals/plus key
					jQuery ("a.volUp").click();
					e.preventDefault();
					break;
				case 188:	// comma/left arrow key
					jQuery ("a.seekBack").click();
					e.preventDefault();
					break;
				case 189:	// underscore/minus key
					jQuery ("a.volDown").click();
					e.preventDefault();
					break;
				case 190:	// period/right arrow key
					jQuery ("a.seekForward").click();
					e.preventDefault();
					break;
				default:
					console.log (code);
			}
		});

	});
});