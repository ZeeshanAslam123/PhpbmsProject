<?php
	include_once('db_conn.php');

	if( isset($_GET['user_id']) ) {
		$user_id = $_GET['user_id'];
		$query = "DELETE FROM sms_users WHERE id=$user_id ";
		if( $conn->query($query) ) {
			echo 'your data is deleted into database';
		}else {
			echo "ERROR".$query."<br>".$conn_error;
		}

	}


	$selectquery = "SELECT * FROM sms_users";
	$result = $conn->query($selectquery);
	if( $result->num_rows > 0 ) {
		?>
		<table border="1">
			<thead>
				<th> S.No </th>
				<th> User ID </th>
				<th> User Name </th>
				<th> User Email </th>
				<th> User Password </th>
				<th> User Role </th>
				<th> User Image </th>
			</thead>	
		<?php
		$loopCount = 1;
		while( $row = $result->fetch_assoc() ) {
			?>
				<tbody>
					<td> <?php echo $loopCount; ?> </td>
					<td> <?php echo $row['id']; ?> </td>
					<td> <?php echo $row['user_name']; ?> </td>
					<td> <?php echo $row['user_email']; ?> </td>
					<td> <?php echo $row['user_pass']; ?> </td>
					<td> <?php echo $row['user_role']; ?> </td>
					<td><img style="width: 120px; height: 120px;" src="<?php echo $row['user_image']; ?>" ></td>
					<td> <a href="registration.php?user_id=<?php echo $row['id'] ?>"> Edit </a> </td>
					<td> <a onclick="return datadelete()" href="select.php?user_id=<?php echo $row['id'] ?>"> Deleted </a> </td>
				</tbody>
				<script>
					function datadelete() {
						return confirm('Are you sure you want to delete this data');
					}
				</script>
			<?php
		$loopCount++;
		}
		?>
		</table>
		<?php
	}

?>