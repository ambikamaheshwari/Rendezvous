<?php
	session_start();
	require_once 'rendezvousClass.php';
	$data = new Rendezvous();
?>

<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Rendezvous - Change Password </title>
<link href='http://fonts.googleapis.com/css?family=Arizonia'
	rel='stylesheet' type='text/css'>
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<style>
h2 {
	font: 200 100px/1.0 'Arizonia', Helvetica, sans-serif;
	color: #FFFFFF;
	text-shadow: 4px 4px 0px rgba(0, 0, 0, 0.1);
}

body {
	background-image: url("BackgroundCover.jpg");
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
}

html {
	width: 100%;
	height: 100%;
	margin: 0;
}

.panel-info {
	opacity: 0.95;
	margin-top: 300px;
	width: 600px;
	height:300px;
	margin: 30px auto;
}

.form-group {
	width: 1000px;
	padding-left: 60px;
}

.form-group label {
	color: #428bca;
	font-weight: bold;
	padding: 4px;
	font-size: 16px;
	font-family: Georgia;
}

h4 {
	font-style: italic;
}

input, select {
	font-weight: bold;
}

h1 {
	color: #428bca;
	font-style: italic;
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
}

.btn-default {
	position:absolute;
	top:30px;
	right:50px;
	color: #428bca;
	font-weight: bold;
}

</style>
</head>
<body>

	<h2>&nbsp;Rendezvous...</h2>
	<h4>
		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
		&nbsp; &nbsp; &nbsp; &nbsp; <font color="white"> Meet your people at
			your chosen places</font>
	</h4>
	
	<a href="homepage.php" class="btn btn-default">Home</a>
	
	<div class="panel panel-info">
		<h1 align="center">Change Password</h1>

		<div class="panel-body">

			<div class="form-group" id="content">

				<form method="POST" action="" name="forgotPasswordForm">
					<label> Username<font color="red">*</font> <br />
					<input type="email" name="email" autocomplete="off" class="form-control"></label>
					&nbsp; &nbsp;
					<input type="submit" id="continue" name="continue" value="Continue" class="btn btn-primary">
				</form>

<?php
	if(isset($_POST['continue'])) {
		if(strip_tags($_POST['email'])=="") {
			echo "<font color='red'><b>Username is required!</b></font>";
		}
		else if($data->checkUsername(strip_tags($_POST['email'])) != null) {
				$_SESSION['username'] = strip_tags($_POST['email']);
				header("Location:securityQuestions.php");
		}
		else {
			echo "<font color='red'><b>Username doesn't exist!</b></font>";
			echo "<br /><br /><a href='homepage.php#sectionSignup'>Click here to Sign Up!</a>";	
		}	
	}
?>
</div>
</div>
</div>
</body>
</html>