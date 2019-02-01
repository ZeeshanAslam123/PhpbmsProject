<?php
	include_once('db_conn.php');
	$user_email = '';
	$user_name = '';
	$user_role = '';

	if( isset($_GET['user_id']) && !isset($_POST['action']) ) {
		$user_id = $_GET['user_id'];
		$sql = "SELECT * FROM bms_users WHERE user_id = $user_id;";
		$result = $conn->query($sql);
		if( $result->num_rows > 0 ) {
			while($row = $result->fetch_assoc()) {
			$user_email = $row['user_email'];
			$user_name = $row['user_name'];
			$user_role = $row['user_role'];
			}
		}
	}
54343558
 	if( isset( $_POST['action'] ) && $_POST['action'] == 'registration' ) {
		$user_email = isset( $_POST['user_email'] ) ? $_POST['user_email'] : '';
		$user_name = isset( $_POST['user_name'] ) ? $_POST['user_name'] : '';
		$user_pass = isset( $_POST['user_pass'] ) ? $_POST['user_pass'] : ''; 
		$user_role = isset( $_POST['user_role'] ) ? $_POST['user_role'] : 'admin'; 
		
		$user_image = '';

			if( !is_dir( 'uploads' ) ) {
				mkdir('uploads');
			}

			$target_dir = 'uploads/';
			$target_file = $target_dir . basename( $_FILES['user_profile_image']['name'] );

			$imageFileType = strtolower( pathinfo( $target_file, PATHINFO_EXTENSION ) );

			if( 'png' != $imageFileType && 'jpg' != $imageFileType ) {
				echo 'File Type is not supported';
				return;
			}

			if ( move_uploaded_file( $_FILES['user_profile_image']['tmp_name'], $target_file ) ) {
			   $user_image = $target_file;  echo 'Your file is now uploaded into database';
			} 	


		if( !empty( $user_email ) && !empty( $user_name ) && !empty( $user_pass ) ) {

			if ( isset( $_GET['user_id'] ) ) {
				
				$sql = "UPDATE bms_users Set user_email='{$user_email}', user_name='{$user_name}', user_pass='{$user_pass}', user_role='{$user_role}', user_image='{$user_image}' WHERE user_id = {$_GET['user_id']}"; 
			
			} else {
				$sql = "INSERT INTO bms_users ( user_email, user_name, user_pass, user_role, user_image) VALUES ( '{$user_email}', '{$user_name}', '{$user_pass}', '{$user_role}', '{$user_image}')";
			}

			if( $conn->query($sql) === TRUE ) {
				echo 'Your registration form is sumbit into data base';
				header( 'Location:' . 'users.php' );
			} else {
				echo "Error ". $sql . "<br>" . $conn_error ;
			}

		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title> Registration form </title>
	<style type="text/css">
		.main_form {
		    background: #e8e8e8;
		    width: 40%;
		    margin: 8% auto;
		    padding: 40px;
		    border: 5px solid #e5e5e5;
		}
		.main_form p {
			font-size: 18px;
		}
		.main_form form input {
		    width: 100%;
		    padding-top: 15px;
		    border-radius: 2px;
		}

		.main_form input[type="submit"] {
		    width: 20%;
		    background: purple;
		    text-align: center;
		    border-radius: 5px;
		    border: 1px solid gray;
		    padding: 12px;
		    margin-top: 12px;
		}
	</style>
</head>
<body>
	<div class="main_form">
		<h1> Registration Form </h1>
		<?php $action = isset($_GET['user_id']) ? '?user_id=' . $_GET['user_id'] : '';?>
		<form action="registration.php<?php echo $action; ?>" method="post" enctype="multipart/form-data">
			<p> Enter Email </p>
			<input type="email" name="user_email" value="<?php echo $user_email; ?>">
			<p> Enter Username </p>
			<input type="text" name="user_name" value="<?php echo $user_name; ?>">
			<p> Enter Password </p>
			<input type="password" name="user_pass">
			<p> Enter Role </p>
			<input type="text" name="user_role" value="<?php echo $user_role; ?>">
			<p> Enter Image </p>
			<input type="file" name="user_profile_image" id="user_profile_image">
			<input type="hidden" name="action" value="registration">
			<input type="submit" name="submit">
		</form>
	</div>
</body>
</html>