<?php
require_once 'connection.php';


class Encryption {
	var $skey 	= "abcdefghijklmnopqrstuvwxyz123456"; // you can change it

	public  function safe_b64encode($string) {

		$data = base64_encode($string);
		$data = str_replace(array('+','/','='),array('-','_',''),$data);
		return $data;
	}

	public function safe_b64decode($string) {
		$data = str_replace(array('-','_'),array('+','/'),$string);
		$mod4 = strlen($data) % 4;
		if ($mod4) {
			$data .= substr('====', $mod4);
		}
		return base64_decode($data);
	}

	public  function encode($value){

		if(!$value){return false;}
		$text = $value;
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->skey, $text, MCRYPT_MODE_ECB, $iv);
		return trim($this->safe_b64encode($crypttext));
	}

	public function decode($value){

		if(!$value){return false;}
		$crypttext = $this->safe_b64decode($value);
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);
		return trim($decrypttext);
	}
}


class Rendezvous {
	
	private $addData;
	private $insertVenueData;
	private $checkBeforeInsertVenueData;
	private $selectVenueDataFromNameCityRatingRadius;
	private $addCheckUsernameStatement;
	private $addGetPasswordStatement;
	private $addGetQuestion1Statement;
	private $addGetQuestion2Statement;
	private $addGetAnswer1Statement;
	private $addGetAnswer2Statement;
	private $addUpdatePasswordStatement;
	private $addinsertMeetSearchStatement;
	private $addinsertBasicSearchStatement;
	private $addGetUserIdStatement;
	private $addGetSaveMeetSearchStatement;
	private $addGetBasicSavedSearchStatement;
	private $selectVenueDataFromLatLngRatingRadius;
	private $selectVenueDataFromNameLatLongRatingRadius;

	# Meet halway returning Midpoint latitude and longitude
	# Ambika Maheshwari
	public function meetHalwayCalculation($latitude1,$longitude1,$latitude2,$longitude2)
	{
		$latitude1= deg2rad($latitude1);
		$longitude1= deg2rad($longitude1);
		$latitude2= deg2rad($latitude2);
		$longitude2= deg2rad($longitude2);
	
		$dlng = $longitude2 - $longitude1;
		$Bx = cos($latitude2) * cos($dlng);
		$By = cos($latitude2) * sin($dlng);
		$latitude3 = atan2( sin($latitude1)+sin($latitude2),
				sqrt((cos($latitude1)+$Bx)*(cos($latitude1)+$Bx) + $By*$By ));
		$longitude3 = $longitude1 + atan2($By, (cos($latitude1) + $Bx));
		$pi = pi();
		$latitude3 = round(($latitude3*180/$pi),4);
		$longitude3 = round(($longitude3*180/$pi),4);
	
		return  $latitude3.','.$longitude3 ;
	
	}
	
	//Haversine formual
	public function haversineFormula($latitude1,$longitude1,$latitude2,$longitude2)
	{
		//Latitude and longitude 1 will be user's
		//latitude and longitude 2 will be from database
	
		$latitude1= deg2rad($latitude1);
		$longitude1= deg2rad($longitude1);
		$latitude2= deg2rad($latitude2);
		$longitude2= deg2rad($longitude2);
		$radiusOfEarth = 6371000;// Earth's radius in meters.
	
		$diffLatitude = $latitude2 - $latitude1;
		$diffLongitude = $longitude2 - $longitude1;
	
		$a = sin($diffLatitude / 2) * sin($diffLatitude / 2) +
		cos($latitude1) * cos($latitude2) *
		sin($diffLongitude / 2) * sin($diffLongitude / 2);
		$c = 2 * asin(sqrt($a));
		$distance = $radiusOfEarth * $c;
		return $distance;
	}
	
