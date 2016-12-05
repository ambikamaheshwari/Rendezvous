<?php
ob_start();
session_start ();
require_once 'connection.php';
require_once 'foursquare.php';
$data_foursq = new Foursquare ();
?>
<!DOCTYPE html>
<head>
<script
src="http://maps.googleapis.com/maps/api/js?key=123456qwerty">
</script>

<script>

var bounds = new google.maps.LatLngBounds();


 function addMarkers(locations) {

 	var marker, i;
 	var myCenter =new google.maps.LatLng(40.73961668,-74.030238890);

	var mapProp = {
			  center:myCenter,
			  zoom:6,
			  mapTypeId:google.maps.MapTypeId.ROADMAP
			  };

			var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
 //	alert("myCenter " + locations[0].name);
 	for (i = 0; i < locations.length; i++) {  
 	 	 		createMarker(locations[i],map);
 	}
 }

function createMarker(location, map) {
	
				
	
   var contentString = 	"<h3>" + location.name + "</h3> " +
   						"<p>" + location.address + ",</p>" +
  					   	"<p>" + location.city + ", " + location.state + ", "  + location.zipcode + "</p> " + 
  					 	"<p>" + location.phone + "</p>";
   var marker = new google.maps.Marker({
     position: new google.maps.LatLng(location.lat, location.lng),
     map: map,
           });

   

   var infowindow = new google.maps.InfoWindow({
	   
	   content:contentString
	   });
   
  google.maps.event.addListener(marker, 'click', function() {
    infowindow.open(map,marker);
   });
  bounds.extend(marker.position);
  map.setCenter(bounds.getCenter());
  map.fitBounds(bounds);
}

</script>


<meta charset="utf-8">
<title>Rendezvous - Search Output</title>
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
	width: 1300px;
	margin: 30px auto;
}

#panel-body {
	overflow: hidden;
}

#contents {
	
	width: 750px;
	min-height: 700px;
	margin-left: 475px;
}

#forms {
	
	width: 450px;
	min-height: 700px;
	float: left;
}

#googleMap {

	width: 750px;
	min-height: 400px;
	
}

#output {

	margin-top: 25px;
	width: 750px;
	min-height: 300px;
	overflow-y: scroll;
	max-height: 300px;
	
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

