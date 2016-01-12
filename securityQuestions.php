<?php
session_start();
require_once 'rendezvousClass.php';
$data = new Rendezvous();
$username = $_SESSION['username'];
$question1 = null;
$question2 = null;

	$question1 = $data->getQuestion1($username);
	$question2 = $data->getQuestion2($username);
	
	echo $question1;
	echo $question2;
	
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
	height:500px;
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
		<h1 align="center">Security Questions</h1>

		<div class="panel-body">

			<div class="form-group" id="content">

				<form method="POST" action="" name="securityQuestionForm">
					<label> Security Question 1 <input type="text" id="question1" style="width: 450px;" name="question1" value="<?php echo $question1; ?>" class="form-control" readonly /> </label><br />
					<label>Answer<font color="red">*</font> <input type="text" name="answer1" id="answer1" class="form-control" /></label><br />
					<label>Security Question 2 <input type="text" id="question2" style="width: 450px;" name="quesion2" value="<?php echo $question2; ?>" class="form-control" readonly /> </label> <br />
					<label> Answer<font color="red">*</font> <input type="text" name="answer2" id="answer2" class="form-control" /></label> <br /><br />
					<input type="submit" id="submit" name="submit" value="Submit" class="btn btn-primary" />
				</form>

				<?php 
				if(isset($_POST['submit'])) {
					$answer1 = strip_tags($_POST['answer1']);
					$answer2 = strip_tags($_POST['answer2']);
					
					$getAnswer1 = $data->getAnswer1($username);
					$getAnswer2 = $data->getAnswer2($username);
					
					//echo $getAnswer1;
					//echo $getAnswer2;
					
					if($answer1=="" || $answer2=="")
						echo "<font color='red'><b>Answers should not be empty!</b></font>";
					
					else if($getAnswer1 == $answer1 && $getAnswer2 == $answer2) {
						header("Location:changepassword.php");
					}
					
					else {
						echo "<font color='red'><b>Security answers doesn't match!</b></font>";
					}
				}
				?>
</div>
</div>
</div>
</body>
</html>