	public function storeUser($firstName, $lastName, $address, $city, $state, $zip, $tel, $email, $password, $quest1, $quest2, $answer1, $answer2)
	{
	
		$this->addData->bind_param("sssssssssssss", $firstName, $lastName, $address, $city, $state, $zip, $tel, $email, $password, $quest1, $quest2, $answer1, $answer2);
		$this->addData->execute();
	
	}
	//Function to store meet search
	//Roja
	public function insertMeetSearch($userid, $latitude, $longitude, $rating, $radius, $displayName,$lat1, $lng1,$lat2,$lng2) {
	
		$this->addinsertMeetSearchStatement->bind_param("sddddsdddd", $userid, $latitude, $longitude, $rating, $radius, $displayName,$lat1, $lng1,$lat2,$lng2);
		$this->addinsertMeetSearchStatement->execute();
		$this->addinsertMeetSearchStatement->close();
		//self::getSaveMeetSearch($userid);
	
	}	
	
// Function to check username in database
	//Shruthi
	public function insertBasicSearch($userid, $venuename, $city, $displayname) {
		$this->addinsertBasicSearchStatement->bind_param("ssss", $userid, $venuename, $city, $displayname);
		$this->addinsertBasicSearchStatement->execute();
		$this->addinsertBasicSearchStatement->close();
	}
	
	public function checkUsername($username) {
		$getEmail = null;

		$this->addCheckUsernameStatement->bind_param('s',$username);
		$this->addCheckUsernameStatement->execute();
		$this->addCheckUsernameStatement->bind_result($getEmail);
		$this->addCheckUsernameStatement->fetch();
        $this->addCheckUsernameStatement->close();
        return $getEmail;

	}
	
	//Function to fetch password
	public function getPassword($username) {
		$getPwd = null;
        $this->addGetPasswordStatement->bind_param('s',$username);
		$this->addGetPasswordStatement->execute();
		$this->addGetPasswordStatement->bind_result($getPwd);
		$this->addGetPasswordStatement->fetch();
        $this->addGetPasswordStatement->close();
		return $getPwd;
	}
	
	//Function to get security question 1 from User table
	public function getQuestion1($username) {
		$getQuest1 = null;
	
		$this->addGetQuestion1Statement->bind_param('s',$username);
		$this->addGetQuestion1Statement->execute();
		$this->addGetQuestion1Statement->bind_result($getQuest1);
		$this->addGetQuestion1Statement->fetch();
	
	
	
		$this->addGetQuestion1Statement->close();
		return $getQuest1;
	}
	
	//Function to get security question 2 from User table
	public function getQuestion2($username) {
		$getQuest2 = null;
		$this->addGetQuestion2Statement->bind_param('s',$username);
		$this->addGetQuestion2Statement->execute();
		$this->addGetQuestion2Statement->bind_result($getQuest2);
		$this->addGetQuestion2Statement->fetch();
		$this->addGetQuestion2Statement->close();
		return $getQuest2;
	}
	
	//Function to get security answer 1 from User table
	public function getAnswer1($username) {
		$getAns1 = null;

		$this->addGetAnswer1Statement->bind_param('s',$username);
		$this->addGetAnswer1Statement->execute();
		$this->addGetAnswer1Statement->bind_result($getAns1);
		$this->addGetAnswer1Statement->fetch();
		$this->addGetAnswer1Statement->close();
        return $getAns1;
	}
	
	//Function to get security answer 2 from User table
	public function getAnswer2($username) {
		$getAns2 = null;
		$this->addGetAnswer2Statement->bind_param('s',$username);
		$this->addGetAnswer2Statement->execute();
		$this->addGetAnswer2Statement->bind_result($getAns2);
		$this->addGetAnswer2Statement->fetch();
		$this->addGetAnswer2Statement->close();
        return $getAns2;

	}
	
