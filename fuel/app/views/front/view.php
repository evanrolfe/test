<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
	     <link rel="icon" href="<?=Uri::create('public/assets/images/favicon.ico');?>" type="image/x-icon" />
		<link rel="shortcut icon" href="<?=Uri::create('public/assets/images/favicon.ico');?>" />
		<title>Yacht Fractions</title>
		<meta name="description" content="shares offered in oyster 72 sailing cruiser based Med and Caribbean" />
		<meta name="keywords" content="Yacht Shares For Sale" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=Uri::create('public/assets/front/layout_en.css');?>" />
        <link rel="stylesheet" type="text/css" href="<?=Uri::create('public/assets/front/jquery.fancybox-1.2.5.css');?>" />
        <link rel="stylesheet" type="text/css" href="<?=Uri::create('public/assets/front/menu.css');?>" />
		<script type="text/javascript" src="<?=Uri::create('public/assets/front/jquery-1.3.2.min.js');?>"></script>
        <script type="text/javascript" src="<?=Uri::create('public/assets/front/jquery.fancybox-1.2.5.pack.js');?>"></script>

        <script type="text/javascript" src="<?=Uri::create('public/assets/front/details/jquery.easing.1.3.js');?>"></script>
		<script type="text/javascript" src="<?=Uri::create('public/assets/front/details/runonload.js');?>"></script>
		<script type="text/javascript" src="<?=Uri::create('public/assets/front/details/function.js');?>"></script>
		<script type="text/javascript" src="<?=Uri::create('public/assets/front/details/jquery.galleryview-1.1.js');?>"></script>
		<script type="text/javascript" src="<?=Uri::create('public/assets/front/details/jquery.timers-1.1.2.js');?>"></script>
		<script type="text/javascript" src="<?=Uri::create('public/assets/front/details/tutorial.js');?>"></script>
		<link rel="stylesheet" type="text/css" href="<?=Uri::create('public/assets/front/details/galleryview.css');?>" />
		<link rel="stylesheet" type="text/css" href="<?=Uri::create('public/assets/front/details/tutorial.css');?>" />

		<!-- HIGHSLIDE GALLERY - added by Evan 31/02/13 -->

			<script type="text/javascript" src="<?=Uri::create('public/assets/highslide/highslide-with-gallery.js');?>"></script>

			<link rel="stylesheet" type="text/css" href="<?=Uri::create('public/assets/highslide/highslide.css');?>" />

			<script type="text/javascript">
			    // override Highslide settings here
			    // instead of editing the highslide.js file
				/**
				*	Site-specific configuration settings for Highslide JS
				*/
			    hs.graphicsDir = "../../public/assets/highslide/graphics/";
				hs.showCredits = false;
				hs.outlineType = 'custom';
				hs.dimmingOpacity = 0.75;
				hs.fadeInOut = true;
				hs.align = 'center';
				hs.marginBottom = 105;
				hs.numberOfImagesToPreload = 15;
				hs.captionEval = 'this.a.title';


				// Add the slideshow controller
				hs.addSlideshow({
					slideshowGroup: 'group1',
					interval: 5000,
					repeat: false,
					useControls: true,
					fixedControls: false,
					overlayOptions: {
						className: 'text-controls',
						opacity: 1,
						position: 'bottom center',
						offsetX: 0,
						offsetY: -60,
						relativeTo: 'viewport',
						hideOnMouseOut: false
					},
					thumbstrip: {
						mode: 'horizontal',
						position: 'bottom center',
						relativeTo: 'viewport'
					}

				});

				// gallery config object
				var config1 = {
					slideshowGroup: 'group1',
					thumbnailId: 'thumb1',
					numberPosition: 'caption',
					transitions: ['expand', 'crossfade']
				};			    
			</script>

			<style type="text/css">
				.highslide img {
					cursor: url(highslide/graphics/zoomin.cur), pointer !important;
				}
				.highslide-viewport-size {
					position: fixed;
					width: 100%;
					height: 100%;
					left: 0;
					top: 0;
				}
				#top_menu_CMR a {
					color: #939393;
					margin: 0;
					text-decoration: none;
					font-size: 15px;
				}

				#credits_evan a {
					color: #939393;
					margin: 0;
					text-decoration: none;
					font-size: 10px;
				}
			</style>


		<!-- / HIGHSLIDE GALLERY -->		
	</head>
