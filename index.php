<LINK rel="stylesheet" type="text/css" href="css/style.css">

<form action="index.php" method="get">
	Enter your zip code to get started: 
	<input name="zip" size="10" type="text">
	<input name="p" type="hidden" value="true">
</form>


<?php 

// Show errors
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

$zip = $_GET['zip'];

if ($zip != "" ){

	// Define your advocacy tweet
	$message = "This is a test";

	// Set sunlight labs data
	include_once "includes/class.sunlightlabs.php";
	$api_key = 'YOURKEYHERE';

	// Lookup legislators
	$sl = new SunlightLegislator; 
	$sl->api_key = $api_key;

	$sun_legislator = $sl->legislatorZipCode( $zip );
	//print_r($sun_legislator);

	if ($_GET['p'] == 'true') {
	
		echo "<div class=TwAdLeg>\n";
			echo "<div class=TwAdLegDetails>\n";
				echo "<img src='http://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Official_portrait_of_Barack_Obama.jpg/225px-Official_portrait_of_Barack_Obama.jpg' align=left height=80>\n";
				echo "<span class=TWAdLegName>President Barack Obama (D)</span><br>\n";
				echo "Address: 1600 Pennsylvania Ave<br>\n";
				echo "Phone: 202-456-1111<br>\n";
			echo "</div>\n";
			
			echo "<div class=TwAdLegAction>\n";
					echo "<div class=TwActionTwitter><a href='http://twitter.com/home?status=@BarackObama ".$message."' target='_blank'  onclick=''>Send Tweet</a></div>\n";
			
			echo "</div>\n";			
		echo "</div>\n";
			
	}
	
	foreach ($sun_legislator as $legislator) {
	
		echo "<div class=TwAdLeg>\n";
			echo "<div class=TwAdLegDetails>\n";
				echo "<img src='http://www.opencongress.org/images/photos/thumbs_125/".$legislator->legislator->govtrack_id.".jpeg' align=left height=80>\n";
				echo "<span class=TWAdLegName>".$legislator->legislator->title." ".$legislator->legislator->firstname." ".$legislator->legislator->lastname." (".$legislator->legislator->party.")</span><br>\n";
				echo $legislator->legislator->state." ".$legislator->legislator->district."<br>\n";
				echo "Address: ".$legislator->legislator->congress_office."<br>\n";
				echo "Phone: ".$legislator->legislator->phone."<br>\n";
			echo "</div>\n";
			
			echo "<div class=TwAdLegAction>\n";
			
				if ($legislator->legislator->twitter_id != "") {
					echo "<div class=TwActionTwitter><a href='http://twitter.com/home?status=@".$legislator->legislator->twitter_id." ".$message."' target='_blank'  onclick=''>Send Tweet</a></div>\n";
				}
				else {
					echo "<div class=TwActionEmail><a href='".$legislator->legislator->webform."' target='_blank' onclick=''>Send Email</a></div>\n";
				}
			
			echo "</div>\n";			
		echo "</div>\n";
	}

}


?>