	//Function to update password
	public function updatePassword($username, $password) {
			$this->addUpdatePasswordStatement->bind_param("ss", $password, $username);
			$this->addUpdatePasswordStatement->execute();
	}
    
public function getRecordUser($email)
	{
		return $this->dbConnection->send_sql("SELECT * FROM user WHERE email = '$email'")->fetch_all(MYSQLI_ASSOC);
	}
public function getUserId($username) {
		$getId = null;
		$this->addGetUserIdStatement->bind_param('s', $username);
		$this->addGetUserIdStatement->execute();
		$this->addGetUserIdStatement->bind_result($getId);
		$this->addGetUserIdStatement->fetch();
		$this->addGetUserIdStatement->close();
		return $getId;
}

//function to display saved meet searches
//Roja
public function getSaveMeetSearch($uid) {
	$midlat= null;
	$midlong= null;
	$rating= null;
	$radius= null;
	$displayName= null;
	$lat1= null;
	$lng1 = null;
	$lat2 = null;
	$lng2 = null;
	$this->addGetSaveMeetSearchStatement->bind_param('s', $uid);
	$this->addGetSaveMeetSearchStatement->execute();
	$this->addGetSaveMeetSearchStatement->bind_result($midlat, $midlong, $rating, $radius, $displayName,$lat1, $lng1,$lat2,$lng2);
	//$this->addGetSaveMeetSearchStatement->fetch();
	
	
	$result = array();
	while ( $this->addGetSaveMeetSearchStatement->fetch () ) {
		$newEntry = array (
				"latitude" => $midlat,
				"longitude" => $midlong,
				"rating" => $rating,
				"radius" => $radius,
				"displayName" => $displayName,
				"lat1" => $lat1,
				"lng1" => $lng1,
				"lat2" => $lat2,
				"lng2" => $lng2
		);
		array_push($result, $newEntry);
	}	
	$this->addGetSaveMeetSearchStatement->close();
	return $result;
}

public function getSavedBasicSearch($uid) {
	$venueName = null;
	$city = null;
	$displayName= null;

	$this->addGetBasicSavedSearchStatement->bind_param("s", $uid);
	$this->addGetBasicSavedSearchStatement->execute();
	$this->addGetBasicSavedSearchStatement->bind_result($venueName, $city, $displayName);

	$result = array();
	while ( $this->addGetBasicSavedSearchStatement->fetch () ) {
		$newEntry = array (
				"venueName" => $venueName,
				"city" => $city,
				"displayName" => $displayName
		);
		array_push($result, $newEntry);
	}

	$this->addGetBasicSavedSearchStatement->close();
	return $result;
}
public function insertVenue($result) {
		for($i=0;$i<sizeOf($result);$i++) {
			$name = null;
			$this->checkBeforeInsertVenueData->bind_param("s", $result[$i]['id']);
			$this->checkBeforeInsertVenueData->bind_result($name);			
			if (!$this->checkBeforeInsertVenueData->execute() || !$this->checkBeforeInsertVenueData->fetch()) {				
				if($name == null) { 
					$this->insertVenueData->bind_param ("ssddsdssssss",$result[$i]['id'],$result[$i]['name'],$result[$i]['lat'],$result[$i]['lng'],$result[$i]['address'],$result[$i]['rating'],$result[$i]['zipcode'],$result[$i]['city'],$result[$i]['state'],$result[$i]['phone'],$str = "Foursquare",$result[$i]['url']);
					$this->insertVenueData->execute ();
				} else {
					echo "Already there";
				}
			}
			
		}
	}	
	
