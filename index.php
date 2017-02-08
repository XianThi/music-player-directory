<?php
error_reporting(0);
$results = array();
$directory = 'data';
if(isset($_GET["search"])){
$search=$_GET["search"];
if($search=="#"){
unset($search);
}
}else
{
$search='';
}
unset($results);
$results=glob_files($directory,$search,"mp3");
function glob_files($source_folder,$pattern, $ext){
    if( !is_dir( $source_folder ) ) {
        $return = "Dizin bulunamadı..";
    }
    if (!empty($pattern)){
    $FILES=glob($source_folder."/".$pattern."/*".$ext,0);
    foreach($FILES as $key => $file) {
    $filey=explode("/",$file);
    $filey[2]= iconv("windows-1254", "utf-8", $filey[2]);
    $filey[1]=  iconv("windows-1254", "utf-8", $filey[1]);
    $FILE_LIST[$key]["path"]=$filey[2];
    $FILE_LIST[$key]["name"]=$filey[1]."/".$filey[2];
    }
    if(!empty($FILE_LIST)){
        $return=$FILE_LIST;
    } else {
        $return="Dosya bulunamadı..";
    }
    }else{
    foreach (glob($source_folder."/*", GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
    $dir=substr($dir, 5);
    $a=explode("/",$dir);
    foreach($a as $s){
    $FILE_LIST[]["path"]="dir";
    $FILE_LIST[]["href"]=$s;
    }
    }
   if(!empty($FILE_LIST)){
   $return=$FILE_LIST;
    } else {
        $return = "Dosya bulunamadı..";
    }
    }
    return $return;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="author" content="Script Tutorials" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Müzik Kutusu - Teknik Ofis</title>

    <!-- add styles and scripts -->
    <link href="css/styles.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
</head>
<body>
<div class="content">
<div class="playlistex">

</div>
<div class="player">
    <div class="pl"></div>
    <div class="title"></div>
    <div class="cover"></div>
    <div class="controls">
        <div class="play"></div>
        <div class="pause"></div>
        <div class="rew"></div>
        <div class="fwd"></div>
    </div>
    <div class="volume"></div>
    <div class="tracker"></div>
    <div class="artist hidden"></div>
</div>
<div class="playlistdiv">
<ul class="playlist">
<?php if(empty($results[0]["name"])){ ?>
<li audiourl="yabanci/Skrillex - Bangarang.mp3" cover="cover1.png" artist="Bilinmeyen">Günün Seçileni</li>   
<?php } ?>
<?php foreach($results as $result){ 
if(isset($result["href"])){
echo "<li><a href=?search=".$result["href"].">".$result["href"]."</a></li>";
}else{
if($result["path"]=='dir'){
echo "<li><a href=?search=".$result["href"].">".$result["href"]."</a></li>";
 }else{
    ?>
    <li audiourl="<?=$result["name"];?>" cover="cover1.png" artist="Bilinmeyen"><?=$result["path"];?></li>
<?php 
}}
?>
<?php } ?>
</ul></div>
</div>
</body>
</html>