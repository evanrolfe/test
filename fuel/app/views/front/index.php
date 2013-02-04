<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
	     <link rel="icon" href="<?=Uri::create('public/assets/images/favicon.ico');?>" type="image/x-icon" />
		<link rel="shortcut icon" href="<?=Uri::create('public/assets/images/favicon.ico');?>" />
		<title>Yacht Fractions - Fractional Yacht Ownership</title>
		<meta name="description" content="Learn more about yacht sharing through fractional yacht ownership." />
		<meta name="keywords" content="fractional yacht ownership, boat shares, yacht sharing" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?=Uri::create('public/assets/front/layout_en.css');?>" />
        <link rel="stylesheet" type="text/css" href="<?=Uri::create('public/assets/front/jquery.fancybox-1.2.5.css');?>" />
        <link rel="stylesheet" type="text/css" href="<?=Uri::create('public/assets/front/menu.css');?>" />
		<script type="text/javascript" src="<?=Uri::create('public/assets/front/jquery-1.3.2.min.js');?>"></script>
        <script type="text/javascript" src="<?=Uri::create('public/assets/front/jquery.fancybox-1.2.5.pack.js');?>"></script>
        <script type="text/javascript" src="<?=Uri::create('public/assets/front/functions.js');?>"></script>
    </head>
<body>
<div id="wrapper1">
	<div id="page_wrapper">
		<div id="page" class="clearfix">			 
				<div id="content" class="clearfix">
					<div id="header" style="height:150px; margin-bottom: 10px;">
						<p>&nbsp;</p>
						<div align="left">
						  <p><a href="http://www.yachtfractions.co.uk"><img src="<?=Uri::create('public/assets/images/logo.gif');?>" alt="logo" vspace="22" /></a> </p>          
						<hr>
						</div>

	                </div>

	                <? if(isset($heading)): ?>
					<div class="sort">
						<h2><?=$heading;?></h2>
					</div>
					<? endif; ?>

			<? if(isset($heading)): ?>
	        	<form method="POST" action="<?=Uri::create('search/type/'.$type_url);?>" id="form">			
	        <? else: ?>
	        	<form method="POST" action="<?=Uri::create('search');?>" id="form">	        
	   	 	<? endif; ?>
	   	 			<input type="hidden" name="show_all" value="<?=$show_all;?>">
					<div class="sort">
							Location:
								<select name="filter_location" onchange="form.submit()">

									<? if(isset($heading)): ?>
										<option value="">Any</option>
										<? foreach($locations as $loc): ?>

											<option value="<?=$loc;?>" <?if($selected_location==$loc):?>selected="yes"<?endif;?>><?=$loc;?></option>

										<? endforeach; ?>

									<? else: ?>
											<option value="">Any</option>
											<option value="">============</option>																		
											<option value="">General Area</option>
											<option value="">============</option>									
										<? foreach($loc_general as $loc): ?>
											<option value="<?=$loc;?>" <?if($selected_location==$loc):?>selected="yes"<?endif;?>><?=$loc;?></option>
										<? endforeach; ?>
											<option value="">============</option>																		
											<option value="">Specific Area</option>
											<option value="">============</option>
										<? foreach($loc_specific as $loc): ?>
											<option value="<?=$loc;?>" <?if($selected_location==$loc):?>selected="yes"<?endif;?>><?=$loc;?></option>
										<? endforeach; ?>
									<? endif; ?>								
								</select>

						<? if(!isset($heading)): ?>

							, Type:
								<select name="type" onchange="form.submit()">
									<option value="">Any</option>
									<? foreach($types as $type): ?>
										<option value="<?=$type;?>" <?if($selected_type==$type):?>selected="yes"<?endif;?>><?=$type;?></option>
									<? endforeach; ?>
								</select>
						<? endif; ?>															
					</div>
					

<script type="text/javascript">
function sort_by(col)
{
	$('.sort_button').val('');
	$('#'+col).val('1');
	$('#form').submit();
}

function show_all()
{
	$("input[name=show_all]").val("1");
	$('#form').submit();
}
</script>

					<div class='sort'>Sort by:
						<? foreach($sort_options as $op): ?>
						<input type="hidden" name="<?=$op[1];?>" id="<?=$op[1];?>" class="sort_button" value="<?=$op[3];?>">
							<a class='flex <?=$op[2];?>' href="#" onclick="sort_by('<?=$op[1];?>');"><em><?=$op[0];?></em></a>
						<? endforeach;?>
					</div>
					</form>

					<div class='inner_cont'>
						<? if(count($yachtshares)>0): ?>
							<? foreach($yachtshares as $yachtshare): ?>
							<div class="thumbs_cont">
								<div class="details">
									<a href="<?=Uri::create('search/yachtshare/'.$yachtshare->id);?>" class="more"><?=$yachtshare->name;?> - <?=$yachtshare->make;?></a>

									<? if($yachtshare->is_newly_listed()): ?>
										<font color="red">Newly listed!</font>
									<? endif; ?>
								</div>

								<div class="thumbs_img">
									<? if($yachtshare->get_header_image_url() and file_exists(DOCROOT.'uploads/'.$yachtshare->get_header_image_url())): ?>
									<a href="<?=Uri::create('search/yachtshare/'.$yachtshare->id);?>">
										<img class="float_left" src="<?=Uri::create('public/uploads/'.$yachtshare->get_header_image_url());?>" alt="">
									</a>
									<? endif; ?>
								</div>

								<div class="caption">
										<p>
											<span><strong>LOA: </strong><?=$yachtshare->length;?> m</span> 
											<span><strong>Price: </strong>£<?=$yachtshare->price;?></span>
											<span><strong>Share Size: </strong><?=$yachtshare->share_size_num;?>/<?=$yachtshare->share_size_den;?></span>
											<span><strong>Location: </strong><?=$yachtshare->location_specific;?></span>
										</p>
										<p>
											<strong>Details: </strong><?=$yachtshare->boat_details['teaser'];?>
										</p>
										<p><span class=""><a href="<?=Uri::create('search/yachtshare/'.$yachtshare->id);?>" class="m_details">MORE DETAILS »</a></span>
									</p>
								</div>
														
							</div>
							<? endforeach; ?>
						<? else: ?>
						No yachtshares were found, try changing the search parameters.
						<? endif;?>

						<? if($show_all!=1): ?>
							<div align="center">
								<a href="#" onclick="show_all()"> >>> View all yacht shares >>> </a>
							</div>
						<? endif; ?>
					</div>

				</div><!--content-->
							
           		<div id="footer">
					<div id="footer_content">
						Developed by <a href='http://evanrolfe.info'>Evan Rolfe</a>.
	<br>
						Chris Hawes, Yacht Fractions Ltd., PO Box 196, Falmouth, Cornwall. TR11 5WD Tel: 01326 374435 Fax 01326 374625 Email chris@yachtfractions.co.uk
					</div>
				</div><!--footer-->	
			</div><!--page-->
	</div><!--page_wrapper-->
</div><!--wrapper1-->
</body>
</html>