	public function selectVenueFromNameCityRatingRadius($lat, $lng, $name, $city, $rating, $radius) {
		
		$param = "%{$name}%";
		$this->selectVenueDataFromNameCityRatingRadius->bind_param("dddddssdd", $lat, $lng, $lat, $lng, $lat,$param, $city, $radius, $rating);
		$venueID = null;
		$venueForeignId = null;
		$venueName = null;
		$venueLatitude = null;
		$venueLongitude = null;
		$venueAddress = null;
		$rating1 = null;
		$zipcode = null;
		$city1 = null;
		$state = null;
		$phone = null;
		$foreignSource = null;
		$menuURL = null;		
		$distance = null;
		$this->selectVenueDataFromNameCityRatingRadius->execute();
		$this->selectVenueDataFromNameCityRatingRadius->bind_result($venueID, $venueForeignId, $venueName, $venueLatitude, $venueLongitude, $venueAddress, $rating1, $zipcode, $city1, $state, $phone, $foreignSource, $menuURL, $distance);
		$result = Array();
		while($this->selectVenueDataFromNameCityRatingRadius->fetch()) {
			$venueInfo = $this->makePostAssociativeArray($venueID, $venueForeignId, $venueName, $venueLatitude, $venueLongitude, $venueAddress, $rating1, $zipcode, $city1, $state, $phone, $foreignSource, $menuURL);
			array_push($result, $venueInfo);
		} 
		return $result;
    }
    
    
 
    
    public function selectVenueDataFromLatLongRatingRadius($lat, $lng, $rating, $radius) {
    
    	$this->selectVenueDataFromLatLngRatingRadius->bind_param("ddddddd", $lat, $lng, $lat, $lng, $lat, $radius, $rating );
    	$venueID = null;
    	$venueForeignId = null;
    	$venueName = null;
    	$venueLatitude = null;
    	$venueLongitude = null;
    	$venueAddress = null;
    	$rating1 = null;
    	$zipcode = null;
    	$city1 = null;
    	$state = null;
    	$phone = null;
    	$foreignSource = null;
    	$menuURL = null;
    	$distance = null;
    	$this->selectVenueDataFromLatLngRatingRadius->execute();
    	$this->selectVenueDataFromLatLngRatingRadius->bind_result($venueID, $venueForeignId, $venueName, $venueLatitude, $venueLongitude, $venueAddress, $rating1, $zipcode, $city1, $state, $phone, $foreignSource, $menuURL, $distance);
    	$result = Array();
    	while($this->selectVenueDataFromLatLngRatingRadius->fetch()) {
    		//if($this->haversineFormula($lat, $lng, $venueLatitude, $venueLongitude) < $rating1) {
    		$venueInfo = $this->makePostAssociativeArray($venueID, $venueForeignId, $venueName, $venueLatitude, $venueLongitude, $venueAddress, $rating1, $zipcode, $city1, $state, $phone, $foreignSource, $menuURL);
    		array_push($result, $venueInfo);
    		//}
    	}
    	return $result;
    } 
    
    
    public function selectVenueFromNameLatLongRatingRadius($lat, $lng, $name, $rating, $radius) {
    
    	$param = "%{$name}%";
    	$this->selectVenueDataFromNameLatLongRatingRadius->bind_param("dddddsdd", $lat, $lng, $lat, $lng, $lat, $param, $radius, $rating );
    	$venueID = null;
    	$venueForeignId = null;
    	$venueName = null;
    	$venueLatitude = null;
    	$venueLongitude = null;
    	$venueAddress = null;
    	$rating1 = null;
    	$zipcode = null;
    	$city1 = null;
    	$state = null;
    	$phone = null;
    	$foreignSource = null;
    	$menuURL = null;
    	$distance = null;
    	$this->selectVenueDataFromNameLatLongRatingRadius->execute();
    	$this->selectVenueDataFromNameLatLongRatingRadius->bind_result($venueID, $venueForeignId, $venueName, $venueLatitude, $venueLongitude, $venueAddress, $rating1, $zipcode, $city1, $state, $phone, $foreignSource, $menuURL, $distance);
    	$result = Array();
    	while($this->selectVenueDataFromNameLatLongRatingRadius->fetch()) {
    		//if($this->haversineFormula($lat, $lng, $venueLatitude, $venueLongitude) < $rating1) {
    		$venueInfo = $this->makePostAssociativeArray($venueID, $venueForeignId, $venueName, $venueLatitude, $venueLongitude, $venueAddress, $rating1, $zipcode, $city1, $state, $phone, $foreignSource, $menuURL);
    		array_push($result, $venueInfo);
    		//}
    	}
    	return $result;
    }
    
	
        public function makePostAssociativeArray ($venueID, $venueForeignId, $venueName, $venueLatitude, $venueLongitude,
        		 $venueAddress, $rating, $zipcode, $city, $state, $phone, $foreignSource, $menuURL) {
        	$postAssociativeArray = array (
        			"id" => $venueID,
        			"venueForeignId" => $venueForeignId,
        			"name" => $venueName,
        			"address" => $venueAddress,
        			"lat" => $venueLatitude,
        			"lng" => $venueLongitude,
        			"city" => $city,
        			"state" => $state,
        			"phone" => $phone,
        			"rating" => $rating,
        			"url"=> $menuURL,
        			"foreignSource" => $foreignSource,
        			"zipcode"=>$zipcode
        	);
        	
       

            return $postAssociativeArray;
        }
	