h3 {
color: #428bca;
	
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
	<div id="header">
		<h2>&nbsp;Rendezvous...</h2>
		<h4>
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
			&nbsp; &nbsp; &nbsp; &nbsp; <font color="white"> Meet your people at
				your chosen places</font>
		</h4>
	</div>
	
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
	            var name = document.Form.name;
	            var city = document.Form.city;
	            var zip = document.Form.zip;
	            var long = document.Form.long;
	            var lat = document.Form.lat;
	            errmsg="";
	            
		        if((city.value == "") && (long.value == "") && (lat.value == "") && (zip.value == "")){
		 
		  
		        errmsg +="Please enter aleast city (or) longitude & latitude (or) zip to search";
		  
				 }
				if((long.value !== "") && (lat.value == "")){
					  
				 errmsg +="Please enter latitude to search";
					  
				 }
				if((lat.value !== "") && (long.value == "")){
					  
				errmsg +="Please enter longitude to search";
					  
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
	<div class="panel panel-info" id="panel-info">
	
		<h1 align="center">Search Results</h1>
		<div class="panel-body" id="panel-body">
		
			<div id="forms">
				<div class="form-group" id="content">

				<form method="post" action="" action="advanceSearchOutput.php" name="Form" class="form-horizontal" onsubmit="return advValidation()">
					<div class="col-xs-3">
						<label>Venue Name</label>
						<input type="text" name="name" class="form-control" value="<?php if(isset($_POST['name'])){ echo $_POST['name'];} else {if(isset($_SESSION['name'])){ echo $_SESSION['name'];}}?>" /> 
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
						
						<label>City </label>
						<input type="text" id = "city" name="city" class="form-control" value="<?php if(isset($_POST['city'])){ echo $_POST['city'];} else {if(isset($_SESSION['city'])){ echo $_SESSION['city'];}}?>" >
						<label>Zip Code</label>
						<input disabled type="text" id="zip" name="zip" class="form-control" value="<?php if(isset($_POST['zip'])){ echo $_POST['zip'];} else {if(isset($_SESSION['zip'])){ echo $_SESSION['zip'];}}?>" >
						<label>Latitude </label>
						<input disabled type="text" id="lat" name="lat" class="form-control" value="<?php if(isset($_POST['lat'])){ echo $_POST['lat'];} else {if(isset($_SESSION['lat'])){ echo $_SESSION['lat'];}}?>"  >
						<label>Longitude</label>
						<input disabled type="text" id="long" name="long" class="form-control" value="<?php if(isset($_POST['long'])){ echo $_POST['long'];} else {if(isset($_SESSION['long'])){ echo $_SESSION['long'];}}?>"> 
						<label>Radius</label>						
						<select name="radius" class="form-control"  >
							<option value="1">1 miles</option>
							<option value="2" selected="selected">2 miles</option>
							<option value="5">5 miles</option>
							<option value="10">10 miles</option>
							<option value="20">20 miles</option>
						</select>
						<label>Ratings</label>
						<select name="rating" class="form-control">
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
						<button type="Submit" name="adv-search"	class="btn btn-primary btn-lg btn-block" >Search</button>
					</div>
				</form>
			
			</div>
			
			</div>
			<div id="contents" >

				<div id="googleMap">
				</div>
				
				<div id="output">
				
				<?php 
				function sendNameCityRadiusRating($data_foursq, $name, $city, $rating, $radius) {
				
					$result = $data_foursq->NameCityRadiusRating ( $name, $city, $radius, $rating );
							
					$js_result_array = json_encode($result);
					require_once 'rendezvousClass.php';
					$data = new Rendezvous();
		
					if(is_array($result) == true) {
						
						echo '<script type="text/javascript"> addMarkers('. $js_result_array .');</script>';
						
						for($i = 0; $i < sizeof($result); $i++) {
							echo "<h3>". $result[$i]['name']." </h3><br>";
							echo $result[$i]['address'].", ";
							echo $result[$i]['city'].", ".$result[$i]['state'].", ".$result[$i]['zipcode']." <br>";
							echo $result[$i]['phone']." <br>  <a href=".$result[$i]['url']."> ".$result[$i]['url'] ."</a> <br>";
							echo "<label>Rating </label> ". $result[$i]['rating']."<br>";
							echo "<hr>";
						}						
					}
					else {
						echo "<h3>". $result." </h3><br>";
					}
					
							
				}
				
				function sendLatLongRadiusRating($data_foursq, $lat, $long, $radius, $rating) {
				
					$result = $data_foursq->latLongRadiusRating ($lat, $long, $radius, $rating );
						
					$js_result_array = json_encode($result);
						
				
					if(is_array($result) == true) {
						echo '<script type="text/javascript"> addMarkers('. $js_result_array .');</script>';
							
						for($i = 0; $i < sizeof($result); $i++) {
							echo "<h3>". $result[$i]['name']." </h3><br>";
							echo $result[$i]['address'].", ";
							echo $result[$i]['city'].", ".$result[$i]['state'].", ".$result[$i]['zipcode']." <br>";
							echo $result[$i]['phone']." <br>  <a href=".$result[$i]['url']."> ".$result[$i]['url'] ."</a> <br>";
							echo "<label>Rating </label> ". $result[$i]['rating']."<br>";
							echo "<hr>";
						}
					}
					else {
						echo "<h3>". $result." </h3><br>";
					}
						
						
				}
				
			
				function sendCityRadiusRating($data_foursq, $city, $rating, $radius) {
				
					$result = $data_foursq->CityRadiusRating ( $city, $radius, $rating );
						
					$js_result_array = json_encode($result);
						
					if(is_array($result) == true) {
						echo '<script type="text/javascript"> addMarkers('. $js_result_array .');</script>';						
						for($i = 0; $i < sizeof($result); $i++) {
							echo "<h3>". $result[$i]['name']." </h3><br>";
							echo $result[$i]['address'].", ";
							echo $result[$i]['city'].", ".$result[$i]['state'].", ".$result[$i]['zipcode']." <br>";
							echo $result[$i]['phone']." <br>  <a href=".$result[$i]['url']."> ".$result[$i]['url'] ."</a> <br>";
							echo "<label>Rating </label> ". $result[$i]['rating']."<br>";
							echo "<hr>";
						}					
					}
					else {
						echo "<h3>". $result." </h3><br>";
					}				
						
						
				}
				
				function sendZipRadiusRating($data_foursq, $zip, $radius, $rating) {
				
					$result = $data_foursq->ZipRadiusRating ($zip, $radius, $rating );
				
					$js_result_array = json_encode($result);
				
					if(is_array($result) == true) {
						echo '<script type="text/javascript"> addMarkers('. $js_result_array .');</script>';
					
						for($i = 0; $i < sizeof($result); $i++) {
							echo "<h3>". $result[$i]['name']." </h3><br>";
							echo $result[$i]['address'].", ";
							echo $result[$i]['city'].", ".$result[$i]['state'].", ".$result[$i]['zipcode']." <br>";
							echo $result[$i]['phone']." <br>  <a href=".$result[$i]['url']."> ".$result[$i]['url'] ."</a> <br>";
							echo "<label>Rating </label> ". $result[$i]['rating']."<br>";
							echo "<hr>";
						}	
					}
					else {
						echo "<h3>". $result." </h3><br>";
					}			
				}
				
				function sendZipNameRadiusRating($data_foursq, $name, $zip, $rating, $radius) {
				
					$result = $data_foursq->ZipNameRadiusRating ( $name, $zip , $radius, $rating );
						
					$js_result_array = json_encode($result);

					if(is_array($result) == true) {
						echo '<script type="text/javascript"> addMarkers('. $js_result_array .');</script>';
							
						for($i = 0; $i < sizeof($result); $i++) {
							echo "<h3>". $result[$i]['name']." </h3><br>";
							echo $result[$i]['address'].", ";
							echo $result[$i]['city'].", ".$result[$i]['state'].", ".$result[$i]['zipcode']." <br>";
							echo $result[$i]['phone']." <br>  <a href=".$result[$i]['url']."> ".$result[$i]['url'] ."</a> <br>";
							echo "<label>Rating </label> ". $result[$i]['rating']."<br>";
							echo "<hr>";
						}
					}
					else {
						echo "<h3>". $result." </h3><br>";
					}	
				}
				
				function sendNameLatLongRadiusRating($data_foursq, $name, $lat, $long, $rating, $radius) {
				
					$result = $data_foursq->LatLongNameRadiusRating ( $lat, $long, $name, $radius, $rating );

					$js_result_array = json_encode($result);
				
					if(is_array($result) == true) {
						echo '<script type="text/javascript"> addMarkers('. $js_result_array .');</script>';
					
						for($i = 0; $i < sizeof($result); $i++) {
							echo "<h3>". $result[$i]['name']." </h3><br>";
							echo $result[$i]['address'].", ";
							echo $result[$i]['city'].", ".$result[$i]['state'].", ".$result[$i]['zipcode']." <br>";
							echo $result[$i]['phone']." <br>  <a href=".$result[$i]['url']."> ".$result[$i]['url'] ."</a> <br>";
							echo "<label>Rating </label> ". $result[$i]['rating']."<br>";
							echo "<hr>";
						}
					}
					else {
						echo "<h3>". $result." </h3><br>";
					}
				 
					
				}
				
				function sendCityLatLongRadiusRating($data_foursq, $name,$lat, $long, $rating, $radius) {
				
					$result = $data_foursq->ZipNameRadiusRating ( $name, $zip , $radius, $rating );
				
					$js_result_array = json_encode($result);
				
					if(is_array($result) == true) {
						echo '<script type="text/javascript"> addMarkers('. $js_result_array .');</script>';
					
						for($i = 0; $i < sizeof($result); $i++) {
							echo "<h3>". $result[$i]['name']." </h3><br>";
							echo $result[$i]['address'].", ";
							echo $result[$i]['city'].", ".$result[$i]['state'].", ".$result[$i]['zipcode']." <br>";
							echo $result[$i]['phone']." <br>  <a href=".$result[$i]['url']."> ".$result[$i]['url'] ."</a> <br>";
							echo "<label>Rating </label> ". $result[$i]['rating']."<br>";
							echo "<hr>";
						}
					}
					else {
						echo "<h3>". $result." </h3><br>";
					}
				
				}
				
				
				if (isset ( $_POST ['adv-search'] )) {
					
					//	 City, Radius, Rating
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

					
					//Name, City, Radius, Rating
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
					
					//zipcode, Radius, Rating								
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
					
					//	 Zip, Name, Radius, Rating							
									
					elseif (($_POST ['long'] == "") && ($_POST ['lat'] == "") && ($_POST ['city'] == "")) {

						if (isset ( $_POST ['name'] ) && isset ( $_POST ['zip'] )) {
							$name = strip_tags ( trim ( $_POST ['name'] ) );
							$zip = strip_tags ( $_POST ['zip'] );
							$rating = strip_tags ( $_POST ['rating'] );
							$radius = strip_tags ( $_POST ['radius'] );							
							$_SESSION['name'] = $name;
							$_SESSION['zip'] = $zip;
							$_SESSION['rating'] = $rating;
							$_SESSION['radius'] = $radius;
						}
					} 
					
					//  Lat + Lng + radius +rating
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
					
					// Name, Lat, long, radius, rating
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
					
					// City, Lat, Long ,Radius, rating
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
					else {
						echo "<h3>". 'Please enter required fields.'." </h3><br>";
					}

}// submit





//Name, lat, long, Rating,Radius
if (isset($_SESSION['name']) && isset($_SESSION['lat']) && isset($_SESSION['long']) && isset($_SESSION['rating']) && isset($_SESSION['radius'])) {

	$name = ( trim ( $_SESSION['name']));
	$name = strip_tags ( $name );
	$lat = strip_tags( trim ( $_SESSION['lat']));
	$long = strip_tags( trim ( $_SESSION['long']));
	$rating = strip_tags ( $_SESSION['rating'] );
	$radius = strip_tags ( $_SESSION['radius']) ;

	unset( $_SESSION['name']);
	unset($_SESSION['lat']);
	unset($_SESSION['long']);
	unset($_SESSION['rating']);
	unset($_SESSION['radius']);

	sendNameLatLongRadiusRating($data_foursq, $name, $lat,$long, $rating, $radius);

}


//City, lat, long, Rating,Radius
if (isset($_SESSION['city']) && isset($_SESSION['lat']) && isset($_SESSION['long']) && isset($_SESSION['rating']) && isset($_SESSION['radius'])) {

	$city = ( trim ( $_SESSION['city']));
	$city= strip_tags ( $city );
	$lat = strip_tags( trim ( $_SESSION['lat']));
	$long = strip_tags( trim ( $_SESSION['long']));
	$rating = strip_tags ( $_SESSION['rating'] );
	$radius = strip_tags ( $_SESSION['radius']) ;

	unset( $_SESSION['city']);
	unset($_SESSION['lat']);
	unset($_SESSION['long']);
	unset($_SESSION['rating']);
	unset($_SESSION['radius']);

	sendCityLatLongRadiusRating($data_foursq, $city, $lat,$long, $rating, $radius);

}

// Name, City, Radius, Rating
if (isset($_SESSION['name']) && isset($_SESSION['city']) && isset($_SESSION['rating']) && isset($_SESSION['radius'])) {

	$name = ( trim ( $_SESSION['name']));
	$name = strip_tags ( $name );
	$city = ( trim ( $_SESSION['city']));
	$city = strip_tags ( $city );
	$rating = strip_tags ( $_SESSION['rating'] );
	$radius = strip_tags ( $_SESSION['radius']) ;

	unset( $_SESSION['name']);
	unset($_SESSION['city']);
	unset($_SESSION['rating']);
	unset($_SESSION['radius']);

	sendNameCityRadiusRating($data_foursq, $name, $city, $rating, $radius);

}

// Lat, Long, Radius, Rating
if (isset($_SESSION['lat']) && isset($_SESSION['long']) && isset($_SESSION['rating']) && isset($_SESSION['radius'])) {

	$lat = strip_tags(trim ( $_SESSION['lat']));
	
	$long = strip_tags(trim ( $_SESSION['long']));

	$rating = strip_tags ( $_SESSION['rating'] );
	$radius = strip_tags ( $_SESSION['radius']) ;

	unset($_SESSION['lat']);
	unset($_SESSION['long']);
	unset($_SESSION['rating']);
	unset($_SESSION['radius']);

	sendLatLongRadiusRating($data_foursq, $lat, $long, $radius, $rating);

}


//Name, Zip, Rating,Radius
if (isset($_SESSION['name']) && isset($_SESSION['zip']) && isset($_SESSION['rating']) && isset($_SESSION['radius'])) {

	$name = ( trim ( $_SESSION['name']));
	$name = strip_tags ( $name );
	$zip = strip_tags( trim ( $_SESSION['zip']));
	$rating = strip_tags ( $_SESSION['rating'] );
	$radius = strip_tags ( $_SESSION['radius']) ;

	unset( $_SESSION['name']);
	unset($_SESSION['zip']);
	unset($_SESSION['rating']);
	unset($_SESSION['radius']);

	sendZipNameRadiusRating($data_foursq, $name, $zip, $rating, $radius);

}


//Zip, Radius, Rating
if (isset($_SESSION['zip']) && isset($_SESSION['rating']) && isset($_SESSION['radius'])) {

	$zip = strip_tags(trim ( $_SESSION['zip']));
	$rating = strip_tags ( $_SESSION['rating'] );
	$radius = strip_tags ( $_SESSION['radius']) ;

	unset($_SESSION['zip']);
	unset($_SESSION['rating']);
	unset($_SESSION['radius']);

	sendZipRadiusRating($data_foursq, $zip, $radius, $rating);

}

//City, Radius, Rating
if (isset($_SESSION['city']) && isset($_SESSION['rating']) && isset($_SESSION['radius'])) {
	$city = ( trim ( $_SESSION['city']));
	$city = strip_tags ( $city );
	$rating = strip_tags ( $_SESSION['rating'] );
	$radius = strip_tags ( $_SESSION['radius']) ;

	unset($_SESSION['city']);
	unset($_SESSION['rating']);
	unset($_SESSION['radius']);

	sendCityRadiusRating($data_foursq, $city, $radius, $rating);

}

if (isset($_SESSION['zip']) && isset($_SESSION['rating']) && isset($_SESSION['radius'])) {



	$zip = strip_tags(trim ( $_SESSION['zip']));
	$rating = strip_tags ( $_SESSION['rating'] );
	$radius = strip_tags ( $_SESSION['radius']) ;

	unset($_SESSION['zip']);
	unset($_SESSION['rating']);
	unset($_SESSION['radius']);

	sendZipRadiusRating($data_foursq, $zip, $radius, $rating);

}
?></div>
				

			</div>
		</div>
	</div>








</body>
</html>
