<?php

require_once 'connection.php';
require_once 'rendezvousClass.php';
$data = new Rendezvous();
error_reporting ( E_ERROR | E_PARSE ); 
class Foursquare {
	
	//1 Advance search -- search by name + city + radius + rating
	public function NameCityRadiusRating($name1,$city1,$radius1,$rating1) {
	
		$radius_new = $radius1 * 1609.34;
		require_once 'rendezvousClass.php';
		$data = new Rendezvous();
	
		$newName = str_replace(" ", "%2B", $name1);
		$newCity = str_replace(" ", "%2B", $city1);
		$result = array();
	
		$url_google = "https://maps.googleapis.com/maps/api/geocode/json?address=$newCity&key=AIzaSyCqt0V2s8VlZHYEjC2k1k_rWhcSDVFxwfg";
		$resp_latlnggoogle = file_get_contents ( $url_google );
		$objlatlng = json_decode ( $resp_latlnggoogle, true );
		if ($objlatlng ['status'] == "OK") {
			$lat = $objlatlng ['results'] ['0'] ['geometry'] ['location'] ['lat'];
			$lng = $objlatlng ['results'] ['0'] ['geometry'] ['location'] ['lng'];
	
			$url = "https://api.foursquare.com/v2/venues/explore?query=$newName&radius=$radius_new&ll=$lat,$lng&oauth_token=34BKKF5OYKVTDBGZEWADDVHZB1NJQHZ2AEIOSOD0LRQ3T3KL&v=20151125";
			$resp_oauthtoken = file_get_contents ($url);
			$obj = json_decode ( $resp_oauthtoken, true );
			if (floatval ( $obj ['meta'] ['code'] ) == 200) {
				for($i = 0; $i < sizeOf ( $obj ['response'] ['groups'] ['0'] ['items']); $i ++) {
					if (floatval ( $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['rating'] ) >= floatval ( $rating1 ) && (stripos($obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['name'], $name1) > -1)) {
						$id = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['id'];
						$venueName = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['name'];
						$venueAddress = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['address'];
						$venueLatitude = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['lat'];
						$venueLongitude = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['lng'];
						$city = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['city'];
						$state = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['state'];
						$phone = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['contact']['formattedPhone'];
						$rating =  $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['rating'];
						$url =  $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['url'];
						$zipcode = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['postalCode'];
						$resultnamecityrr = array (
								"id" => $id,
								"name" => $venueName,
								"address" => $venueAddress,
								"lat" => $venueLatitude,
								"lng" => $venueLongitude,
								"city" => $city,
								"state" => $state,
								"phone" => $phone,
								"rating" => $rating,
								"url"=>$url,
								"zipcode"=>$zipcode
						);
						array_push($result,$resultnamecityrr);
					}
				}
				if (sizeOf ( $result ) >= 1) {
					$insertReturn = $data->insertVenue($result);
				} else {
					echo $obj ['response'] ['warning'] ['text'];
				}
				$returnData = $data->selectVenueFromNameCityRatingRadius($lat, $lng,$name1,$city1,$rating1,$radius1);
				return  $returnData;
			} else
				return "Please check the credential again !!";
		}
		else
			return "Please check the credential again !!";
	
	}	
	
	//2 search by city + radius + rating
	public function CityRadiusRating($city1,$radius1,$rating1) {
		$name1 = "";
		$result = self::NameCityRadiusRating($name1,$city1,$radius1,$rating1);
		return $result;
	}
	
	//3 search by name and city
	public function NameCity($name1,$city1) {
		$rating1 = 0;
		$radius1 = 10;
		$result = self::NameCityRadiusRating($name1,$city1,$radius1,$rating1);
		return $result;
	}
	
	
	
