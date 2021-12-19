<?php
/*
Channels http://m.glaz.tv/
USE ?url=TV NAME
EXAMPLE ?url=tv-centr - ?url=tnt-online ETC....
user_agent Duhet iPhone
Ignore msg -> Flash player needs to be updated
*/

$get_url = isset($_GET["url"]) && !empty($_GET["url"]) ? $_GET["url"] : "rtr-planeta";

function get_data($url) {
    $ch = curl_init();
    $timeout = 5;
	$referenca = ($url);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, "iPhone");
    curl_setopt($ch, CURLOPT_REFERER, $referenca);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

$link = get_data("http://m.glaz.tv/online-tv/" . $get_url);
preg_match_all('/.*myplayer.*file.*(http.*?.*m3u8.*?wmsAuth.*?.*\d.....)/',$link,$matches, PREG_PATTERN_ORDER);
$stream = $matches[1][0];
// echo $stream;

// GET TITLES
preg_match_all("/title>(.*?)</",$link,$title_matches);
$title = $title_matches[1][0];
//echo $title;

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo "#EXTM3U\n";
echo "#EXTINF:-1,".trim($title)."\n";
echo $stream;
?>
