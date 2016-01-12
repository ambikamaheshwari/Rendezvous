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
	<script type="text/javascript">
				function vali(){
	            var venue = document.basicSearchForm.venue;
	            var city = document.basicSearchForm.city;
				errmsg="";
	            if((venue.value == "") )
	            {
	    	    venue.style.background = 'Yellow';
	            errmsg += "Please enter a venue name.\n";
	        
	            }
                 if((city.value == "") )
	            {
	    	    city.style.background = 'Yellow';
	           errmsg += "please enter a city.\n";
	        
	            }
                if(errmsg.length > 0){
			    alert("You must provide the following fields:\n" +errmsg);
	            return false;
	    	
	            }
	  
	            return true;					
				
				}
			    </script>
	<div class="panel panel-info" id="panel-info">
		<h1 align="center">Search Results- Basic Search</h1>
		<div class="panel-body" id="panel-body">
			<div id="forms">			
				<div class="form-group" id="content">
					<form method="POST" action="" name="basicSearchForm" id="basicSearchForm" class="form-horizontal" onsubmit="return vali()">
	
						
<label>Venue Name<font color="red">*</font> <br /> <input type="search" name="venue" id="venue" class="form-control" value="<?php if(isset($_POST['venue'])){ echo $_POST['venue'];} else {if(isset($_SESSION['venue'])){ echo $_SESSION['venue'];}}?>" /></label> <br /> <br />
<label>City<font color="red">*</font> <br /> <input type="search" name="city" id="city" class="form-control" value="<?php if(isset($_POST['city'])){ echo $_POST['city'];} else {if(isset($_SESSION['city'])){ echo $_SESSION['city'];}}?>"/></label> <br /> <br /><input type="submit" name="basicSearch" id="basicSearch" class="btn btn-primary" value="Search" /> &nbsp;&nbsp;&nbsp;&nbsp;
						<font size="3px" ><a href="advancedsearch.php">Advanced Search</a></font>
						<br /> <br />	
						<?php 
						  require_once 'rendezvousClass.php';
		                  $data_rendezvous = new Rendezvous ();
						  $uid = $data_rendezvous->getUserId($_SESSION['username']);
						  $data_rendezvous->getSaveMeetSearch($uid);
						  
						 ?>
					</form>
				</div>
				<?php
				if(isset($_SESSION['login'])) {
						require_once 'rendezvousClass.php';
						$data_rendezvous = new Rendezvous ();
						$uid = $data_rendezvous->getUserId($_SESSION['username']);
						$basicResult = $data_rendezvous->getSavedBasicSearch($uid);
				
						echo '<br/><br/><table class="table">';
				echo "<h3>Last Searches</h3>";
				for($i = 0; $i < sizeof($basicResult); $i++) {
					$encryption = new Encryption();
			 		$query = "venue=".$encryption->encode($basicResult[$i]['venueName']).
			 		"&city=".$encryption->encode($basicResult[$i]['city']);
					//$l_encrypted = $encryption->encode($query);
			 		echo '<td> <a  href="basicSearchOutput.php?' . $query . '">'. $basicResult [$i]['displayName'] . '</a></td></tr>';
				}
				echo '</table>';
				}
				?>
			</div>
			
			<div id="contents" >
				<div id="googleMap"></div>
				<div id="output">
				
				<?php 
					function sendNameCity($data_foursq, $name, $city) {
											
						$result = $data_foursq->NameCity ( $name, $city);								
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
					
					if (isset ( $_POST ['basicSearch'] )) {
						if (($_POST ['city'] != "") && ($_POST ['venue'] != "")) {
							if (isset ( $_POST ['venue'] ) && isset ( $_POST ['city'] )) {
								$venue = strip_tags ( trim ( $_POST ['venue'] ) );
								$city = strip_tags ( trim ( $_POST ['city'] ) );
								$venue = preg_replace('/\s+/', ' ', $venue);
								$city = preg_replace('/\s+/', ' ', $city);
									
								$_SESSION['venue'] = $venue;
								$_SESSION['city'] = $city;

								//if(isset($_POST['login'])) {
									$uid1 = $data_rendezvous->getUserId($_SESSION['username']);
									$displayName = "$venue, $city";
									$data_rendezvous->insertBasicSearch($uid1, $venue, $city, $displayName);
								//}
							}
						}
					}
					
					if(isset($_GET['venue']) && isset($_GET['city']) ) {
					
						$encryption = new Encryption();
							
						$venue = $encryption->decode($_GET['venue']);
						$city = $encryption->decode($_GET['city']);
							
						unset( $_GET['venue']);
						unset($_GET['city']);
							
						sendNameCity($data_foursq, $venue, $city);
					
					}
					
					if (isset($_SESSION['venue']) && isset($_SESSION['city'])) {
						
						$venue = ( trim ( $_SESSION['venue']));
						$venue = strip_tags ( $venue );
						$city = ( trim ( $_SESSION['city']));
						$city = strip_tags ( $city );
						
						$venue = preg_replace("/\s+/", " ", $venue);
						$city = preg_replace("/\s+/", " ", $city);
							
						unset( $_SESSION['venue']);
						unset($_SESSION['city']);
						
						sendNameCity($data_foursq, $venue, $city);							
					}

?>







</body>
</html>
