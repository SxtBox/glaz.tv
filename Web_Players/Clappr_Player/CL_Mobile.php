<?php
/*
Player Generated From https://demo.kodi.al/My_Tools/Players_Tools/Player_Builder/Clappr_Player/
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
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title><?php echo $title ?></title>
<link rel="shortcut icon" href="https://kodi.al/panel.ico"/>
<link rel="icon" href="https://kodi.al/panel.ico"/>
<style type="text/css">
body,td,th {
	color: #0F0;
}
body {
	background-color: #000;
}
a:link {
	color: #0FC;
}
a:visited {
	color: #3F6;
}
a:hover {
	color: #09F;
}
a:active {
	color: #009;
}
</style>
<!-- Include CDN Player -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@clappr/player@latest/dist/clappr.min.js"></script>
</head>
<body>
<?php
// AUTOMATIC PLAYER SWITCHING FOR ANDROID DEVICES
$ipod = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
$iphone = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$ipad = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
$android = stripos(strtolower($_SERVER['HTTP_USER_AGENT']),"android");
if(($ipod != true) &&( $iphone != true)&&( $ipad != true)&&( $android != true)){
?>
<!-- DESKTOP PLAYER -->
<div id="player"></div>
<script>
var player = new Clappr.Player({
source: "<?php echo $stream ?>",
poster: "https://png.kodi.al/tv/albdroid/logo_bar.png",
watermark: "https://png.kodi.al/tv/albdroid/logo_bar.png",
position: "top-right",
watermarkLink: "http://albdroid.al",
scale: "exactfit",
<!-- Include Player parentId [Default player] -->
parentId: "#player",
playInline: true,
autoPlay: false,
// autoPlay: true,
// mimeType: 'audio/mpeg',
mediacontrol: {seekbar: "#0F0", buttons: "#0F0"},
width: '100%',
height: '100%'
});
</script>
<?php }else{ ?>
<!-- ANDROID PLAYER -->
<div id="player"></div>
<script>
var player = new Clappr.Player({
<!--  YOU CAN SET DIFFERENT SOURCE FOR ANDROID DEVICES HERE  -->
source: "<?php echo $stream ?>",
poster: "https://png.kodi.al/tv/albdroid/black.png",
watermark: "https://png.kodi.al/tv/albdroid/smart_x254.png",
position: "top-right",
watermarkLink: "http://albdroid.al",
scale: "exactfit",
<!-- Include Player parentId [Default player] -->
parentId: "#player",
playInline: true,
autoPlay: false,
// autoPlay: true,
mediacontrol: {seekbar: "#0F0", buttons: "#0F0"},
width: '100%',
height: '100%'
});
</script>
<?php } ?>
</body>
</html>