<body>
<div id="wrapper1">
<div id="page_wrapper">
		<div id="page" class="clearfix">			 	
				<div id="content_wrap" class="clearfix">
                    <div id="header" style="height:140px;">
						<p>&nbsp;</p>
						<div align="left">
						  <p><a href="http://www.yachtfractions.co.uk"><img src="<?=Uri::create('public/assets/images/logo.gif');?>" alt="logo" vspace="22" /></a> </p>
						 <div id="top_menu_CMR"> <a href="http://www.yachtfractions.co.uk/" >HOME</a> </div>			    </p>
						</div>
						      <div align="right"><a class="up" id="up" href="#" onclick="javascript:history.back(-1)">« Back to Yacht Listing</a>
		                  </div>
               
						<hr>							
	                </div>

					<div id="content" class="clearfix">
                
					<div class='header'>
						<h1 class='grey'><?=$yachtshare->make;?> - <?=$yachtshare->name;?></h1>
					</div>
			
<!-- NEW STUFF to include the highslide gallery -->

<table width="100%" border="0">
	<tbody>
  		<tr>
			<td width="68%">

				<div class="highslide-gallery">

					<a id="thumb1" href="<?=Uri::create('public/uploads/'.$yachtshare->get_header_image_url());?>" class="highslide " title="" onclick="return hs.expand(this, config1 )">
						<img src="<?=Uri::create('public/uploads/'.$yachtshare->get_header_image_url());?>" alt="" width="500">
					</a>

					<div class="hidden-container">
						<? foreach($yachtshare->get_public_image_urls_except_header() as $row): ?>
							<a href="<?=Uri::create('public/uploads/'.$row['url']);?>" class="highslide" title="" onclick="return hs.expand(this, config1 )">
								<img src="<?=Uri::create('public/uploads/'.$row['url']);?>" alt="">
							</a>
						<? endforeach; ?>
					</div>
				</div>

				<p>Click the image to view more photographs of this yacht.</p>
			</td>
    		<td width="32%" align="left" valign="top"><div class="fast_details">		
				  <div>
						<span><strong>Type: </strong><?=$yachtshare->make;?></span><br>
						<span><strong>Price: </strong>£<?=$yachtshare->price;?></span><br> 
						<span><strong>Share Size: </strong><?=$yachtshare->share_size_num;?>/<?=$yachtshare->share_size_den;?></span><br>
						<span><strong>LOA: </strong> <?=$yachtshare->length;?> m</span><br> 
						<span><strong>LWL: </strong> <?=$yachtshare->boat_details['lwl'];?></span><br> 
						<span><strong>Beam:</strong> <?=$yachtshare->boat_details['beam'];?></span><br> 
						<span><strong>Draft: </strong> <?=$yachtshare->boat_details['draft'];?></span><br> 
						<span><strong>Keel: </strong> <?=$yachtshare->boat_details['keel'];?></span><br>
						<span><strong>Built: </strong> <?=$yachtshare->boat_details['built'];?></span><br> 
						<span><strong>Lying: </strong> <?=$yachtshare->location_specific;?></span><br><br>
				  </div>
			</td>
		</tr>
	</tbody>
</table>

<!-- / NEW STUFF to include the highslide gallery -->


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
							
							<h2 class='grey'>DINGHY</h2>
							<p>
								<?=str_replace("\n", "<br>",$yachtshare->boat_details['dinghy']);?><br />
								<?=str_replace("\n", "<br>",$yachtshare->boat_details['outboard_motor']);?>
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
<div id="footer_content">
	<a href='mailto: chris@sailfractions.co.uk'>Chris@sailfractions.co.uk</a>   |   <strong>Tel. 00 44 1326 374435</strong>   |   Fax.  00 44 1326 374625   |   PO Box 196, Falmouth, Cornwall TR11 5WD, UK</div>


</div><!--footer-->	
            </div><!--page-->


</div><!--page_wrapper-->
</div><!--wrapper1-->

<div id="credits_evan" style="color: #939393;">
  <div align="center">Website development by <a href="http://evanrolfe.info/">Evan Rolfe</a>.</div>
</div>

</body>
</html>
