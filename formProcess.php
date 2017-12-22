<?php
$year = $_POST["year"];
$month = $_POST["month"];
$day = $_POST["day"];


if(date('w', strtotime($year."-".$month."-".$day)) == 6) {
	$lastSat = $year."-".$month."-".$day;
} else {
	$lastSat = date("Y-m-d", strtotime("last saturday", strtotime($year."-".$month."-".$day)  ) );
}

function getData(){
	global $ar, $lastSat, $url, $getData, $json, $artist, $songTitle, $spotifyID;
	$url = "http://billboard.modulo.site/charts/".$lastSat."?max=1";
	$getData = file_get_contents($url);
	$json = json_decode($getData, true);
	$artist = $json['songs'][0]['display_artist'];
	$songTitle = $json['songs'][0]['song_name'];
	$spotifyID = $json['songs'][0]['spotify_id'];
	$ar = array($artist, $songTitle, $spotifyID);
}
getData();
$msg = $ar;
echo json_encode(['code'=>200, 'msg'=>$msg]);
exit;
?>