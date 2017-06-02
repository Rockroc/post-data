<?php
$url = "http://www.tomleemusic.com.hk/acton/vox/product_search.php";
$post_data = array ("key" => $_POST['keyword'],"brandId"=>16);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// post数据
curl_setopt($ch, CURLOPT_POST, 1);
// post的变量
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
$output = curl_exec($ch);
curl_close($ch);
//打印获得的数据
// $pattern="/<li><a title=\"(.*)\" target=\"_blank\" href=\"(.*)\">/iUs";//正则
$prel = "/<tr><td><a href=\"(.*)\">(.*)<\/a><\/td><\/tr>/";
preg_match_all($prel, $output, $arr);
var_dump($arr);
// print_r($output);
 ?>

<!DOCTYPE HTML>
<html>
<head>
<title>音乐发烧友HTML5模板-777模板</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Melody Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-1.11.1.min.js"></script>
<!-- Custom Theme files -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!-- Custom Theme files -->
<script src="js/bootstrap.min.js"></script>
<link href="css/font-awesome.css" rel="stylesheet">
<!--webfont-->

</head>
<body>
 <div class="banner">
 	<!-- start search-->
			<div class="search-box">
			   <div id="sb-search" class="sb-search">
				  <form method="post" action="search.php">
					 <input class="sb-search-input" placeholder="Enter your search term..." type="search" name="aaa" id="search">
					 <input class="sb-search-submit" type="submit" value="">
					 <span class="sb-icon-search"> </span>
				  </form>
			    </div>
			 </div>
			 <!----search-scripts---->
			 <script src="js/classie.js"></script>
			 <script src="js/uisearch.js"></script>
			   <script>
				 new UISearch( document.getElementById( 'sb-search' ) );
			   </script>
				<!----//search-scripts---->
				<div class="container">
					<div class="banner-info">
						  <?php echo $arr[0][0] ?>
            </div>
					 <div class="clearfix"></div>
			   </div>

</div>




</html>
