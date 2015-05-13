<div id="mainContent">
	<table id="userInfo">
		<tr>
			<th colspan="2"><?php echo "$uname's User Profile"; ?></th>
		</tr>
		<tr>
			<th>Name:</th>
			<td><?php echo "$fname $lname"; ?></td>
		</tr>
		<tr>
			<th>Bio:</th>
			<td><?php echo $bio; ?>
		</tr>
		<tr>
			<th>Games Played:</th>
			<td><?php echo $gameCtr; ?>
		</tr>
		<tr>
			<th>Player Level:</th>
			<td><?php echo ($gameCtr >=250 ? "Gold" : ( $gameCtr >= 125 
								? "Silver" : ( $gameCtr >= 50 ? "Bronze" 
								: "Normal" ) ) ); ?></td>
		</tr>
		<tr>
			<th>User Level:</th>
			<td>
				<?php 
					echo ($admin !== null ? "Admin" : ( $moder != null 
							? "Moderator" : "Regular Member") );
				?>
		</tr>
	</table>
</div>