	public function __construct() {
		$this->dbConnection = new DatabaseConnection ();																																																											
		//$this->selectVenueDataFromLatLngRatingRadius = $this->dbConnection->prepare_statement("SELECT `venueID`,`venueForeignId`, `venueName`, `venueLatitude`, `venueLongitude`, `venueAddress`, `rating`, `zipcode`, `city`, `state`, `phone`, `foreignSource`, `menuURL` FROM  `venue` WHERE `venueLatitude`>=? AND `venueLongitude`>=? AND `rating` >= ?");
		
		$this->selectVenueDataFromLatLngRatingRadius = $this->dbConnection->prepare_statement("SELECT `venueID`,`venueForeignId`, `venueName`, `venueLatitude`, 
				`venueLongitude`, `venueAddress`, `rating`, `zipcode`, `city`, `state`, `phone`, `foreignSource`, `menuURL`,   ( 3959 *
                acos(
                        COS(RADIANS(?)) *
                        COS(RADIANS(?)) * 
                        COS(RADIANS(venueLatitude)) * 
                        COS(RADIANS(venueLongitude)) 
                        +
                        COS(RADIANS(?)) * 
                        SIN(RADIANS(?)) * 
                        COS(RADIANS(venueLatitude)) * 
                        SIN(RADIANS(venueLongitude)) 
                        + 
                        SIN(RADIANS(?)) * 
                        SIN(RADIANS(venueLatitude))
                    )
            ) AS distance 
				 FROM  `venue` HAVING `distance` <= ? AND `rating` >= ?");
		
		
		
		$this->selectVenueDataFromNameLatLongRatingRadius = $this->dbConnection->prepare_statement("SELECT `venueID`,`venueForeignId`, `venueName`, `venueLatitude`,
				`venueLongitude`, `venueAddress`, `rating`, `zipcode`, `city`, `state`, `phone`, `foreignSource`, `menuURL`,   ( 3959 *
                acos(
                        COS(RADIANS(?)) *
                        COS(RADIANS(?)) *
                        COS(RADIANS(venueLatitude)) *
                        COS(RADIANS(venueLongitude))
                        +
                        COS(RADIANS(?)) *
                        SIN(RADIANS(?)) *
                        COS(RADIANS(venueLatitude)) *
                        SIN(RADIANS(venueLongitude))
                        +
                        SIN(RADIANS(?)) *
                        SIN(RADIANS(venueLatitude))
                    )
            ) AS distance
				 FROM  `venue` WHERE `venueName` LIKE ? HAVING `distance` <= ? AND `rating` >= ? ");
		
		$this->selectVenueDataFromNameCityRatingRadius = $this->dbConnection->prepare_statement("SELECT `venueID`,`venueForeignId`, `venueName`, `venueLatitude`,
				 `venueLongitude`, `venueAddress`, `rating`, `zipcode`, `city`, `state`, `phone`, `foreignSource`, `menuURL`,   ( 3959 *
                acos(
                        COS(RADIANS(?)) *
                        COS(RADIANS(?)) *
                        COS(RADIANS(venueLatitude)) *
                        COS(RADIANS(venueLongitude))
                        +
                        COS(RADIANS(?)) *
                        SIN(RADIANS(?)) *
                        COS(RADIANS(venueLatitude)) *
                        SIN(RADIANS(venueLongitude))
                        +
                        SIN(RADIANS(?)) *
                        SIN(RADIANS(venueLatitude))
                    )
            ) AS distance
				 FROM  `venue` WHERE `venueName` LIKE ? AND `city` = ? HAVING `distance` <= ? AND `rating` >= ? ");
		
		$this->checkBeforeInsertVenueData = $this->dbConnection->prepare_statement(" SELECT `venueName` from `venue` WHERE `venueForeignId`=?" );
		$this->insertVenueData = $this->dbConnection->prepare_statement("INSERT INTO `venue`(`venueID`,`venueForeignId`, `venueName`, `venueLatitude`, `venueLongitude`, `venueAddress`, `rating`, `zipcode`, `city`, `state`, `phone`, `foreignSource`, `menuURL`) VALUES (REPLACE(uuid(),'-',''),?,?,?,?,?,?,?,?,?,?,?,?);");
		$this->addCheckUsernameStatement = $this->dbConnection->prepare_statement ("SELECT `email` FROM `user` WHERE `email` = ?");
		$this->addGetPasswordStatement = $this->dbConnection->prepare_statement ("SELECT `password` FROM `user` WHERE `email` = ?");
		$this->addGetQuestion1Statement = $this->dbConnection->prepare_statement ("SELECT `securityQuestion1` FROM `user` WHERE `email` = ?");
		$this->addGetQuestion2Statement = $this->dbConnection->prepare_statement ("SELECT `securityQuestion2` FROM `user` WHERE `email` = ?");
		$this->addGetAnswer1Statement = $this->dbConnection->prepare_statement ("SELECT `answerQuestion1` FROM `user` WHERE `email` = ?");
		$this->addGetAnswer2Statement = $this->dbConnection->prepare_statement ("SELECT `answerQuestion2` FROM `user` WHERE `email` = ?");
		$this->addUpdatePasswordStatement = $this->dbConnection->prepare_statement ("UPDATE `user` SET `password` = ? WHERE `email` = ?");
		$this->addData = $this->dbConnection->prepare_statement("INSERT INTO `user` (`userId`, `firstName`, `lastName`, `address`, `city`, `state`, `zipcode`, `phone`, `email`, `password`, `securityQuestion1`, `securityQuestion2`, `answerQuestion1`, `answerQuestion2`) VALUES (REPLACE(uuid(),'-',''), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
	    $this->addGetUserIdStatement = $this->dbConnection->prepare_statement ("SELECT `userId` FROM `user` WHERE `email` = ?");
		$this->addGetSaveMeetSearchStatement = $this->dbConnection->prepare_statement ("SELECT `latitude`, `longitude`, `rating`, `radius`, `displayName`, `lat1`, `lng1`,`lat2`, `lng2` FROM `meetupsearchresult` WHERE `userId` = ? ORDER BY `timestamp` DESC LIMIT 3");
		$this->addinsertMeetSearchStatement = $this->dbConnection->prepare_statement ("INSERT INTO `meetupsearchresult` (`meetupSearchId`, `userId`, `latitude`, `longitude`, `rating`, `radius`, `displayName`,  `lat1`, `lng1`,`lat2`, `lng2`) VALUES (REPLACE(uuid(),'-',''), ?, ?, ?, ?, ?, ?,?,?,?,?);");
		$this->addinsertBasicSearchStatement = $this->dbConnection->prepare_statement ("INSERT INTO `savesearchresult` (`singleSearchId`, `userId`, `venueName`, `city`, `displayName`) VALUES (REPLACE(uuid(),'-',''), ?, ?, ?, ?);");
		$this->addGetBasicSavedSearchStatement = $this->dbConnection->prepare_statement("SELECT `venueName`, `city`, `displayName` FROM `savesearchresult` WHERE `userId` = ? ORDER BY `timestamp` DESC LIMIT 3");
	}
	
	function __destruct () {
       
        if ($this->insertVenueData) {
        	$this->insertVenueData->close();
        }
        if ($this->selectVenueDataFromLatLngRatingRadius) {
        	$this->selectVenueDataFromLatLngRatingRadius->close();
        }
        if ($this->selectVenueDataFromNameCityRatingRadius) {
        	$this->selectVenueDataFromNameCityRatingRadius->close();
        }
        if ($this->selectVenueDataFromNameLatLongRatingRadius) {
        	$this->selectVenueDataFromNameLatLongRatingRadius->close();
        }
        if ($this->addCheckUsernameStatement) {
        	$this->addCheckUsernameStatement->close();
        }
        if ($this->addGetPasswordStatement) {
        	$this->addGetPasswordStatement->close();
        }
        if ($this->addGetQuestion1Statement) {
        	$this->addGetQuestion1Statement->close();
        }
        if ($this->addGetQuestion2Statement) {
        	$this->addGetQuestion2Statement->close();
        }
        if ($this->addGetAnswer1Statement) {
        	$this->addGetAnswer1Statement->close();
        }
        if ($this->addGetAnswer2Statement) {
        	$this->addGetAnswer2Statement->close();
        }
        if ($this->addUpdatePasswordStatement) {
        	$this->addUpdatePasswordStatement->close();
        }
        /*if ($this->addinsertMeetSearchStatement) {
         $this->addinsertMeetSearchStatement->close();
         }
         if ($this->addGetUserIdStatement) {
         $this->addGetUserIdStatement->close();
         }
         if ($this->addGetSaveMeetSearchStatement) {
         $this->addGetSaveMeetSearchStatement->close();
         }*/
    }
}
?>