<?php
/*
Channels https://www.glaz.tv/online-tv/
USE ?url=TV NAME
EXAMPLE ?url=tv-centr - ?url=tnt-online ETC....
user_agent Duhet iPhone
*/

$get_url = isset($_GET["url"]) && !empty($_GET["url"]) ? $_GET["url"] : "rtr-planeta";

function get_data($url) {
    $ch = curl_init();
    $timeout = 2;
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

$link = get_data("https://www.glaz.tv/online-tv/" . $get_url);
/*
Chromecast URL
http://178.162.218.87:8081/chromecast/rtrpl.stream/playlist.m3u8?wmsAuthSign=c2VydmVyX3RpbWU9MTIvMTkvMjAyMSA1OjE2OjU3IFBNJmhhc2hfdmFsdWU9dThCSDc5VEpkRzQwM0t0Sy9LTEhsZz09JnZhbGlkbWludXRlcz0yMDA=

Playerjs URL
https://s10390.glaz.tv:8082/liveg/rtrpl.stream/playlist.m3u8?wmsAuthSign=c2VydmVyX3RpbWU9MTIvMTkvMjAyMSA1OjE2OjU3IFBNJmhhc2hfdmFsdWU9dThCSDc5VEpkRzQwM0t0Sy9LTEhsZz09JnZhbGlkbWludXRlcz0yMDA=
*/

// PER STREAM TE SHPEJTE LENI ACTIVE Chromecast REGEX

// Playerjs REGEX
//preg_match_all('/.*playerjs.*file.*"(http.*?.*m3u8.*?.*?.*)"/',$link,$matches, PREG_PATTERN_ORDER);

// Chromecast REGEX DEFAULT FOR FASTER STREAMS
preg_match_all('/.*chromecastMedia.*.*\n.*url.*"(http.*?.*m3u8.*?.*?.*)"/',$link,$matches, PREG_PATTERN_ORDER);
$stream_m3u = $matches[1][0];

preg_match_all('/var signature = "(.*?.*?.*)"/',$link,$signature_matches, PREG_PATTERN_ORDER);
$signature = $signature_matches[1][0];
$stream = $stream_m3u.$signature;
//echo $stream;

// GET TITLES
preg_match_all("/.*chromecastMedia.*.*\n.*url.*\"(http.*?.*m3u8.*?.*?.*)\".*\n.*title: '(.*?.*?.*)'/",$link,$title_matches, PREG_PATTERN_ORDER);
$title = $title_matches[2][0];
//echo $title;

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo "#EXTM3U\n";
echo "#EXTINF:-1,".trim($title)."\n";
echo $stream;
?>
