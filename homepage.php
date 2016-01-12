<?php
session_start ();
require_once 'rendezvousClass.php';
$data = new Rendezvous();
$strPwd=null;
?>

<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Rendezvous - Homepage</title>
<link href='http://fonts.googleapis.com/css?family=Arizonia'
	rel='stylesheet' type='text/css'>
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
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
	margin-top: 30px;
	width: 800px;
	height:1500px;
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
	<div class="panel panel-info">

		<div class="panel-body">

			<div class="form-group" id="content">

				<label>
				<ul class="nav nav-tabs" id="myTab">
					<li class="active"><a data-toggle="tab" href="#sectionLogin" style="width: 300px;" align="center"><b>Login</b></a></li>
					<li><a data-toggle="tab" href="#sectionSignup" style="width: 300px;" align="center"><b>Signup</b></a></li>
				</ul>
				</label>
				<div class="tab-content">
					<div id="sectionLogin" class="tab-pane fade in active">
						
						<div class="form-group">
							<form method="POST" action="" name="loginForm" class="form-horizontal">
							<br />
								<label>Username<font color="red">*</font>
								<input type="email" id="username" name="username" value="" class="form-control" /></label> <br /> <br />
								<label>Password<font color="red">*</font>
								<input type="password" id="password" name="password" value="" class="form-control"></label> <br />
								<p class="remember_me">
								  <label>
									<input type="checkbox" name="remember_me" id="remember_me">
									Remember me on this computer
								  </label>
								</p>
								<input type="submit" id="login" name="login" class="btn btn-primary" value="Login"> &nbsp; &nbsp; &nbsp; &nbsp;
								<input type="submit" id="withoutid" class="btn btn-primary" name="withoutid" value="Continue as Guest">
								<br /><br />
								<!-- <label>Not yet registered? <a class="text-active" href="#sectionSignup" data-toggle="tab">Sign Up</a></label><br /> -->
								<label>Forgot your password? <a class="text-active" href="forgotpassword.php">Click here</a></label>
							</form>
						</div> 
						
						<?php
							//moving to basic search page for guest user
							if(isset($_POST['withoutid'])) {
								$_SESSION['withoutid'] = $_POST['withoutid'];
								header("Location:basicsearch.php");
							}
							//checking for logged in user
							if(isset($_POST['login'])) {
								$username = strip_tags($_POST['username']);
								$password = $_POST['password'];
								
								if($username=="" || $password=="") {
									echo "<br /><font color='red'><b>Provide all the required fields!</b></font>";
								}
								else if($data->checkUsername($username) != null) {
									//echo $data->checkUsername($username);
									//foreach($data->getPassword($username) as $pwd) {
										//$strPwd = implode($pwd);
										$strPwd = $data->getPassword($username);
									//}
									//echo $strPwd;
									if(password_verify($password, $strPwd)) {
										$_SESSION['username'] = $username;
										$_SESSION['login'] = $_POST['login'];
										header("Location:basicsearch.php");
									}
									else
										echo "<br /><font color='red'><b>Password doesn't match!</b></font>";
								}
								else
									echo "<br /><font color='red'><b>Username doesn't exist!</b></font>";
							}
				
						?>
					</div>
					
					<div id="sectionSignup" class="tab-pane fade">
						<div class="form-group">
							  <form method="POST" action="#sectionSignup" name="signup" class="form-horizontal"> <br />
								<label>First Name<font color="red">*</font><input type="text" name="fname" class="form-control" /></label><br /> <br />
								<label>Last Name<font color="red">*</font><input type="text" name="lname" value="" class="form-control" /></label><br /> <br />
								<label>Address<font color="red">*</font><input type="text" id="address" name="address" value="" class="form-control" /></label><br /> <br />
								<label>City<font color="red">*</font><input type="text" name="city" value="" class="form-control" /></label><br /> <br />
								<label>State<font color="red">*</font><input type="text" name="state" value="" class="form-control" /></label><br /> <br />
								<label>ZIP Code<font color="red">*</font><input type="text" id="zip" name="zip" pattern="[\d]{5}" title='ZIP Code (Format: nnnnn)' class="form-control" /></label><br /> <br />
								<label>Phone<font color="red">*</font><input type="tel" name="tel" pattern="[\d]{3}[\-][\d]{3}[\-][\d]{4}" title='Phone Number (Format: 123-456-7890)' class="form-control" /></label><br /> <br />
								<label>Email<font color="red">*</font><input type="email" name="email" autocomplete="off" value="" class="form-control" /></label><br /> <br />
								<label>Password<font color="red">*</font><input type="password" name="password" value="" class="form-control" /></label><br /> <br />
								<label>Choose a security question<font color="red">*</font> </label>
								<select name="quest1" class="form-control" style="width: 400px;">
								 <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
								  <option value="What is your favourite teacher's name?">What is your favourite teacher's name?</option>
								  <option value="What is the name of your elementary school?">What is the name of your elementary school?</option>
								</select>
								<br /> <br />
								<label>Answer<font color="red">*</font><input type="text" name="answer1" value="" class="form-control" ></label><br /> <br />
								<label>Choose a security question<font color="red">*</font> </label>
								<select name="quest2" class="form-control" style="width: 400px;">
								 <option value="Which year was your father born?">Which year was your father born?</option>
								  <option value="What is your favourite food?">What is your favourite food?</option>
								  <option value="What is the name of your pet's name?">What is the name of your pet's name?</option>
								</select>
								<br /> <br />
								<label>Answer<font color="red">*</font><input type="text" name="answer2" value="" class="form-control" ></label><br /> <br />
								<input type="submit" name="submit" value="Sign up" class="btn btn-primary" onClick="return verify();" />
							  </form>
						</div>
						
						<script type="text/javascript" src="validate.js">
						</script>
						<?php
							//echo $_POST['fname'];
								//Registration for user
							if(isset($_POST['submit'])) {
								$firstName = $_POST['fname'];
								$lastName = $_POST['lname'];
								$address = $_POST['address'];
								$city = $_POST['city'];
								$state = $_POST['state'];
								$zip = $_POST['zip'];
								$tel = $_POST['tel'];
								$email = $_POST['email'];
								$password = $_POST['password'];
								$quest1 = $_POST['quest1'];
								$answer1 = $_POST['answer1'];
								$quest2= $_POST['quest2'];
								$answer2 = $_POST['answer2'];
									
								
								if($data -> getRecordUser($email) != null) {
										echo "<font color='red'><b>Username already taken!</b></font>";
									}
									else {
										$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
										$data -> storeUser($firstName, $lastName, $address, $city, $state, $zip, $tel, $email, $password, $quest1, $quest2, $answer1, $answer2);
										echo "Your account has been successfully created!";
									}
									
								}
						?>
					</div>
				</div>
</div>
<script>
    $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    // store the currently selected tab in the hash value
    $("ul.nav-tabs > li > a").on("shown.bs.tab", function (e) {
        var id = $(e.target).attr("href").substr(1);
        window.location.hash = id;
    });

    // on load of the page: switch to the currently selected tab
    var hash = window.location.hash;
    $('#myTab a[href="' + hash + '"]').tab('show');
</script>
		</div>
</div>
</body>



</html>