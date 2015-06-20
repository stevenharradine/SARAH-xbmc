<table class="remote" data-url="<?php echo $remote_url; ?>">
	<tr>
		<td><a class="menu" href='http://<?php echo $remote_url; ?>/jsonrpc?request={"jsonrpc":"2.0","method":"Input.ContextMenu","id":1}'>Menu</a></td>
		<td><a class="up" href='http://<?php echo $remote_url; ?>/jsonrpc?request={"jsonrpc":"2.0","method":"Input.Up","id":1}'>Up</a></td>
		<td><a class="pauseplay" href='http://<?php echo $remote_url; ?>/jsonrpc?request={"jsonrpc":"2.0","method":"Player.PlayPause","params":{"playerid":1},"id":1}'>Pause/Play</a></td>
	</tr>
	<tr>
		<td><a class="left" href='http://<?php echo $remote_url; ?>/jsonrpc?request={"jsonrpc":"2.0","method":"Input.Left","id":1}'>Left</a></td>
		<td><a class="enter" href='http://<?php echo $remote_url; ?>/jsonrpc?request={"jsonrpc":"2.0","method":"Input.Select","id":1}'>Enter</a></td>
		<td><a class="right" href='http://<?php echo $remote_url; ?>/jsonrpc?request={"jsonrpc":"2.0","method":"Input.Right","id":1}'>Right</a></td>
	</tr>
	<tr>
		<td><a class="back" href='http://<?php echo $remote_url; ?>/jsonrpc?request={"jsonrpc":"2.0","method":"Input.Back","id":1}'>Back</a></td>
		<td><a class="down" href='http://<?php echo $remote_url; ?>/jsonrpc?request={"jsonrpc":"2.0","method":"Input.Down","id":1}'>Down</a></td>
		<td><a class="stop" href='http://<?php echo $remote_url; ?>/jsonrpc?request={"jsonrpc":"2.0","method":"Player.Stop","params":{"playerid":1},"id":1}'>Stop</a></td>
	</tr>
	<tr>
		<td><a class="volUp" href="#">inc+</a></td>
		<td><a class="seekBack" href='http://<?php echo $remote_url; ?>/jsonrpc?request={"jsonrpc":"2.0","id":1,"method":"Player.Seek","params":{"playerid":1,"value":"smallbackward"}}'>&lt;&lt;</a></td>
		<td><a class="seekForward" href='http://<?php echo $remote_url; ?>/jsonrpc?request={"jsonrpc":"2.0","id":1,"method":"Player.Seek","params":{"playerid":1,"value":"smallforward"}}'>&gt;&gt;</a></td>
	</tr>
	<tr>
		<td><a class="volDown" href="#">dec-</a></td>
		<td><input type="text" value="<?php echo $volumeLevel ?>" id="volLevel" size="3" /></td>
		<td><input type="button" id="setVol" value="Set Volume" /></td>
	</tr>
</table>