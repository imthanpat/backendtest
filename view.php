<?php
echo "<h2>Search Twitter API Test</h2>";
require_once('TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "823122555712045056-7W6lHDxVAh0UCCMecGrsPNtKdRqMita",
    'oauth_access_token_secret' => "2OlL0yo74zUt9bBoNqgp4AxuQUDF4QSYdAJp3At6BfrYM",
    'consumer_key' => "YAF57lMQY3BHNBCGRMEmJjZVH",
    'consumer_secret' => "wEbwO4xZOqj0QW1tg582slJ89Tvh2rxZWTqDiisiLVBkAOuHxF"
);

$url = "https://api.twitter.com/1.1/search/tweets.json";
$requestMethod = "GET";

/* Use geocode : latitude and longitude
   test case : 13.736717,100.523186,100km (bangkok)
*/
if (isset($_GET['geocode']))  {$geocode = $_GET['geocode'];}  else {$geocode  = "13.736717,100.523186,100km";}
if (isset($_GET['count'])) {$count = $_GET['count'];} else {$count = 20;}
$getfield = "?geocode=$geocode&count=$count";

$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
	->buildOauth($url, $requestMethod)
	->performRequest(),$assoc = TRUE);
if($string["errors"][0]["message"] != ""){
	echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>"
		.$string[errors][0]["message"]."</em></p>";
	exit();
}

// GET:"statuses" 
foreach($string['statuses'] as $items){
	echo"================================================================="."<br />";
	echo '<img src="'.$items['user']['profile_image_url'].'" alt="error">'."<br />";
    echo "Time and Date of Tweet: ".$items['created_at']."<br />";
    echo "Tweet: ". $items['text']."<br />";
    echo "Tweeted by: ". $items['user']['name']."<br />";
	echo "Coordinates: ".$items['coordinates']."<br />";
}
?>