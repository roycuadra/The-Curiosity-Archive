<?php
	require "db_connect.php";
	require "header.php";
	session_start();
	
	if(empty($_SESSION['type']));
	else if(strcmp($_SESSION['type'], "librarian") == 0)
		header("Location: librarian/home.php");
	else if(strcmp($_SESSION['type'], "member") == 0)
		header("Location: member/home.php");
?>

<html>
	<head>
		<title>LMS</title>
		<link rel="stylesheet" type="text/css" href="css/index_style.css" />
		<style>
  #allTheThings {
    display: flex;
    justify-content: center;
    gap: 80px;
  }

  .login-link {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-decoration: none;
    color: #333;
    font-family: Arial, sans-serif;
    font-size: 16px;
    transition: transform 0.2s;
  }

  .login-link:hover {
    transform: scale(1.05);
  }

  .login-image {
    width: 100px;
    height: 100px;
    
  }
</style>

	</head>
	<body>
	<div id="allTheThings">
  <div id="member">
    <a href="member" class="login-link">
      <img src="card.png" alt="Member Login" class="login-image" /><br />
      Member Login
    </a>
  </div>
  <div id="librarian">
    <a id="librarian-link" href="librarian" class="login-link">
      <img src="admin.png" alt="Librarian Login" class="login-image" /><br />
      Librarian Login
    </a>
  </div>
</div>
	</body>
</html>