	// Search by Latitude and Longitude + radius + rating
	public function latLongRadiusRating($lat1, $lng1, $radius1, $rating1) {
		$radius_new = $radius1 * 1609.34;
		require_once 'rendezvousClass.php';
		$data = new Rendezvous();
		
		$resp_oauthtoken = file_get_contents ( "https://api.foursquare.com/v2/venues/explore?ll=$lat1,$lng1&radius=$radius_new&oauth_token=34BKKF5OYKVTDBGZEWADDVHZB1NJQHZ2AEIOSOD0LRQ3T3KL&v=20151125");
		$obj = json_decode ( $resp_oauthtoken, true );
		
		$result = array ();
		
		if (floatval ( $obj ['meta'] ['code'] ) == 200) {
		for($i = 0; $i < sizeOf ( $obj ['response'] ['groups'] ['0'] ['items']); $i ++) {
				if (floatval ( $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['rating'] ) >= floatval ( $rating1 )) {
					$id = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['id'];
					$venueName = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['name'];
					$venueAddress = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['address'];
					$venueLatitude = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['lat'];
					$venueLongitude = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['lng'];
					$city = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['city'];
					$state = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['state'];
					$phone = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['contact']['formattedPhone'];
					$rating =  $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['rating'];
					$url =  $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['url'];
					$zipcode = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['postalCode'];
					$resultlatlongrr = array (
							"id" => $id,
							"name" => $venueName,
							"address" => $venueAddress,
							"lat" => $venueLatitude,
							"lng" => $venueLongitude,
							"city" => $city,
							"state" => $state,
							"phone" => $phone,
							"rating" => $rating,
							"url"=>$url,
							"zipcode"=>$zipcode
					);
					array_push($result,$resultlatlongrr);
				}
				
			}
			if (sizeOf ( $result ) >= 1) {
				$insertReturn = $data->insertVenue($result);
			} else {
				return $obj ['response'] ['warning'] ['text'];
			}
			
			$returnData = $data->selectVenueDataFromLatLongRatingRadius($lat1, $lng1, $rating1, $radius1);
			
			return  $returnData;
		} else
			
			return "Please check the credential again !!";
		
	}
	

	// Search by Zipcode + radius + rating
	public function ZipRadiusRating($zipcode1,$radius1,$rating1) {
		$result = array();
		$resp_latlnggoogle = file_get_contents ( "https://maps.googleapis.com/maps/api/geocode/json?address=$zipcode1&key=AIzaSyCqt0V2s8VlZHYEjC2k1k_rWhcSDVFxwfg");
		$objlatlng = json_decode ( $resp_latlnggoogle, true );
		if ($objlatlng ['status'] == "OK") {
			$gglat = $objlatlng ['results'] ['0'] ['geometry'] ['location'] ['lat'];
			$gglng = $objlatlng ['results'] ['0'] ['geometry'] ['location'] ['lng'];
			$result = self::latLongRadiusRating($gglat,$gglng,$radius1,$rating1);
		return $result;
				
		} else
			return "Please check the zipcode again !!";
	}
	
	
	
	// Search by lat +lng and name + radius + rating
	public function LatLongNameRadiusRating($lat1,$long1,$name1,$radius1,$rating1) {
		$radius_new = $radius1 * 1609.34;
		require_once 'rendezvousClass.php';
		$data = new Rendezvous();
		$newName = str_replace(" ", "%2B", $name1);
		
		$url_foursq = "https://api.foursquare.com/v2/venues/explore?ll=$lat1,$long1&query=$newName&radius=$radius_new&oauth_token=34BKKF5OYKVTDBGZEWADDVHZB1NJQHZ2AEIOSOD0LRQ3T3KL&v=20151125";
		$resp_oauthtoken = file_get_contents ($url_foursq);
		
		$obj = json_decode ( $resp_oauthtoken, true );
		$result = array ();
		if (floatval ( $obj ['meta'] ['code'] ) == 200) {
		for($i = 0; $i < sizeOf ( $obj ['response'] ['groups'] ['0'] ['items']); $i ++) {
				if (floatval ( $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['rating'] ) >= floatval ( $rating1 ) && (stripos($obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['name'], $name1) > -1)) {
					$id = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['id'];
					$venueName = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['name'];
					$venueAddress = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['address'];
					$venueLatitude = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['lat'];
					$venueLongitude = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['lng'];
					$city = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['city'];
					$state = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['state'];
					$phone = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['contact']['formattedPhone'];
					$rating =  $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['rating'];
					$url =  $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['url'];
					$zipcode = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['postalCode'];
					$resultnamelatlongrr = array (
							"id" => $id,
							"name" => $venueName,
							"address" => $venueAddress,
							"lat" => $venueLatitude,
							"lng" => $venueLongitude,
							"city" => $city,
							"state" => $state,
							"phone" => $phone,
							"rating" => $rating,
							"url"=>$url,
							"zipcode"=>$zipcode
					);
					array_push($result,$resultnamelatlongrr);
				}
				
			}
			if (sizeOf ( $result ) >= 1) {
				$insertReturn = $data->insertVenue($result);
			} else {
				echo $obj ['response'] ['warning'] ['text'];
			}
			
			$returnData = $data->selectVenueFromNameLatLongRatingRadius($lat1,$long1,$name1,$rating1,$radius1);
			//return $result;
			return  $returnData;
		} else
			
			return "Please check the credential again !!";
	}
	

