<?php
session_start ();
require_once 'connection.php';
require_once 'foursquare.php';
$data_foursq = new Foursquare ();
?>
<!DOCTYPE html>
<head>
<script
src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCqt0V2s8VlZHYEjC2k1k_rWhcSDVFxwfg">
</script>

<script>

var bounds = new google.maps.LatLngBounds();


 function addMarkers(locations, lat1, lng1, lat2, lng2) {

 	var marker, i;
 	var myCenter =new google.maps.LatLng(40.73961668,-74.030238890);
 	console.log( lat1, lng1, lat2, lng2);
	var mapProp = {
			  center:myCenter,
			  zoom:6,
			  mapTypeId:google.maps.MapTypeId.ROADMAP
			  };

			var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);



			var marker1 = new google.maps.Marker({
			     position: new google.maps.LatLng(lat1, lng1),
			     map: map,
			     icon: 'http://maps.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png'
			           });

			  
			var infowindow = new google.maps.InfoWindow({
				   
				   content:"Address-1"
				   });
			 
			google.maps.event.addListener(marker1, 'click', function() {
			  infowindow.open(map,marker1);
			 });
			bounds.extend(marker1.position);
			map.setCenter(bounds.getCenter());
			map.fitBounds(bounds);


			var marker2 = new google.maps.Marker({
			     position: new google.maps.LatLng(lat2, lng2),
			     map: map,
			     icon: 'http://maps.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png'
			           });

			  
			var infowindow2 = new google.maps.InfoWindow({				   
				   content:"Address-2"
				   });
			 
			google.maps.event.addListener(marker2, 'click', function() {
			  infowindow2.open(map,marker2);
			 });
			bounds.extend(marker2.position);
			map.setCenter(bounds.getCenter());
			map.fitBounds(bounds);

			

 	for (i = 0; i < locations.length; i++) {  
 	 	 		createMarker(locations[i],map);
 	}


 	var marker1 = new google.maps.Marker({
	     position: new google.maps.LatLng(lat1, lng1),
	     map: map,
	     icon: 'http://maps.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png'
	           });

	  
	var infowindow = new google.maps.InfoWindow({
		   
		   content:"Address-1"
		   });
	 
	google.maps.event.addListener(marker1, 'click', function() {
	  infowindow.open(map,marker1);
	 });
	bounds.extend(marker1.position);
	map.setCenter(bounds.getCenter());
	map.fitBounds(bounds);
 	
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
	
	<?php if (isset ( $_SESSION ['login'] )) {
	echo "<a href='logout.php' class='btn btn-default'>Logout</a>";
	}
	?>
	<a href="basicsearch.php" class="btn btn-success">Home</a>
	
	<div class="panel panel-info" id="panel-info">
		<h1 align="center">Search Results- MeetHalf Way Search</h1>
		<div class="panel-body" id="panel-body">
			<div id="forms">			
				<div class="form-group" id="content">
					<form method="POST" action="" name="meethalfwayForm"
								id="meethalfwayForm">
								<br> <label>Zip/Address 1<font color="red">*</font> <br /> <input type="search"
									name="address1" id="address1" 
									class="form-control" value="<?php if(isset($_POST['address1'])){ echo $_POST['address1'];} else {if(isset($_GET['address1'])){ echo $_GET['address1'];}}?>" />
								</label> <br>
								<br> <label>Zip/Address 2<font color="red">*</font> <br /> <input type="search"
									name="address2" id="address2" 
									class="form-control" value="<?php if(isset($_POST['address2'])){ echo $_POST['address2'];} else {if(isset($_GET['address2'])){ echo $_GET['address2'];}}?>" />
								</label> <br>
								<br> <label> Radius </label> <select name="radius">
								
									<option value="1">1 mile</option>
									<option value="2">2 miles</option>
									<option value="5">5 miles</option>
									<option value="10">10 miles</option>
									<option value="20">20 miles</option>
								</select> <br>
								<br> <label> Ratings </label> <select name="rating"
									>
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
								</select> <br>
								<br> <input type="submit" name="meethalfwaySearch"
									id="meethalfwaySearch" class="btn btn-primary "
									value="Search" />
							</form>
				</div>
				
				<?php
				require_once 'rendezvousClass.php';
				$data_rendezvous = new Rendezvous ();
				$uid = $data_rendezvous->getUserId($_SESSION['username']);
				$meetHalfWayResult = $data_rendezvous->getSaveMeetSearch($uid);
				echo '<br/><br/><table class="table">';
				echo "<h3>Last Searches</h3>";
				for($i = 0; $i < sizeof($meetHalfWayResult); $i++) {
					$encryption = new Encryption();
			 		$query = "lat=".$encryption->encode($meetHalfWayResult[$i]['latitude']).
			 		"&lng=".$encryption->encode($meetHalfWayResult[$i]['longitude']).
			 		"&rating=". $encryption->encode($meetHalfWayResult[$i]['rating']) .
			 		"&radius=".$encryption->encode($meetHalfWayResult[$i]['radius']).
			 		"&lat1=".$encryption->encode($meetHalfWayResult[$i]['lat1']).
			 		"&lng1=".$encryption->encode($meetHalfWayResult[$i]['lng1']).
			 		 "&lat2=".$encryption->encode($meetHalfWayResult[$i]['lat2']).
			 		"&lng2=".$encryption->encode($meetHalfWayResult[$i]['lng2']);
					//$l_encrypted = $encryption->encode($query);
			 		echo '<td> <a  href="meethalfwayoutput.php?' . $query . '">'. $meetHalfWayResult [$i]['displayName'] . '</a></td></tr>';
				}
				echo '</table>';
				?>
			</div>
			
			<div id="contents" >
				<div id="googleMap"></div>
				<div id="output">
				
				<?php 
					function sendLatLng($data_foursq, $lat, $lng, $radius, $rating, $lat1, $lng1, $lat2, $lng2) {
											
						$result = $data_foursq->latLongRadiusRating ( $lat, $lng, $radius, $rating);								
						$js_result_array = json_encode($result);			
						
						if(is_array($result) == true) {
							
							echo '<script type="text/javascript"> addMarkers('. $js_result_array .','. $lat1.','.$lng1.','.$lat2.','.$lng2.');</script>';						
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
					

					if (isset ( $_POST ['meethalfwaySearch'] )) {
	
						if ( isset ( $_SESSION ['login'] )) {
							$address1 = strip_tags($_POST['address1']);
							$address2 = strip_tags($_POST['address2']);
							$rating = $_POST['rating'];
							$radius = $_POST['radius'];
							$address1 = preg_replace("/\s+/", " ", $address1);
							$address2 = preg_replace("/\s+/", " ", $address2);
							
							$newAddress1 = str_replace(" ", "%2B", $address1);
							$newAddress2 = str_replace(" ", "%2B", $address2);
							
							$resp_latlnggoogle1 = file_get_contents ( "https://maps.googleapis.com/maps/api/geocode/json?address=$newAddress1&key=AIzaSyCqt0V2s8VlZHYEjC2k1k_rWhcSDVFxwfg" );
							$objlatlng1 = json_decode ( $resp_latlnggoogle1, true );
							if ($objlatlng1 ['status'] == "OK") {
								$lat1 = $objlatlng1 ['results'] ['0'] ['geometry'] ['location'] ['lat'];
								$lng1 = $objlatlng1 ['results'] ['0'] ['geometry'] ['location'] ['lng'];
							}
							else{
								echo "<h3> address 1 incorrect,please try again !! </h3><br>"; 
							}
							$resp_latlnggoogle2 = file_get_contents ( "https://maps.googleapis.com/maps/api/geocode/json?address=$newAddress2&key=AIzaSyCqt0V2s8VlZHYEjC2k1k_rWhcSDVFxwfg" );
							$objlatlng2 = json_decode ( $resp_latlnggoogle2, true );
							if ($objlatlng2 ['status'] == "OK") {
								$lat2 = $objlatlng2 ['results'] ['0'] ['geometry'] ['location'] ['lat'];
								$lng2 = $objlatlng2 ['results'] ['0'] ['geometry'] ['location'] ['lng'];
							}
							else{
								echo "<h3> address 2 incorrect,please try again !! </h3><br>"; 
							}
						
							require_once 'rendezvousClass.php';
							$data_rendezvous = new Rendezvous ();
							
							$result_latlong = $data_rendezvous->meetHalwayCalculation($lat1,$lng1,$lat2,$lng2);
							
							$latlong = explode(",",$result_latlong);
							$midlat = $latlong[0];
							$midlong = $latlong[1];
					
							
							$_SESSION['rating'] = $rating;
							$_SESSION['radius'] = $radius;
							$_SESSION['lat'] = $midlat;
							$_SESSION['lng'] = $midlong;
							$_SESSION['lat1'] = $lat1;
							$_SESSION['lng1'] = $lng1;
							$_SESSION['lat2'] = $lat2;
							$_SESSION['lng2'] = $lng2;
							
							
							
							$uid = $data_rendezvous->getUserId($_SESSION['username']);
							$displayName = "$address1,$address2";		
							$data_rendezvous->insertMeetSearch($uid, $midlat, $midlong, $rating, $radius, $displayName,$lat1, $lng1,$lat2,$lng2);
							
							
					}
				
					}
				
				if(isset($_GET['lat']) && isset($_GET['lng']) && isset($_GET['lat1']) && isset($_GET['lng1']) && isset($_GET['lat2']) && isset($_GET['lng2']) &&   isset($_GET['radius']) && isset($_GET['rating'])) {
				
					$encryption = new Encryption();
					
					$lat = $encryption->decode($_GET['lat']);
					$lng = $encryption->decode($_GET['lng']);
					$radius = $encryption->decode($_GET['radius']);
					$rating = $encryption->decode($_GET['rating']);
					$lat1 = $encryption->decode($_GET['lat1']);
					$lng1 = $encryption->decode($_GET['lng1']);
					$lat2 = $encryption->decode($_GET['lat2']);
					$lng2 = $encryption->decode($_GET['lng2']);
					
					unset( $_GET['lat']);
					unset($_GET['lng']);
					unset( $_GET['lat1']);
					unset($_GET['lng1']);
					unset( $_GET['lat2']);
					unset($_GET['lng2']);
					unset($_GET['rating']);
					unset($_GET['radius']);
					
					sendLatLng($data_foursq, $lat, $lng, $radius, $rating, $lat1, $lng1, $lat2, $lng2);
				
				}
				
				if (isset($_SESSION['lat']) && isset($_SESSION['lng']) && isset($_SESSION['lat1']) && isset($_SESSION['lng1']) && isset($_SESSION['lat2']) && isset($_SESSION['lng2']) && isset($_SESSION['rating']) && isset($_SESSION['radius']) ) {
				
					$lat = ( trim ( $_SESSION['lat']));
					$lat = strip_tags ( $lat );
					$lng = ( trim ( $_SESSION['lng']));
					$lng = strip_tags ( $lng );
					$lat1 = ( trim ( $_SESSION['lat1']));
					$lat1 = strip_tags ( $lat1 );
					$lng1 = ( trim ( $_SESSION['lng1']));
					$lng1 = strip_tags ( $lng1 );	
					$lat2 = ( trim ( $_SESSION['lat2']));
					$lat2 = strip_tags ( $lat2 );
					$lng2 = ( trim ( $_SESSION['lng2']));
					$lng2 = strip_tags ( $lng2 );
					$radius = ( trim ( $_SESSION['radius']));
					$rating = ( trim ( $_SESSION['rating']));
						
					unset( $_SESSION['lat']);
					unset($_SESSION['lng']);
					unset( $_SESSION['lat1']);
					unset($_SESSION['lng1']);
					unset( $_SESSION['lat2']);
					unset($_SESSION['lng2']);
					unset($_SESSION['rating']);
					unset($_SESSION['radius']);
				
					sendLatLng($data_foursq, $lat, $lng, $radius, $rating, $lat1, $lng1, $lat2, $lng2);
						
				}
				
			
			

?>







</body>
</html>
