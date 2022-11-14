<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $title;?></title>
	<meta charset="utf-8">
	<?php if(isset($description)):?><meta name="description" content="<?php echo $description;?>"/><?php endif;?>
	<?php if(isset($keywords)):?><meta name="keywords" content="<?php echo $keywords;?>"/><?php endif;?>
	<link rel="stylesheet" href="/css/reset.css" type="text/css" media="screen">
	<link rel="stylesheet" href="/css/style.css" type="text/css" media="screen">
	<link rel="stylesheet" href="/css/grid.css" type="text/css" media="screen">  
	<script src="/js/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="/js/Vegur_500.font.js" type="text/javascript"></script>
	<script src="/js/Ropa_Sans_400.font.js" type="text/javascript"></script> 
	<script src="/js/FF-cash.js" type="text/javascript"></script>	  
	<script src="/js/tms-0.3.js" type="text/javascript"></script>
	<script src="/js/tms_presets.js" type="text/javascript"></script>
	<script src="/js/script.js" type="text/javascript"></script>
	<!--[if lt IE 8]>
	<div style=' clear: both; text-align:center; position: relative;'>
		<a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
			<img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
		</a>
	</div>
	<![endif]-->
	<!--[if lt IE 9]>
 		<script type="text/javascript" src="/js/html5.js"></script>
		<link rel="stylesheet" href="/css/ie.css" type="text/css" media="screen">
	<![endif]-->
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-EDRPTK2J2G"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-EDRPTK2J2G');
    </script>
</head>
<body id="page1">
	<!--==============================header=================================-->
	<header>
		<div class="border-bot">
			<div class="main">
				<h1><a href="/">Слова & Аккорды</a></h1>
				<?php if(isset($navibar)) echo $navibar;?>
				
				<div class="clear"></div>
			</div>
		</div>
		
	</header>
	<!--==============================content================================-->
	<section id="content">
		<div class="main">
			<div class="container_12">
				<div class="wrapper">
					<article class="grid_8">
						<?php echo $breadcrumbs?>
						<?php if($h1!=''):?>
							<h1><?=$h1?> <?=$status?></h1>
						<?php endif;?>
				      	<?php echo $toolbar?>
				      	<?php echo $content?>
				      	
					</article>
					<article class="grid_4 rightbar">
						<div class="indent-top indent-left">
						<?php if(isset($rightBar)) echo $rightBar?>
							</div>
					</article>
				</div>
			</div>
		</div>
	</section>
	<!--==============================footer=================================-->
	<footer>
		<div class="main">
			<div class="container_12">
				<div class="wrapper">
					<div class="grid_4">
						<div class="spacer-1">
							<a href="http://slovovery.ru"><img src="/images/footer-logo.png" class="logo_footer" alt=""></a>
						</div>
					</div>
					<div class="grid_5">
						<div class="indent-top2">
							<p class="prev-indent-bot centerFooterBlock">Сделано специально для <br/><a href="http://slovovery.ru">Церкви в Казани "Слово веры"</a>
						</div>
					</div>
					<div class="grid_3">
						
						<span class="footer-text">Made by <a href="http://vk.com/id8484823">Давид Полищук</a> <br/>&copy; 2014 <a class="link color-2" href="#">Privacy Policy</a></span>
						
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- <script src="/js/page.js"></script>
	<script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script> -->
	<?=$scripts?> 
</body>
</html>