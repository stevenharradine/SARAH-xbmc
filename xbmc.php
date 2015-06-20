<?php
	require_once '../../views/_secureHead.php';

	if( isset ($sessionManager) && $sessionManager->isAuthorized () ) {
		$remote_url = request_isset ('remote_url');
		$playerid = request_isset ('playerid');

		$remotes_data = XbmcRemoteManager::getRemotes();

		switch ( $page_action ) {
			case 'getTrack':
				$track = XbmcRemoteManager::getPlayingItem($remote_url, $playerid);
				
				echo <<<EOD
{
	"id":"1",
	"jsonrpc":"2.0",
	"result":{
		"item":{
			"label":"$track",
			"type":"unknown"
		}
	}
}
EOD;
				break;
			case 'getTotalTime':
				$time = XbmcRemoteManager::getTotalTime($remote_url, $playerid);

				$hours = $time['hours'];
				$milliseconds = $time['milliseconds'];
				$minutes = $time['minutes'];
				$seconds = $time['seconds'];
				
				echo <<<EOD
{
	"id":1,
	"jsonrpc":"2.0",
	"result":{
		"time":{
			"hours":$hours,
			"milliseconds":$milliseconds,
			"minutes":$minutes,
			"seconds":$seconds
		}
	}
}
EOD;
				break;
			case 'getActivePlayers':
				$activePlayers = XbmcRemoteManager::getActivePlayers($remote_url);

				$playerid = $activePlayers['playerid'];
				$type = $activePlayers['type'];
				
				echo <<<EOD
{
	"id":1,
	"jsonrpc":"2.0",
	"result":[{
		"playerid":$playerid,
		"type":"$type"
	}]
}
EOD;
				break;

			default:
				$volumeLevel = XbmcRemoteManager::getVolume ($remote_url);
				$playerProperties = XbmcRemoteManager::getPlayerProperties ($remote_url, $playerid);
//				$playingItem = XbmcRemoteManager::getPlayingItem ($remote_url, $playerid);
				$runTime = $playerProperties['time'];
				$totalTime = $playerProperties['totaltime'];
				$percentTime = $playerProperties['percentage'];

				$runTimeHours = $runTime['hours'];
				$runTimeMinutes = $runTime['minutes'];
				$runTimeSeconds = $runTime['seconds'];

				$totalTimeHours = $totalTime['hours'];
				$totalTimeMinutes = $totalTime['minutes'];
				$totalTimeSeconds = $totalTime['seconds'];

				echo <<<EOD
{
	"id":1,
	"jsonrpc":"2.0",
	"result":{
		"percentage":$percentTime,
		"time":{
			"hours":$runTimeHours,
			"minutes":$runTimeMinutes,
			"seconds":$runTimeSeconds
		},
		"totaltime":{
			"hours":0,
			"minutes":21,
			"seconds":17
		}
	}
}
EOD;
				break;
		}

	}