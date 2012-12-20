<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
	     <link rel="icon" href="http://sailfractions.co.uk/favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="http://sailfractions.co.uk/favicon.ico" />
		<title>Sail Fractions - Fractional Yacht Ownership</title>
		<meta name="description" content="Learn more about yacht sharing through fractional yacht ownership." />
		<meta name="keywords" content="fractional yacht ownership, boat shares, yacht sharing" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="http://sailfractions.co.uk/style/layout_en.css" />
        <link rel="stylesheet" type="text/css" href="http://sailfractions.co.uk/include/jquery/fancybox/jquery.fancybox-1.2.5.css" />
        <link rel="stylesheet" type="text/css" href="http://sailfractions.co.uk/style/menu.css" />
		<script type="text/javascript" src="http://sailfractions.co.uk/include/jquery/jquery-1.3.2.min.js"></script>
        <script type="text/javascript" src="http://sailfractions.co.uk/include/jquery/fancybox/jquery.fancybox-1.2.5.pack.js"></script>
        <script type="text/javascript" src="http://sailfractions.co.uk/include/js/functions.js"></script>
        </head>
<body>
<div id="wrapper1">
	<div id="page_wrapper">
		<div id="page" class="clearfix">			 
				<div id="content" class="clearfix">
					<div id="header">
						<div id="logo">
							<a href="http://sailfractions.co.uk/">&nbsp;</a>
						</div>
						<hr>
	                </div>


					<div class='inner_cont'>
						<? foreach($yachtshares as $yachtshare): ?>
						<div class="thumbs_cont">
							<div class="details">
								<a href="http://sailfractions.co.uk/boats/Alfin-del-Mundo" class="more"><?=$yachtshare->name;?></a>
							</div>

							<div class="thumbs_img">
								<a href="http://sailfractions.co.uk/boats/Alfin-del-Mundo" title="Alfin del Mundo">
									<img class="float_left" src="<?=('http://yacht-fractions.co.uk/public/uploads/'.$yachtshare->get_header_image_url());?>" alt="">
								</a>
							</div>

							<div class="caption">
								<p>
									<span><strong>LOA: </strong><?=$yachtshare->length;?> ft</span> 
									<span><strong>Price: </strong>£<?=$yachtshare->price;?></span>
									<span><strong>Share Size: </strong><?=$yachtshare->share_size_num;?>/<?=$yachtshare->share_size_den;?></span>
								</p>
									<p>
										<strong>Details: <?=$yachtshare->boat_details['teaser'];?></strong>
									</p>
									<p><span class=""><a href="<?=Uri::create('front/yachtshare/'.$yachtshare->id);?>" class="m_details">MORE DETAILS »</a></span>
								</p>
							</div>
													
						</div>
							<?=$yachtshare->name;?><br>
						<? endforeach; ?>
					</div>

				</div><!--content-->
							
           		<div id="footer">
					<div id="footer_content">
						Chris Hawes, Yacht Fractions Ltd., PO Box 196, Falmouth, Cornwall. TR11 5WD Tel: 01326 374435 Fax 01326 374625 Email chris@yachtfractions.co.uk
					</div>
				</div><!--footer-->	
			</div><!--page-->
	</div><!--page_wrapper-->
</div><!--wrapper1-->
</body>
</html>