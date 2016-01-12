<?php
ob_start();
session_start ();
require_once 'connection.php';
require_once 'foursquare.php';
$data_foursq = new Foursquare ();
?>

<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Rendezvous - Advance Search</title>
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
	margin-top: 30px;
	width: 600px;
	height:850px;
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

.btn-success {
	position:absolute;
	top:30px;
	right:150px;
	color: #428bca;
	font-weight: bold;
	background: white;
	border: white;
}

.btn-success:hover {
	background: #E8E8E8;
	color: black;
}

.btn-info {
	position:absolute;
	top:30px;
	right:150px;
	color: #428bca;
	font-weight: bold;
	background: white;
	border: white;
}

.btn-info:hover {
	background: #E8E8E8;
	color: black;
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

	<?php 
	if (isset ( $_SESSION ['login'] )) {
	echo "<a href='logout.php' class='btn btn-default'>Logout</a>";
	echo "<a href='basicsearch.php' class='btn btn-success'>Home</a>";
	}
	else
		echo "<a href='homepage.php' class='btn btn-info'>Home</a>";
	?>
	<!-- Javascript code for validations  -->
	<script type="text/javascript">
				function advValidation(){
	            var name = document.form.name;
	            var city = document.form.city;
	            var zip = document.form.zip;
	            var long = document.form.long;
	            var lat = document.form.lat;
	            errmsg="";
	            if((city.value == "") && (long.value == "") && (lat.value == "")  && (zip.value == "")){
		 
		  
		        errmsg +="Please enter aleast city (or) longitude & latitude to search";
		  
				 }
				
				  if((city.value !== "") && (!city.value.match(/^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$/)))
					{
						city.style.background = 'Yellow';
						errmsg += "Enter a valid city.\n";
					}
				  /*if(zip.value == "")
					{
						zip.style.background = 'Yellow';
						errmsg += "Enter a valid zip code.\n";
					}*/
				  if((long.value !== "") && (!long.value.match(/^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}/)))
					{
					  long.style.background = 'Yellow';
					  errmsg += "Enter a valid longitute number.\n";
					}
				  if((lat.value !== "") && (!lat.value.match(/^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}/)))
					{
					  lat.style.background = 'Yellow';
					  errmsg += "Enter a valid latitute number.\n";
					}
		  
	  
	  
				
	  if(errmsg.length > 0){
	    	//document.signup.innerHTML = "<ul>" + errmsg + "</ul>";
			alert("You must provide the following fields:\n" +errmsg);
	        return false;
	    	
	    }
	  
	    return true;
}

			    </script>
	<div class="panel panel-info">
		<h1 align="center">Advanced Search</h1>

		<div class="panel-body">

			<div class="form-group" id="content">

				<form method="post" action="" name="form" class="form-horizontal" onsubmit="return advValidation()">
					<div class="col-xs-3">
						<label>Venue Name<input type="text" name="name"
							class="form-control" /> </label>
							<div class="row">
    
    <label for="location" class="control-label input-group">Select type of loacation:</label>
       <div class="col-sm-9">
        <label class="btn">
            <input onclick="document.getElementById('zip').disabled = true; document.getElementById('lat').disabled = true; document.getElementById('long').disabled = true; document.getElementById('city').disabled = false; document.getElementById('zip').value = '';document.getElementById('lat').value = '';document.getElementById('lng').value = ''; " type="radio" name="location" value="cityVal"  checked="checked">City
        </label><br/>
        <label class="btn">
            <input onclick=" document.getElementById('zip').disabled = false; document.getElementById('lat').disabled = true; document.getElementById('long').disabled = true; document.getElementById('city').disabled = true; document.getElementById('city').value = '';document.getElementById('lat').value = '';document.getElementById('lng').value = ''; " type="radio" name="location" value="zipcodeVal">Zipcode
        </label><br/>
        <label class="btn">
            <input onclick="document.getElementById('zip').disabled = true; document.getElementById('lat').disabled = false; document.getElementById('long').disabled = false; document.getElementById('city').disabled = true; document.getElementById('zip').value = '';document.getElementById('city').value = ''; " type="radio" name="location" value="latLng">Lat-Long
        </label>
    </div> 
  </div>
							<label>City <input type="text" id="city"
							name="city" class="form-control"></label>
							 <label>Zip Code</label><input disabled
							id = "zip" type="text" name="zip" class="form-control">
							 <label>Latitude </label><input disabled
							id="lat" type="text" name="lat" class="form-control">
							 <label>Longitude</label>
						<input disabled type="text" id="long" name="long" class="form-control"> 
						<label>Radius		</label>
						
						
						
						<select name="radius" class="form-control">
							<option value="1">1 miles</option>
							<option value="2" selected="selected">2 miles</option>
							<option value="5">5 miles</option>
							<option value="10">10 miles</option>
							<option value="20">20 miles</option>
						</select> <label>Ratings</label> <select name="rating"
							class="form-control">
							<option value="1" selected="selected">1 star</option>
							<option value="2">2 stars</option>
							<option value="3">3 stars</option>
							<option value="4">4 stars</option>
							<option value="5">5 stars</option>
							<option value="6">6 stars</option>
							<option value="7">7 stars</option>
							<option value="8">8 stars</option>
							<option value="9">9 stars</option>
							<option value="10">10 stars</option>
						</select><br>
						<br>
						<button type="Submit" name="adv-search"
							class="btn btn-primary btn-lg btn-block">Search</button>
					</div>
				</form>


				<?php
				if (isset ( $_POST ['adv-search'] )) {
					
					//1	 City, Radius, Rating
					if (($_POST ['long'] == "") && ($_POST ['lat'] == "") && ($_POST ['name'] == "") && ($_POST ['zip'] == "")) {
						if (isset ( $_POST ['city'] ) ) {								
							$city = strip_tags ( trim ( $_POST ['city'] ) );
							$rating = strip_tags ( $_POST ['rating'] );
							$radius = strip_tags ( $_POST ['radius'] );	
							$city = preg_replace("/\s+/", " ", $city);
							$_SESSION['city'] = $city;
							$_SESSION['rating'] = $rating;
							$_SESSION['radius'] = $radius;
						}
					}
					
					//2  Name, City, Radius, Rating
					elseif (($_POST ['long'] == "") && ($_POST ['lat'] == "") && ($_POST ['zip'] == "")) {
						if (isset ( $_POST ['name'] ) && isset ( $_POST ['city'] )) {							
							$name = strip_tags ( trim ( $_POST ['name'] ) );
							$city = strip_tags ( trim ( $_POST ['city'] ) );
							$rating = strip_tags ( $_POST ['rating'] );
							$radius = strip_tags ( $_POST ['radius'] );	
							$name = preg_replace("/\s+/", " ", $name);
							$city = preg_replace("/\s+/", " ", $city);
							$_SESSION['name'] = $name;
							$_SESSION['city'] = $city;
							$_SESSION['rating'] = $rating;
							$_SESSION['radius'] = $radius;							
						}
					}
					
					//3 zipcode, Radius, Rating								
					elseif (($_POST ['long'] == "") && ($_POST ['lat'] == "") && ($_POST ['city'] == "") && ($_POST ['name'] == "")) {
						if (isset ( $_POST ['zip'] )) {							
							$zip = strip_tags ( $_POST ['zip'] );
							$rating = strip_tags ( $_POST ['rating'] );
							$radius = strip_tags ( $_POST ['radius'] );							
							$_SESSION['zip'] = $zip;
							$_SESSION['rating'] = $rating;
							$_SESSION['radius'] = $radius;
						}					
					}
					
					//4	 Zip, Name, Radius, Rating								
					elseif (($_POST ['long'] == "") && ($_POST ['lat'] == "") && ($_POST ['city'] == "")) {
						if (isset ( $_POST ['name'] ) && isset ( $_POST ['zip'] )) {
							$name = strip_tags ( trim ( $_POST ['name'] ) );
							$zip = strip_tags ( $_POST ['zip'] );
							$rating = strip_tags ( $_POST ['rating'] );
							$radius = strip_tags ( $_POST ['radius'] );		
							$name = preg_replace("/\s+/", " ", $name);
							$_SESSION['name'] = $name;
							$_SESSION['zip'] = $zip;
							$_SESSION['rating'] = $rating;
							$_SESSION['radius'] = $radius;
						}
					} 
					
					//5  Lat + Lng + radius +rating
					elseif (($_POST ['name'] == "") && ($_POST ['zip'] == "") && ($_POST ['city'] == "")) {
						if ( isset ( $_POST ['lat'] ) && isset ( $_POST ['long'] )) {
							$lat = strip_tags ( $_POST ['lat'] );
							$long = strip_tags ( $_POST ['long'] );
							$rating = strip_tags ( $_POST ['rating'] );
							$radius = strip_tags ( $_POST ['radius'] );							
							$_SESSION['lat'] = $lat ;
							$_SESSION['long'] = $long;
							$_SESSION['rating'] = $rating;
							$_SESSION['radius'] = $radius;
						}
					} 
					
					//6 Name, Lat, long, radius, rating
					elseif (($_POST ['city'] == "") && ($_POST ['zip'] == "")) {
						if (isset ( $_POST ['name'] ) && isset ( $_POST ['lat'] ) && isset ( $_POST ['long'] )) {
							$name = strip_tags ( trim ( $_POST ['name'] ) );
							$lat = strip_tags ( $_POST ['lat'] );
							$long = strip_tags ( $_POST ['long'] );
							$rating = strip_tags ( $_POST ['rating'] );
							$radius = strip_tags ( $_POST ['radius'] );
							$name = preg_replace("/\s+/", " ", $name);
							$_SESSION['name'] = $name ;
							$_SESSION['lat'] = $lat ;
							$_SESSION['long'] = $long;
							$_SESSION['rating'] = $rating;
							$_SESSION['radius'] = $radius;							
						}			
					}
					
					//7 City, Lat, Long ,Radius, rating
					elseif (($_POST ['name'] == "") && ($_POST ['zip'] == "")) {
						if (isset ( $_POST ['city'] ) && isset ( $_POST ['lat'] ) && isset ( $_POST ['long'] )) {
							$city = strip_tags ( trim ( $_POST ['city'] ) );
							$lat = strip_tags ( $_POST ['lat'] );
							$long = strip_tags ( $_POST ['long'] );
							$rating = strip_tags ( $_POST ['rating'] );
							$radius = strip_tags ( $_POST ['radius'] );	
							$city = preg_replace("/\s+/", " ", $city);
							$_SESSION['city'] = $city ;
							$_SESSION['lat'] = $lat ;
							$_SESSION['long'] = $long;
							$_SESSION['rating'] = $rating;
							$_SESSION['radius'] = $radius;
						}					
					}			
					
					header('Location: advanceSearchOutput.php');
				}// submit
				?>
			</div>
		</div>
	</div>
</body>
</html>