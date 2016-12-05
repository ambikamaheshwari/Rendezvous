<?php
ob_start();
session_start();
require_once 'rendezvousClass.php';
$data_rendezvous = new Rendezvous();
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Rendezvous - Basic Search</title>
<link href='http://fonts.googleapis.com/css?family=Arizonia'
	rel='stylesheet' type='text/css'>
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script
	src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
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
	height: 500px;
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

.test {
	display: block;
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
	
	<div class="panel panel-info">

		<div class="panel-body">

			<div class="form-group" id="content">

				<label>
					<ul class="nav nav-tabs" id="myTab">
						<li class="active"><a data-toggle="tab" href="#sectionBasicSearch"
							align="center" style="width: 200px;"><b>Basic Search</b></a></li>
						<!-- <li><a data-toggle="tab" href="#sectionSignup">Signup</a></li> -->
					
					<?php
					if (! isset ( $_SESSION ['login'] )) {
						?>
					  <li><a href="#" role="button" class="btn popovers"
							data-toggle="popover" title="" data-content="<a 
						href='homepage.php' class='test' title='login'
							style='width: 300px;'>Click here to Login</a>"
							data-original-title="<font color='Red'>Login needed to access MeetHalfway</font>"
							"align="center" style="width: 200px;"><b>Meet halfway</b></a></li>
					  <?php
					} else {
						?>
					  <li><a href="#sectionMeetup" data-toggle="tab"
							style="width: 200px;" align="center"><b>Meetup halfway</b></a></li>
					  <?php
					}
					?>
					
				</ul>
				</label>
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
				<div class="tab-content">
					<div id="sectionBasicSearch" class="tab-pane fade in active">
						<!-- <label><h3>Basic Search</h3></label> -->
						<div class="form-group">
							<form method="POST" action="" name="basicSearchForm"
								id="basicSearchForm" class="form-horizontal" onsubmit="return vali()">

								<label>Venue<font color="red">*</font> <br /> <input type="search" name="venue" id="venue"
									 class="form-control" />
								</label> <br /> <br /> <label>City<font color="red">*</font> <br /> <input type="search"
									name="city" id="city" class="form-control" />
								</label> <br /> <br /> <input type="submit" name="basicSearch"
									id="basicSearch" class="btn btn-primary"
									value="Search" /> &nbsp;&nbsp;&nbsp;&nbsp;
								
									 <font size="3px" ><a href="advancedsearch.php">Advanced Search</a></font>
								
							</form>
						</div> 
						
						<?php
						if (isset ( $_POST ['basicSearch'] )) {
							if (($_POST ['city'] != "") && ($_POST ['venue'] != "")) {
								if (isset ( $_POST ['venue'] ) && isset ( $_POST ['city'] )) {
									$venue = strip_tags ( trim ( $_POST ['venue'] ) );
									$city = strip_tags ( trim ( $_POST ['city'] ) );
										
									$_SESSION['venue'] = $venue;
									$_SESSION['city'] = $city;
									if(isset($_SESSION['login'])) {
										$uid = $data_rendezvous->getUserId($_SESSION['username']);
										$displayName = "$venue, $city";
										$data_rendezvous->insertBasicSearch($uid, $venue, $city, $displayName);
									}
									header('Location: basicSearchOutput.php');							
								}
							}
						}
						
						//$uid = $data_rendezvous->getUserId($_SESSION['username']);
						//$displayName = "$venue, $city";
						//$data_rendezvous->insertBasicSearch($uid, $venue, $city, $displayname);
						
						?>
					</div>
					<script type="text/javascript">
				function meetVali(){
	            var address1 = document.meethalfwayForm.address1;
	            var address2 = document.meethalfwayForm.address2;
				errmsg="";
	            if((address1.value == "") )
	            {
	    	    address1.style.background = 'Yellow';
	            errmsg += "Please provide zip/address:1.\n";
	        
	            }
                 if((address2.value == "") )
	            {
	    	    address2.style.background = 'Yellow';
	           errmsg += "Please provide zip/address:2.\n";
	        
	            }
                if(errmsg.length > 0){
			    alert("You must provide the following fields:\n" +errmsg);
	            return false;
	    	
	            }
	  
	            return true;					
				
				}
			    </script>
					<div id="sectionMeetup" class="tab-pane fade">
						<!-- <label><h3>Meetup Halfway</h3></label> -->
						<div class="form-group">
							<form method="POST" action="" name="meethalfwayForm"
								id="meethalfwayForm" onsubmit="return meetVali()">
								<br> <label>Zip/Address 1<font color="red">*</font> <br /> <input type="search"
									name="address1" id="address1" 
									class="form-control" />
								</label> <br>
								<br> <label>Zip/Address 2<font color="red">*</font> <br /> <input type="search"
									name="address2" id="address2" 
									class="form-control" />
								</label> <br>
								<br> <label> Radius </label> <select name="radius">
								
									<option value="1">1 mile</option>
									<option value="2">2 miles</option>
									<option value="5">5 miles</option>
									<option value="10">10 miles</option>
									<option value="20">20 miles</option>
								</select> <br>
								<br> <label> Ratings </label> <select name="rating">
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
	</div>
	<script type="text/javascript">
	$("[data-toggle=popover]")
	.popover({html:true});
</script>
<?php 
/* 
 * Meet Halfway on button submit
 * Author: Ambika Maheshwari
 */
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
		
		
		$resp_latlnggoogle1 = file_get_contents ( "https://maps.googleapis.com/maps/api/geocode/json?address=$newAddress1&key=123456qwerty" );
		$objlatlng1 = json_decode ( $resp_latlnggoogle1, true );
		if ($objlatlng1 ['status'] == "OK") {
			$lat1 = $objlatlng1 ['results'] ['0'] ['geometry'] ['location'] ['lat'];
			$lng1 = $objlatlng1 ['results'] ['0'] ['geometry'] ['location'] ['lng'];
		}
		else{
			echo "address 1 incorrect,please try again !!";
		}
		$resp_latlnggoogle2 = file_get_contents ( "https://maps.googleapis.com/maps/api/geocode/json?address=$newAddress2&key=123456qwerty" );
		$objlatlng2 = json_decode ( $resp_latlnggoogle2, true );
		if ($objlatlng2 ['status'] == "OK") {
			$lat2 = $objlatlng2 ['results'] ['0'] ['geometry'] ['location'] ['lat'];
			$lng2 = $objlatlng2 ['results'] ['0'] ['geometry'] ['location'] ['lng'];
		}
		else{
			echo "address 2 is incorrect, please try again !!";
		}
	
		require_once 'rendezvousClass.php';
		$data_rendezvous = new Rendezvous ();
		
		$result_latlong = $data_rendezvous->meetHalwayCalculation($lat1,$lng1,$lat2,$lng2);
		
		$latlong = explode(",",$result_latlong);
		$midlat = $latlong[0];
		$midlong = $latlong[1];
	
		$encryption = new Encryption();
		$query = "lat=".$encryption->encode($midlat).
		"&lng=".$encryption->encode($midlong).
		"&rating=". $encryption->encode($rating) .
		"&radius=".$encryption->encode($radius).
		"&lat1=".$encryption->encode($lat1).
		"&lng1=".$encryption->encode($lng1).
		"&lat2=".$encryption->encode($lat2).
		"&lng2=".$encryption->encode($lng2);
		
		header('Location: meethalfwayoutput.php?'.$query);
		
		$uid = $data_rendezvous->getUserId($_SESSION['username']);
		$displayName = "$address1,$address2";		
		$data_rendezvous->insertMeetSearch($uid, $midlat, $midlong, $rating, $radius, $displayName, $lat1, $lng1, $lat2, $lng2);
		
		
}
}?>
</body>
</html>
