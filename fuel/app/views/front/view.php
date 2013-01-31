
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
			    hs.graphicsDir = "<?=Uri::create('public/assets/highslide/graphics');?>";
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
			</style>


		<!-- / HIGHSLIDE GALLERY -->		
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
			
<!-- NEW STUFF to include the highslide gallery -->

<table width="100%" border="0">
	<tbody>
  		<tr>
			<td width="68%">

				<div class="highslide-gallery">

					<a id="thumb1" href="http://yacht-fractions.co.uk/public/crolfe/highslide/images/large/aquilasaloon.jpg" class="highslide " title="" onclick="return hs.expand(this, config1 )">
						<img src="http://yacht-fractions.co.uk/public/crolfe/highslide/images/large/aquilasaloon.jpg" alt="" width="500" height="375">
					</a>

					<div class="hidden-container">

						<a href="http://yacht-fractions.co.uk/public/crolfe/highslide/images/large/aquilasaloon.jpg" class="highslide" title="" onclick="return hs.expand(this, config1 )">
							<img src="./view_dad_files/aquilasaloon.jpg" alt="">
						</a>

						<a href="http://yacht-fractions.co.uk/public/crolfe/highslide/images/large/aquilamoored.jpg" class="highslide" title="" onclick="return hs.expand(this, config1 )">
							<img src="./view_dad_files/aquilamoored.jpg" alt="">
						</a>

					</div>
				</div>

				<p>Click the image to view more photographs of this yacht.</p>
			</td>
    		<td width="32%" align="left" valign="top"><div class="fast_details">		
				  <div>
						<span><strong>Type: </strong>Elan Impression 434</span><br>
						<span><strong>Price: </strong>£30000</span><br> 
						<span><strong>Share Size: </strong>1/4</span><br>
						<span><strong>LOA: </strong> 13m</span><br> 
						<span><strong>LWL: </strong> </span><br> 
						<span><strong>Beam:</strong> 4.18</span><br> 
						<span><strong>Draft: </strong> 1.9</span><br> 
						<span><strong>Keel: </strong> Fin</span><br>
						<span><strong>Built: </strong> 2007</span><br> 
						<span><strong>Sail Area: </strong> Turkey</span><br> 
						<span><strong>Lying: </strong> Marmaris</span><br><br>
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
<div id="copyrights">
</div>
<div id="credits">
<p>
Developed by <a href='http://evanrolfe.info'>Evan Rolfe</a>.
</p>
</div>

</div><!--footer-->	
            </div><!--page-->


</div><!--page_wrapper-->
</div><!--wrapper1-->

