<?php
$ch = curl_init();
$url = "http://www.tomleemusic.com.hk/acton/vox/product_details.php?id={$_GET['id']}&categoryId={$_GET['categoryId']}";
//设置选项，包括URL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
//执行并获取HTML文档内容
$output = curl_exec($ch);
//释放curl句柄
curl_close($ch);
//打印获得的数据
print_r($output);


$prel = "/<div class=\"name\">(.*)<\/div>/";
preg_match($prel, $output, $arr);
$title = $arr['0'];
echo $title;

//$prel = '/<img src="upload\/(.*).jpg".*/';
$prel = '/<[img|IMG].*?src=[\'|\"]upload\/(.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/';
preg_match_all($prel, $output, $arr);
$imgArr = $arr[0];
print_r($arr[1]);die();

$base_url = "http://www.tomleemusic.com.hk/acton/vox/";
$images = array();
foreach($imgArr as $value){
  $iarr = explode('"',$value);
  $images[] = $base_url.$iarr[1];
}
print_r($images);
