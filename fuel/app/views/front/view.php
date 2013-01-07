
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

					<div class='print'>
						<a class='print' onclick="CallPrint('content')">Print Page</a>
					</div>

					<div id='photos_wrapper'>
						<div id='photos' class='galleryview'>
							<!--gallery images-->

							<? foreach($yachtshare->get_public_image_urls() as $row): ?>
								<div class="panel" >
									<table>
										<tr>
											<td>
												<img height="400px" src="<?=Uri::create('public/uploads/'.$row['url']);?>"/>
											</td>
										</tr>
									</table>
								</div>						
							<? endforeach; ?>
						</div><!-- photos -->
					</div><!--photos wrapper -->

						<div class='fast_details'>		
							<div>
								<span><strong>Type: </strong><?=$yachtshare->make;?></span><br />
								<span><strong>Price: </strong>&pound;<?=$yachtshare->price;?></span><br /> 
								<span><strong>Share Size: </strong><?=$yachtshare->share_size_num;?>/<?=$yachtshare->share_size_den;?></span><br />
								<span><strong>LOA: </strong> <?=$yachtshare->length;?>m</span><br /> 
								<span><strong>LWL: </strong> <?=$yachtshare->boat_details['lwl'];?></span><br /> 
								<span><strong>Beam:</strong> <?=$yachtshare->boat_details['beam'];?>m</span><br /> 
								<span><strong>Draft: </strong> <?=$yachtshare->boat_details['draft'];?>m</span><br /> 
								<span><strong>Keel: </strong> <?=$yachtshare->boat_details['keel'];?></span><br />
								<span><strong>Built: </strong> <?=$yachtshare->boat_details['built'];?></span><br /> 
								<span><strong>Sail Area: </strong> <?=$yachtshare->location_specific;?></span><br /> 
								<span><strong>Lying: </strong> <?=$yachtshare->boat_details['lying'];?></span><br /><br />
			
								<a class='up' id ='up' href="#" onclick="javascript:history.back(-1)" >&laquo; Back to Yacht Shares For Sale</a> 		
							</div>
						</div>
						<div class='long_details'><h2 class='grey'>SUMMARY</h2>
							<p>
								<?=$yachtshare->boat_details['teaser'];?>
							</p>

							<h2 class='grey'>SAILING EQUIPMENT</h2>
							<p>
								<?=str_replace("\n", "<br>",$yachtshare->boat_details['equipment']);?>
							</p>

							<h2 class='grey'>ENGINE, BATTERIES AND TANKS</h2>
							<p>
								<?=str_replace("\n", "<br>",$yachtshare->boat_details['engine']);?>
							</p>

							<h2 class='grey'>ACCOMMODATION</h2>
							<p>
								<?=str_replace("\n", "<br>",$yachtshare->boat_details['accomodation']);?>
							</p>
														
							<h2 class='grey'>NAVIGATION AND SAFETY</h2>
							<p>
								<?=str_replace("\n", "<br>",$yachtshare->boat_details['navigation']);?>
							</p>
														
							<h2 class='grey'>OWNERS COMMENTS</h2>
							<p>
								<?=$yachtshare->boat_details['owners_comments'];?>
							</p>
														
							<h2 class='grey'>ANNUAL RUNNING COSTS</h2>
							<p>
								<?=$yachtshare->boat_details['annual_costs'];?>
							</p>

						</div><!-- long details -->		                
					</div><!--content-->				
				</div><!--content_wrap-->
			
            <div id="footer">
<div id="footer_content"><a href='mailto: chris@sailfractions.co.uk'>Chris@sailfractions.co.uk</a>   |   <strong>Tel. 00 44 1326 374435</strong>   |   Fax.  00 44 1326 374625   |   PO Box 196, Falmouth, Cornwall TR11 5WD, UK</div>
<div id="copyrights">
<p>
© Copyrights 2010 Sailfractions. All rights reserved.</p>
</div>
<div id="credits">
<p>
<a href="http://www.stotlandesigns.com">web design</a> &amp; <a href="http://www.stotlandesigns.com">web development</a> by <strong>stotlandesigns</strong>
</p>
</div>

</div><!--footer-->	
            </div><!--page-->


</div><!--page_wrapper-->
</div><!--wrapper1-->
	 <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-19759414-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</body>
</html>
