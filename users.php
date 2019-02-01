<?php
include_once('db_conn.php');

if( isset( $_GET['user_id'] ) ) {
	$delete = $_GET['user_id'];
	$query = " DELETE FROM bms_users WHERE user_id = $delete";

	if( $conn->query( $query ) ) {
		echo 'Delete Success full';
		header( 'Location:' . 'users.php');
	}else{
		echo 'error' . $conn_error;
	}
}

$users_query = "SELECT * FROM bms_users ";
$result = $conn->query($users_query);

if ($result->num_rows > 0) {
	?>
	<style type="text/css">
		table {
			padding: 25px;
			font-size: 20px;
			margin: 0 auto;
			background: #e8e8e8;
		}
		table tr td {
			font-size: 18px;
			padding: 8px;
		}
	</style>
        <table>
        	<thead>
        		<th> S.No </th>
        		<th> ID </th>
        		<th> All User Name </th>
        		<th> All User Email </th>
        		<th> User Password </th>
        		<th> User Role </th>
        		<th> User Image </th>
        		<th> Edit </th>
        	</thead>
        	<tbody>
    <?php
    $loop_count = 1;
    while( $row = $result->fetch_assoc() ) {
    	?> 	<tr>
    			<td> <?php echo $loop_count; ?> </td>
    			<td> <?php echo $row['user_id']; ?> </td>
    			<td> <?php echo $row['user_email']; ?> </td>
    			<td> <?php echo $row['user_name']; ?> </td>
    			<td> <?php echo $row['user_pass']; ?> </td>
    			<td> <?php echo $row['user_role']; ?> </td>
    			<td> <img style="width: 80px;" src="<?php echo $row['user_image']; ?>"> </td>
    			<td> <a href="registration.php?user_id=<?php echo $row['user_id']; ?>" > Edit </a> </td>
    			<td> <a href="users.php?user_id=<?php echo $row['user_id']; ?>" > Delete </a> </td>
    		</tr> 
    	<?php
    	$loop_count++;
    }?>
    </tbody>
    </table>
    <?php
} else {
    echo "0 results";
}
$conn->close();	

?>