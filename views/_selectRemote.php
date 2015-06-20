<?php
	require_once ('../../views/ViewModel.php');

	class SelectRemoteView extends View {
		public function render ($data) {
			$remote_id = $data['remote_id'];
			$remotes_data = $data['remotes_data'];

			$output = <<<EOD
	<select id="remote-select">
EOD;
			while (($remotes_row = mysql_fetch_array( $remotes_data )) != null) {
				$id = $remotes_row['REMOTE_ID'];
				$name = $remotes_row['name'];

				$attr = $remote_id == $id ? ' selected="selected"' : '';

				$output .= "<option value='$id'$attr>$name</option>";
			}
			$output .= '</select>';

			return $output;
		}
	}