	// Search by Zipcode + Name + radius + rating
	public function ZipNameRadiusRating($name1,$zipcode1,$radius1,$rating1) {
		$result = array();
		$resp_latlnggoogle = file_get_contents ( "https://maps.googleapis.com/maps/api/geocode/json?address=$zipcode1&key=AIzaSyCqt0V2s8VlZHYEjC2k1k_rWhcSDVFxwfg");
		$objlatlng = json_decode ( $resp_latlnggoogle, true );
		if ($objlatlng ['status'] == "OK") {
			$gglat = $objlatlng ['results'] ['0'] ['geometry'] ['location'] ['lat'];
			$gglng = $objlatlng ['results'] ['0'] ['geometry'] ['location'] ['lng'];
			$result = self::LatLongNameRadiusRating($gglat,$gglng,$name1,$radius1,$rating1);
		return $result;
				
		} else
			return "Please check the zipcode again !!";
	}
	
	
	//  City + Lat + Lng + Rad + Rating
	public function CityLatLngRadiusRating($lat1,$long1,$city1,$radius1,$rating1) {
	
		$radius_new = $radius1 * 1609.34;
		require_once 'rendezvousClass.php';
		$data = new Rendezvous();
		$newCity = str_replace(" ", "%2B", $city1);
		
		$resp_oauthtoken = file_get_contents ( "https://api.foursquare.com/v2/venues/explore?ll=$lat1,$lng1&radius=$radius_new&near=$newCity&oauth_token=34BKKF5OYKVTDBGZEWADDVHZB1NJQHZ2AEIOSOD0LRQ3T3KL&v=20151125");
		$obj = json_decode ( $resp_oauthtoken, true );
		
		$result = array ();
		
		if (floatval ( $obj ['meta'] ['code'] ) == 200) {
		for($i = 0; $i < sizeOf ( $obj ['response'] ['groups'] ['0'] ['items']); $i ++) {
				if (floatval ( $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['rating'] ) >= floatval ( $rating1 )) {
					$id = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['id'];
					$venueName = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['name'];
					$venueAddress = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['address'];
					$venueLatitude = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['lat'];
					$venueLongitude = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['lng'];
					$city = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['city'];
					$state = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['state'];
					$phone = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['contact']['formattedPhone'];
					$rating =  $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['rating'];
					$url =  $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['url'];
					$zipcode = $obj ['response'] ['groups'] ['0'] ['items'] [$i] ['venue'] ['location']['postalCode'];
					$resultlatlongrr = array (
							"id" => $id,
							"name" => $venueName,
							"address" => $venueAddress,
							"lat" => $venueLatitude,
							"lng" => $venueLongitude,
							"city" => $city,
							"state" => $state,
							"phone" => $phone,
							"rating" => $rating,
							"url"=>$url,
							"zipcode"=>$zipcode
					);
					array_push($result,$resultlatlongrr);
				}				
			}
			if (sizeOf ( $result ) >= 1) {
				$insertReturn = $data->insertVenue($result);
			} else {
				echo $obj ['response'] ['warning'] ['text'];
			}			
			$returnData = $data->selectVenueDataFromCityLatLongRatingRadius($city1, $lat1, $lng1, $rating1, $radius1);			
			return  $returnData;
		} else
			
			return "Please check the credential again !!";
	}
	
}
// 1 mile = 1609.34 meters
?>
