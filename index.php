<?php

?>
<form method="post" target="_self">
	<input type="text" name="nama" id="nama" />
	<input type="submit" name="OK" id="OK" value="OK, liat tweet.."/>
</form>
<?php

	if($_POST&&$_POST["nama"]!=''){
		echo $_POST["nama"];
		tweet($_POST["nama"]);
	}

function tweet($nama){
	require_once('TwitterAPIExchange.php');
    /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
    $settings = array(
    'oauth_access_token' => "440652357-AlSQKFvdtXqoBMGgptvNfQnuvOyc6GvF8CkfU0rj",
    'oauth_access_token_secret' => "mPD4865CJ538W58d3zG5m2YSBU5Q1qBj7oBlzVh38LWya",
    'consumer_key' => "5ZjCpHYkVixdQuCMJ7e7fw",
    'consumer_secret' => "g1pTxij91IK8gXnx4lwGcomS7vOc2RRafyLXSE"
    );
    $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
    $requestMethod = "GET";
	if (isset($_GET['user'])) {$user = $_GET['user'];} else {$user = $nama;}
	if (isset($_GET['count'])) {$count = $_GET['count'];} else {$count = 20;}
	$getfield = "?screen_name=$user&count=$count";
	$twitter = new TwitterAPIExchange($settings);
	$string = json_decode($twitter->setGetfield($getfield)
	->buildOauth($url, $requestMethod)
	->performRequest(),$assoc = TRUE);
	if(array_key_exists("errors", $string)) {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
	foreach($string as $items)
		{
			echo "Time and Date of Tweet: ".$items['created_at']."<br />";
			echo "Tweet: ". $items['text']."<br />";
			echo "Tweeted by: ". $items['user']['name']."<br />";
			echo "Screen name: ". $items['user']['screen_name']."<br />";
			echo "Followers: ". $items['user']['followers_count']."<br />";
			echo "Friends: ". $items['user']['friends_count']."<br />";
			echo "Listed: ". $items['user']['listed_count']."<br /><hr />";
		}
}
?>