<div id="fancy_overlay"></div><div id="fancy_loading"><div></div></div><div id="fancy_outer"><div id="fancy_inner"><div id="fancy_close"></div><div id="fancy_bg"><div class="fancy_bg" id="fancy_bg_n"></div><div class="fancy_bg" id="fancy_bg_ne"></div><div class="fancy_bg" id="fancy_bg_e"></div><div class="fancy_bg" id="fancy_bg_se"></div><div class="fancy_bg" id="fancy_bg_s"></div><div class="fancy_bg" id="fancy_bg_sw"></div><div class="fancy_bg" id="fancy_bg_w"></div><div class="fancy_bg" id="fancy_bg_nw"></div></div><a href="javascript:;" id="fancy_left"><span class="fancy_ico" id="fancy_left_ico"></span></a><a href="javascript:;" id="fancy_right"><span class="fancy_ico" id="fancy_right_ico"></span></a><div id="fancy_content"></div></div></div><div id="fancy_title"><table cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="fancy_title" id="fancy_title_left"></td><td class="fancy_title" id="fancy_title_main"><div></div></td><td class="fancy_title" id="fancy_title_right"></td></tr></tbody></table></div><div class="highslide-container" style="padding: 0px; border: none; margin: 0px; position: absolute; left: 0px; top: 0px; width: 100%; z-index: 1001; direction: ltr;"><a class="highslide-loading" title="Click to cancel" href="javascript:;" style="position: absolute; top: -9999px; opacity: 0.75; z-index: 1;">Loading...</a><div style="display: none;"></div><div class="highslide-viewport highslide-viewport-size" style="padding: 0px; border: none; margin: 0px; visibility: hidden; display: none;"></div><div class="highslide-dimming highslide-viewport-size" style="padding: 0px; border: none; margin: 0px; visibility: visible; opacity: 0; display: none;"></div><table cellspacing="0" style="padding: 0px; border: none; margin: 0px; visibility: hidden; position: absolute; border-collapse: collapse; width: 0px;"><tbody style="padding: 0px; border: none; margin: 0px;"><tr style="padding: 0px; border: none; margin: 0px; height: auto;"><td style="padding: 0px; border: none; margin: 0px; line-height: 0; font-size: 0px; background-image: url(http://yacht-fractions.co.uk/public/crolfe/highslide/graphics/outlines/custom.png); height: 28px; width: 28px; background-position: 0px 0px; background-repeat: initial initial;"></td><td style="padding: 0px; border: none; margin: 0px; line-height: 0; font-size: 0px; background-image: url(http://yacht-fractions.co.uk/public/crolfe/highslide/graphics/outlines/custom.png); height: 28px; width: 28px; background-position: 0px -56px; background-repeat: initial initial;"></td><td style="padding: 0px; border: none; margin: 0px; line-height: 0; font-size: 0px; background-image: url(http://yacht-fractions.co.uk/public/crolfe/highslide/graphics/outlines/custom.png); height: 28px; width: 28px; background-position: -28px 0px; background-repeat: initial initial;"></td></tr><tr style="padding: 0px; border: none; margin: 0px; height: auto;"><td style="padding: 0px; border: none; margin: 0px; line-height: 0; font-size: 0px; background-image: url(http://yacht-fractions.co.uk/public/crolfe/highslide/graphics/outlines/custom.png); height: 28px; width: 28px; background-position: 0px -112px; background-repeat: initial initial;"></td><td style="padding: 0px; border: none; margin: 0px; position: relative;" class="custom highslide-outline"></td><td style="padding: 0px; border: none; margin: 0px; line-height: 0; font-size: 0px; background-image: url(http://yacht-fractions.co.uk/public/crolfe/highslide/graphics/outlines/custom.png); height: 28px; width: 28px; background-position: -28px -112px; background-repeat: initial initial;"></td></tr><tr style="padding: 0px; border: none; margin: 0px; height: auto;"><td style="padding: 0px; border: none; margin: 0px; line-height: 0; font-size: 0px; background-image: url(http://yacht-fractions.co.uk/public/crolfe/highslide/graphics/outlines/custom.png); height: 28px; width: 28px; background-position: 0px -28px; background-repeat: initial initial;"></td><td style="padding: 0px; border: none; margin: 0px; line-height: 0; font-size: 0px; background-image: url(http://yacht-fractions.co.uk/public/crolfe/highslide/graphics/outlines/custom.png); height: 28px; width: 28px; background-position: 0px -84px; background-repeat: initial initial;"></td><td style="padding: 0px; border: none; margin: 0px; line-height: 0; font-size: 0px; background-image: url(http://yacht-fractions.co.uk/public/crolfe/highslide/graphics/outlines/custom.png); height: 28px; width: 28px; background-position: -28px -28px; background-repeat: initial initial;"></td></tr></tbody></table></div><div id="window-resizer-tooltip" style="display: block;"><a href="http://yacht-fractions.co.uk/public/crolfe/aquila2.htm#" title="Edit settings" style="background-image: url(chrome-extension://kkelicaakdanhinjdeammmilcgefonfh/images/icon_19.png);"></a><span class="tooltipTitle">Window size: </span><span class="tooltipWidth" id="winWidth">1920</span> x <span class="tooltipHeight" id="winHeight">1055</span><br><span class="tooltipTitle">Viewport size: </span><span class="tooltipWidth" id="vpWidth">1920</span> x <span class="tooltipHeight" id="vpHeight">946</span></div></body><style type="text/css"></style>
</html>
