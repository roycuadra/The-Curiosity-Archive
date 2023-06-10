<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "../header.php";
?>

<html>
	<head>
		<title>LMS</title>
		<link rel="stylesheet" type="text/css" href="../css/global_styles.css">
		<link rel="stylesheet" type="text/css" href="../css/form_styles.css">
		<link rel="stylesheet" href="css/register_style.css">
	</head>
	<style>
	/* Global Styles */
* {
  box-sizing: border-box;
  font-family: Arial, sans-serif;
}

body {
  margin: 0;
}

.form-container {
  max-width: 400px;
  margin: 0 auto;
  width:100%;
  padding: 20px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 0 50px rgba(0, 0, 0, 0.1);
}

h2 {
  text-align: center;
  margin-top: 0;
  color: #333;
}

p {
  color: #777;
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 8px;
  color: #333;
}

input[type="text"],
input[type="email"],
input[type="password"],
input[type="number"] {
  width: 100%;
  padding: 10px;
  font-size: 16px;
  border-radius: 4px;
  border: 1px solid #ccc;
  text-indent: 35px;
}

input[type="submit"] {
  width: 100%;
  padding: 10px;
  font-size: 16px;
  background-color: #4CAF50;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type="submit"]:hover {
  background-color: #45a049;
}

.error-message {
  text-align: center;
  color: red;
}

/* Center align the form on the page */
.cd-form {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}
</style>
</head>

<body style="background-color:white !important;">
    <form class="cd-form" method="POST" action="#" >
	<div class="form-container">
		<center>
			<h2>Member Registration</h2>
			<p>Please fill out the form below:</p>
		</center>

		<div class="error-message" id="error-message">
			<p id="error"></p>
		</div>

		<div class="form-group">
			<label for="m_name">Full Name</label>
			<input class="m-name" type="text" name="m_name" placeholder="Enter your full name" required>
		</div>

		<div class="form-group">
			<label for="m_email">Email</label>
			<input class="m-email" type="email" name="m_email" id="m_email" placeholder="Enter your email" required>
		</div>

		<div class="form-group">
			<label for="m_user">Username</label>
			<input class="m-user" type="text" name="m_user" id="m_user" placeholder="Enter a username" required>
		</div>

		<div class="form-group">
			<label for="m_pass">Password</label>
			<input class="m-pass" type="password" name="m_pass" placeholder="Enter a password" required>
		</div>

		<div class="form-group">
			<label for="m_balance">Initial Balance</label>
			<input class="m-balance" type="number" name="m_balance" id="m_balance" placeholder="Enter initial balance" required>
		</div>

		<div class="form-group">
			<input style="background-color:blue;" type="submit" name="m_register" value="Submit">
		</div>
	</div>
</form>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>



	</body>
	
	<?php
		if(isset($_POST['m_register']))
		{
			if($_POST['m_balance'] < 500)
				echo error_with_field("Initial balance must be at least 500 in order to create an account", "m_balance");
			else
			{
				$query = $con->prepare("(SELECT username FROM member WHERE username = ?) UNION (SELECT username FROM pending_registrations WHERE username = ?);");
				$query->bind_param("ss", $_POST['m_user'], $_POST['m_user']);
				$query->execute();
				if(mysqli_num_rows($query->get_result()) != 0)
					echo error_with_field("The username you entered is already taken", "m_user");
				else
				{
					$query = $con->prepare("(SELECT email FROM member WHERE email = ?) UNION (SELECT email FROM pending_registrations WHERE email = ?);");
					$query->bind_param("ss", $_POST['m_email'], $_POST['m_email']);
					$query->execute();
					if(mysqli_num_rows($query->get_result()) != 0)
						echo error_with_field("An account is already registered with that email", "m_email");
					else
					{
						$query = $con->prepare("INSERT INTO pending_registrations(username, password, name, email, balance) VALUES(?, ?, ?, ?, ?);");
						$query->bind_param("ssssd", $_POST['m_user'], sha1($_POST['m_pass']), $_POST['m_name'], $_POST['m_email'], $_POST['m_balance']);
						if($query->execute())
							echo success("Details submitted, soon you'll will be notified after verifications!");
						else
							echo error_without_field("Couldn\'t record details. Please try again later");
					}
				}
			}
		}
	?>
	
</html>