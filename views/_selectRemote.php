<?php
	require_once ('../../views/ViewModel.php');

	class SelectRemoteView extends View {
		public function render ($data) {
			$remote_id = $data['remote_id'];
			$remotes_data = $data['remotes_data'];

			$output = <<<EOD
	<select id="remote-select">
EOD;
			for ($i = 0; $i < count ($remotes_data); $i++) {
				$REMOTE_ID = $remotes_data[$i]['REMOTE_ID'];
				$name = $remotes_data[$i]['name'];

				$attr = $remote_id == $REMOTE_ID ? ' selected="selected"' : '';

				$output .= "<option value='$REMOTE_ID'$attr>$name</option>";
			}
			$output .= '</select>';

			return $output;
		}
	}