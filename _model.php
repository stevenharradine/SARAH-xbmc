<?php
	class XbmcRemoteManager {
		const timeout = 3;

		public function get_link () {
			global $DB_ADDRESS;
			global $DB_USER;
			global $DB_PASS;
			global $DB_NAME;

			return $link = DB_Connect($DB_ADDRESS, $DB_USER, $DB_PASS, $DB_NAME);
		}

		public function init () {
			global $sessionManager;

			if ($sessionManager->getUserType() == 'ADMIN') {
				$sql = <<<EOD
	CREATE TABLE IF NOT EXISTS `xbmc_remote` (
	  `REMOTE_ID` int(11) NOT NULL AUTO_INCREMENT,
	  `USER_ID` int(11) NOT NULL,
	  `name` text NOT NULL,
	  `ip` text NOT NULL,
	  PRIMARY KEY (`REMOTE_ID`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
EOD;

				return mysql_query( $sql ) or die ( mysql_error () );
			}
		}

		public function getActivePlayers ($remote_url) {
		    $json_url = "http://$remote_url/jsonrpc" . '?request={"jsonrpc":"2.0","method":"Player.GetActivePlayers","id":1}';

			$ctx = stream_context_create (array (
				'http' => array (
					'timeout' => XbmcRemoteManager::timeout
					)
				)
			);

		    $obj = json_decode (file_get_contents ($json_url, 0, $ctx), true);

		    return $obj['result'][0];
		}

		public function getRemotes () {
			$link = XbmcRemoteManager::get_link();
			$USER_ID = $_SESSION['USER_ID'];

			$sql = <<<EOD
SELECT * 
FROM  `xbmc_remote` 
WHERE  `USER_ID` = $USER_ID
EOD;
			$data = $link->query( $sql );
			$returnset = array ();

			while (($row = mysqli_fetch_array( $data )) != null) {
				$element = array (
					'REMOTE_ID' => $row['REMOTE_ID'],
					'name' => $row['name']
				);
				array_push ($returnset, $element);
			}

			return $returnset;
		}

		public function getPlayingItem ($remote_url, $playerid=1) {
		    $json_url = "http://$remote_url/jsonrpc" . '?request={"jsonrpc":"2.0","method":"Player.GetItem","params":{"playerid":' . $playerid . '},"id":"1"}';

			$ctx = stream_context_create (array (
				'http' => array (
					'timeout' => XbmcRemoteManager::timeout
					)
				)
			);

		    $obj = json_decode (file_get_contents ($json_url, 0, $ctx), true);

		    return str_replace ('%20', ' ', $obj['result']['item']['label']);
		}

		public function getVolume ($remote_url) {
		    $json_url = "http://$remote_url/jsonrpc" . '?request={"jsonrpc":"2.0","method":"Application.GetProperties","params":{"properties":["volume"]},"id":1}';

			$ctx = stream_context_create (array (
				'http' => array (
					'timeout' => XbmcRemoteManager::timeout
					)
				)
			);

		    $obj = json_decode (file_get_contents ($json_url, 0, $ctx), true);

		    return $obj['result']['volume'];
		}

		public function getPlayerProperties ($remote_url, $playerid=1) {
			$json_url = "http://$remote_url/jsonrpc" . '?request={"jsonrpc":"2.0","method":"Player.GetProperties","params":{"playerid":' . $playerid . ',"properties":["time","totaltime","percentage"]},"id":1}';

			$ctx = stream_context_create (array (
				'http' => array (
					'timeout' => XbmcRemoteManager::timeout
					)
				)
			);

		    $obj = json_decode (file_get_contents ($json_url, 0, $ctx), true);

		    return $obj['result'];
		}

		public function getUrl ( $id ) {
			$link = XbmcRemoteManager::get_link();
			$USER_ID = $_SESSION['USER_ID'];

			if ($id == null) {
				$sql = <<<EOD
		SELECT  `ip` 
		FROM  `xbmc_remote` 
		WHERE  `USER_ID` = $USER_ID
EOD;
			} else {
				$sql = <<<EOD
		SELECT  `ip` 
		FROM  `xbmc_remote` 
		WHERE  `REMOTE_ID` = $id
		AND  `USER_ID` = $USER_ID
EOD;
			}

			$data = $link->query( $sql );

			$row = mysqli_fetch_array( $data );

			return $row['ip'];
		}

		public function deleteById ( $id ) {
			$link = XbmcRemoteManager::get_link();
			$USER_ID = $_SESSION['USER_ID'];

			$sql = <<<EOD
DELETE FROM `sarah`.`xbmc_remote`
WHERE `xbmc_remote`.`REMOTE_ID` = $id
AND  `USER_ID` = $USER_ID
EOD;
			$data = $link->query( $sql );

			return $data;
		}

		public function addRemote ( $name, $url ) {
			$link = XbmcRemoteManager::get_link();
			$USER_ID = $_SESSION['USER_ID'];

			$sql = <<<EOD
INSERT INTO  `sarah`.`xbmc_remote` (
`REMOTE_ID` ,
`USER_ID` ,
`name` ,
`ip`
)
VALUES (
NULL ,  '$USER_ID',  '$name',  '$url'
);
EOD;

			$data = $link->query( $sql );

			return $data;
		}
	}
