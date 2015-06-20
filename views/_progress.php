<?php
	$formattedRunTime = formateTime ($runTime);
	$formattedTotalTime = formateTime ($totalTime);

	echo <<<EOD
	<div class="nowPlaying">$playingItem</div>
	<div class="progressBar">
		<div class="progressBar-progressTrack">
			<div class="progressBar-progress" style="width: $percentTime%">$formattedRunTime</div>
		</div>
	<div class="progressBar-totalTime">$formattedTotalTime</div>
	</div>
EOD;
// Required blank line before EOF after EOD