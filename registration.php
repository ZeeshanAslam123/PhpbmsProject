<?php 
	include_once('db_conn.php');
	
	$user_name = '';
	$user_email = '';
	$user_role = '';

	if( isset($_GET['user_id']) && !isset($_POST['action'] ) ) {
		$user_id = $_GET['user_id'];

		$sql = "SELECT * FROM sms_users WHERE id = $user_id";
		$result = $conn->query($sql);

		if( $result->num_rows > 0 ) {
			while( $row = $result->fetch_assoc() ) {
				$user_name = $row['user_name'];
				$user_email = $row['user_email'];
				$user_role = $row['user_role'];
			}

		}

	}

	if( isset($_POST['action']) && $_POST['action'] == 'registration' ) {
		
		$user_name = isset( $_POST['user_name'] ) ? $_POST['user_name'] : '';
		$user_email = isset($_POST['user_email']) ? $_POST['user_email'] : '';
		$user_pass = isset($_POST['user_pass']) ? $_POST['user_pass'] : '';
		$user_role = isset($_POST['user_role']) ? $_POST['user_role'] : '';
		$user_image = '';


		if( !is_dir( 'uploads' ) ) {
				mkdir('uploads');
			}

			$target_dir = 'uploads/';
			$target_file = $target_dir . basename( $_FILES['user_image']['name'] );
			

			$imageFileType = strtolower( pathinfo( $target_file, PATHINFO_EXTENSION ) );

			if( 'png' != $imageFileType && 'jpg' != $imageFileType ) {
				echo 'File Type is not supported';
				return;
			}

			if ( move_uploaded_file( $_FILES['user_image']['tmp_name'], $target_file ) ) {
			   $user_image = $target_file;
			} 	


		$sql = "INSERT INTO sms_users ( user_name, user_email, user_pass, user_role, user_image ) 
		VALUES( '$user_name', '$user_email', '$user_pass', '$user_role', '$user_image' )";

		if ( isset( $_GET['user_id'] ) ) {
		$sql = "UPDATE sms_users Set user_name = '$user_name', user_email = '$user_email', user_pass = '$user_pass', user_role = '$user_role', user_image = '$user_image' WHERE id = {$_GET['user_id']} ";
		}
		
		if( $conn->query($sql) === TRUE ) {
			echo 'your data enter into database';
		}else {
			echo 'data send error';
		}


	}

?>


<!DOCTYPE html>
<html>
<head>
	<title> registration </title>
	<style type="text/css">
			.main_form {
			    background: #e8e8e8;
			    width: 40%;
			    margin: 8% auto;
			    padding: 40px;
			    border: 5px solid #e5e5e5;
			}
			.main_form form input {
			    width: 100%;
			    padding-top: 15px;
			}

			form input[type="submit"] {
			    width: 20%;
			    text-align: center;
			    border: 1px solid;
			    border-radius: 5px;
			    padding: 12px;
			    margin-top: 12px;
			}
	</style>
</head>
<body>
<div class="main_form">
		<h1> Registration Form </h1>
		<?php $action = isset($_GET['user_id'])? '?user_id=' . $_GET['user_id'] : ''; ?>
		<form action="registration.php<?php echo $action; ?>" method="post" enctype="multipart/form-data">
			<p> Enter Username <input type="text" name="user_name" value="<?php echo $user_name; ?>" > </p>
			<p> Enter Email <input type="email" name="user_email" value="<?php echo $user_email; ?>"> </p>
			<p> Enter Password <input type="password" name="user_pass"> </p>
			<p> Enter Role <input type="text" name="user_role" value="<?php echo $user_role; ?>" > </p>
			<p> Enter Image <input type="file" name="user_image" id="user_image"> </p>
			<input type="hidden" name="action" value="registration">
			<input type="submit" name="submit">
		</form>
	</div>
</body>
</html>