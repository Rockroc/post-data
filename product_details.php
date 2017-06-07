<?php
set_time_limit(0);
require 'Zip.class.php';
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
// print_r($output);


$prel = "/<div class=\"name\">(.*)<\/div>/";
preg_match($prel, $output, $arr);

$title = $arr[1];
// print_r($output);
$prel = '/<div class="desc" id="Scroller-1">(.*)<\/div>/isu';
preg_match($prel, $output, $arr);
$content = $arr[1];

make_dir('uploads/'.$title);
file_put_contents('uploads/'.$title.'/content.html',$content);

//$prel = '/<img src="upload\/(.*).jpg".*/';
$prel = '/<[img|IMG].*?src=[\'|\"]upload\/(.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/';
preg_match_all($prel, $output, $arr);
$imgArr = $arr[1];

$base_url = "http://www.tomleemusic.com.hk/acton/vox/upload/";
$images = array();
foreach($imgArr as $value){
  $iarr = explode('"',$value);
  $images[] = $base_url.$iarr[0];
  file_put_contents('uploads/'.$title.'/images.txt',$base_url.$iarr[0].PHP_EOL,FILE_APPEND);
}


$path = 'uploads';
foreach ($images as $pic_item) { //循环取出每幅图的地址
    download_image($pic_item,'','uploads/'.$title); //下载并保存图片
    // echo "[OK]..!";
}

$archive = new PHPZip();
$archive->ZipAndDownload('uploads/'.$title);


function make_dir($path){
    if(!file_exists($path)){//不存在则建立
        $mk=@mkdir($path,0777); //权限
        @chmod($path,0777);
    }
    return true;
}

/**
 * 下载远程图片到本地
 *
 * @param string $url 远程文件地址
 * @param string $filename 保存后的文件名（为空时则为随机生成的文件名，否则为原文件名）
 * @param array $fileType 允许的文件类型
 * @param string $dirName 文件保存的路径（路径其余部分根据时间系统自动生成）
 * @param int $type 远程获取文件的方式
 * @return json 返回文件名、文件的保存路径
 * @author blog.snsgou.com
 */
function download_image($url, $fileName = '', $dirName, $fileType = array('jpg', 'gif', 'png'), $type = 1)
{
    if ($url == '')
    {
        return false;
    }

    $url = str_replace ( ' ', '%20', $url);

    // 获取文件原文件名
    $defaultFileName = basename($url);

    // 获取文件类型
    $suffix = substr(strrchr($url, '.'), 1);
    if (!in_array($suffix, $fileType))
    {
        return false;
    }

    // 设置保存后的文件名
    $fileName = $fileName == '' ? time() . rand(0, 9) . '.' . $suffix : $defaultFileName;

    // 获取远程文件资源
    if ($type)
    {
        $ch = curl_init();
        $timeout = 30;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $file = curl_exec($ch);
        curl_close($ch);
    }
    else
    {
        ob_start();
        readfile($url);
        $file = ob_get_contents();
        ob_end_clean();
    }

    // 设置文件保存路径
    //$dirName = $dirName . '/' . date('Y', time()) . '/' . date('m', time()) . '/' . date('d', time());
    // $dirName = $dirName . '/' . date('Ym', time());
    if (!file_exists($dirName))
    {
        mkdir($dirName, 0777, true);
    }

    // 保存文件
    $res = fopen($dirName . '/' . $fileName, 'a');
    fwrite($res, $file);
    fclose($res);

    return array(
        'fileName' => $fileName,
        'saveDir' => $dirName
    );
}
function gc($url){
 $curl = curl_init($url); //初始化
 curl_setopt($curl, CURLOPT_HEADER, FALSE);
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);  //将结果输出到一个字符串中，而不是直接输出到浏览器

 curl_setopt($curl, CURLOPT_REFERER, 'http://www.tomleemusic.com.hk/'); //最重要的一步，手动指定Referer

 $re = curl_exec($curl); //执行

 if (curl_errno($curl)) {
  curl_close($curl);
  return NULL;
 }
 curl_close($curl);
 return $re;
}
