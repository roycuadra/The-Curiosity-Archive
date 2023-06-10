<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "../verify_logged_out.php";
	require "../header.php";
?>

<html>
	<head>
		<title>LMS</title>
		<link rel="stylesheet" type="text/css" href="../css/global_styles.css">
		<link rel="stylesheet" type="text/css" href="../css/form_styles.css">
		<link rel="stylesheet" type="text/css" href="css/index_style.css">
		<style>
		body {
			font-family: Arial, sans-serif;
			background-color: white;
			margin: 0;
			padding: 0;
		}

		.container {
			max-width: 400px;
			margin: 0 auto;
			border-radius:10px;
			padding: 40px;
			background-color: #fff;
			box-shadow: 0 0 50px rgba(0, 0, 0, 0.1);
		}

		h2 {
			text-align: center;
			margin-top: 0;
			color: #333;
		}

		.error-message {
			margin-bottom: 20px;
			text-align: center;
		}

		.error {
			color: red;
		}

		.icon {
			position: relative;
		}

		.icon input {
			padding-left: 40px;
		}

		.icon i {
			position: absolute;
			top: 50%;
			transform: translateY(-50%);
			left: 12px;
			color: #999;
		}

		input[type="text"],
		input[type="password"] {
			width: 100%;
			padding: 12px;
			border: 1px solid #ddd;
			border-radius: 4px;
			font-size: 16px;
			transition: border-color 0.3s ease-in-out;
		}

		input[type="text"]:focus,
		input[type="password"]:focus {
			border-color: blue;
			outline: none;
		}

		input[type="submit"] {
			display: block;
			width: 100%;
			padding: 12px;
			margin-top: 20px;
			border: none;
			border-radius: 4px;
			background-color: blue;
			color: #fff;
			font-size: 16px;
			cursor: pointer;
			transition: background-color 0.3s ease-in-out;
		}

		input[type="submit"]:hover {
			background-color: #2980b9 ;
		}

		.register-link,
		.go-back-link {
			text-align: center;
			margin-top: 20px;
		}

		.register-link a,
		.go-back-link a {
			color: blue;
			text-decoration: none;
		}

		.center-container {
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
		}

		/* Media Queries for Responsive Design */
		@media only screen and (max-width: 600px) {
			.container {
				max-width: 300px;
			}
		}
	</style>
</head>
<body >
	<div style="background-color:white;" class="center-container">
		<div class="container">
			<h2>Member Login</h2>

			<div class="error-message">
				<p class="error" id="error"></p>
			</div>

			<form class="cd-form" method="POST" action="#">
				<div class="icon">
					<i class="fas fa-user"></i>
					<input class="m-user" type="text" name="m_user" placeholder="Username" required />
				</div>

					<div class="icon">
						<i class="fas fa-lock"></i>
						<input class="m-pass" type="password" name="m_pass" placeholder="Password" required />
					</div>

					<input  style="background-color:blue;" type="submit" value="Login" name="m_login" />
			</form>

			<div class="register-link">
				<p style="color:black;">Don't have an account? <a href="register.php">Register Now!</a></p>
			</div>

			<div class="go-back-link">
				<p><a href="../index.php">Go Back</a></p>
			</div>
		</div>
	</div>
</body>
	<?php
		if(isset($_POST['m_login']))
		{
			$query = $con->prepare("SELECT id, balance FROM member WHERE username = ? AND password = ?;");
			$query->bind_param("ss", $_POST['m_user'], sha1($_POST['m_pass']));
			$query->execute();
			$result = $query->get_result();
			
			if(mysqli_num_rows($result) != 1)
				echo error_without_field("Invalid details or Account has not been activated yet!");
			else 
			{
				$resultRow = mysqli_fetch_array($result);
				$balance = $resultRow[1];
			if($balance < 0){
				echo error_without_field("Your account has been suspended. Please contact librarian for further information!");
			} else {
					$_SESSION['type'] = "member";
					$_SESSION['id'] = $resultRow[0];
					$_SESSION['username'] = $_POST['m_user'];
					header('Location: home.php');
				}
			}
		}
	?>
	
</html>