<?php 
	session_start();
	require_once 'rendezvousClass.php';
	$data = new Rendezvous();
	$username = $_SESSION['username'];
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
	height:350px;
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
		<script type="text/javascript">
				function vali(){
	            var pass1 = document.updatePasswordForm.pass1;
				 var pass2 = document.updatePasswordForm.pass2;
	            
				errmsg="";
			    if((pass1.value == "") || (pass1.value.length < 6))
				{
					pass1.style.background = 'Yellow';
					errmsg += "Password must be atleast 7 characters.\n";
				}
				if((pass2.value == "") || (pass2.value.length < 6))
				{
					pass2.style.background = 'Yellow';
					errmsg += "Confirm Password must be atleast 7 characters.\n";
				}
                if(errmsg.length > 0){
			    alert("You must provide the following fields:\n" +errmsg);
	            return false;
	    	
	            }
	  
	            return true;					
				
				}
			    </script>
	<div class="panel panel-info">
		<h1 align="center">Change Password</h1>

		<div class="panel-body">

			<div class="form-group" id="content">

				<form method="POST" action="" name="updatePasswordForm" onsubmit="return vali()">
					<label>New Password<font color="red">*</font> <input type="password" name="pass1" id="pass1" class="form-control" /></label><br />
					<label>Confirm Password<font color="red">*</font><input type="password" name="pass2" id="pass2" class="form-control" /></label><br /> <br />
					<input type="submit" name="change" value="Change" class="btn btn-primary">
				</form>

<?php
	 if(isset($_POST['change'])) {
		if($_POST['pass1']=="" || $_POST['pass2']=="") {
			echo "<br /><font color='red'><b>Please provide new password in both the fields!</b></font>";
		}
		else if($_POST['pass1'] == $_POST['pass2']) {
			$pwd = password_hash($_POST['pass1'], PASSWORD_BCRYPT);
			$data->updatePassword($username, $pwd);
			header('Location:homepage.php');
		}
		else {
			echo "<br /><font color='red'><b>Password provided in both the fields are different!</b></font>";
		}
	 } 
?>
</div>
</div>
</div>
</body>
</html>