
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
	     <link rel="icon" href="<?=Uri::create('public/assets/images/favicon.ico');?>" type="image/x-icon" />
		<link rel="shortcut icon" href="<?=Uri::create('public/assets/images/favicon.ico');?>" />
		<title>Sail Fractions</title>
		<meta name="description" content="shares offered in oyster 72 sailing cruiser based Med and Caribbean" />
		<meta name="keywords" content="Yacht Shares For Sale" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=Uri::create('public/assets/front/layout_en.css');?>" />
        <link rel="stylesheet" type="text/css" href="<?=Uri::create('public/assets/front/jquery.fancybox-1.2.5.css');?>" />
        <link rel="stylesheet" type="text/css" href="<?=Uri::create('public/assets/front/menu.css');?>" />
		<script type="text/javascript" src="<?=Uri::create('public/assets/front/jquery-1.3.2.min.js');?>"></script>
        <script type="text/javascript" src="<?=Uri::create('public/assets/front/jquery.fancybox-1.2.5.pack.js');?>"></script>

        <script type="text/javascript">
			$(document).ready(function(){
					$('#photos').galleryView({
						panel_width: 565,
						panel_height: 385,
						frame_width: 55,
						frame_height: 40,
						transition_speed: 5000,
						background_color: '#fff',
						border: 'none',
						easing: 'easeInOutBack',
						pause_on_hover: true,
					   // nav_theme: 'custom',
						overlay_height: 52,
						filmstrip_position: 'bottom',
						overlay_position: 'bottom'
					});
					
					$('.panel .zoom2 img').hover(function(){
						$('.glass').show();
					});
					$('.panel .zoom2 img').mouseout(function(){
						$('.glass').hide();
					});			
		});
        </script>
        <script type="text/javascript" src="<?=Uri::create('public/assets/front/details/jquery.easing.1.3.js');?>"></script>
		<script type="text/javascript" src="<?=Uri::create('public/assets/front/details/runonload.js');?>"></script>
		<script type="text/javascript" src="<?=Uri::create('public/assets/front/details/function.js');?>"></script>
		<script type="text/javascript" src="<?=Uri::create('public/assets/front/details/jquery.galleryview-1.1.js');?>"></script>
		<script type="text/javascript" src="<?=Uri::create('public/assets/front/details/jquery.timers-1.1.2.js');?>"></script>
		<script type="text/javascript" src="<?=Uri::create('public/assets/front/details/tutorial.js');?>"></script>
		<link rel="stylesheet" type="text/css" href="<?=Uri::create('public/assets/front/details/galleryview.css');?>" />
		<link rel="stylesheet" type="text/css" href="<?=Uri::create('public/assets/front/details/tutorial.css');?>" />
	</head>
<body>
<div id="wrapper1">
<div id="page_wrapper">
		<div id="page" class="clearfix">			 	
				<div id="content_wrap" class="clearfix">
                    <div id="header" style="height:125px;">
						<div id="logo">
							<a href="http://www.yachtfractions.co.uk"></a>
						</div>
						<div align="right">
							<a href="http://www.yachtfractions.co.uk">Back to www.yachtfractions.co.uk</a>
						</div>
						<hr>						
	                </div>
					<div id="content" class="clearfix">
                
						<div class='header'>
							<h1 class='grey'><?=$yachtshare->make;?> - <?=$yachtshare->name;?></h1>
						</div>

						<? foreach($yachtshare->get_public_image_urls() as $row): ?>
							<img src="<?= Uri::create('public/uploads/'.$row['url']); ?>" /><br /><br />
						<? endforeach; ?>
					</div>
				</div>
		</div>
	</div>
</div>
