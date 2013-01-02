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
							<a href="<?=Uri::create('front');?>">&nbsp;</a>
						</div>
						<hr>
	                </div>
	        <form method="POST" action="<?=Uri::create('front');?>" id="form">
					<div class="sort">
							Location:
								<select name="location" onchange="form.submit()">
									<option value="">Any</option>
									<? foreach($locations as $loc): ?>
										<option value="<?=$loc;?>" <?if($selected_location==$loc):?>selected="yes"<?endif;?>><?=$loc;?></option>
									<? endforeach; ?>
								</select>,

							Type:
								<select name="type" onchange="form.submit()">
									<option value="">Any</option>
									<? foreach($types as $type): ?>
										<option value="<?=$type;?>" <?if($selected_type==$type):?>selected="yes"<?endif;?>><?=$type;?></option>
									<? endforeach; ?>
								</select>								
					</div>

					<div class="sort">

					</div>					

<script type="text/javascript">
function sort_by(col)
{
	$('.sort_button').val('');
	$('#'+col).val('1');
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
									<a href="<?=Uri::create('front/yachtshare/'.$yachtshare->id);?>" class="more"><?=$yachtshare->name;?></a>

									<? if(in_array($yachtshare->id, $newest_ids)): ?>
										<font color="red">New!</font>
									<? endif; ?>
								</div>

								<div class="thumbs_img">
									<? if(file_exists(Uri::create('public/uploads/'.$yachtshare->get_header_image_url()))): ?>
									<a href="<?=Uri::create('front/yachtshare/'.$yachtshare->id);?>">
										<img class="float_left" src="<?=('http://yacht-fractions.co.uk/public/uploads/'.$yachtshare->get_header_image_url());?>" alt="">
									</a>
									<? else: ?>
										No image available.
									<? endif; ?>
								</div>

								<div class="caption">
										<p>
											<span><strong>LOA: </strong><?=$yachtshare->length;?> m</span> 
											<span><strong>Price: </strong>£<?=$yachtshare->price;?></span>
											<span><strong>Share Size: </strong><?=$yachtshare->share_size_num;?>/<?=$yachtshare->share_size_den;?></span>
											<span><strong>Location: </strong><?=$yachtshare->location_specific;?></span>
											<span><strong>Date added: </strong><?=Date::forge($yachtshare->created_at)->format("%d/%m/%Y");?></span>
										</p>
										<p>
											<strong>Details: </strong><?=$yachtshare->boat_details['teaser'];?>
										</p>
										<p><span class=""><a href="<?=Uri::create('front/yachtshare/'.$yachtshare->id);?>" class="m_details">MORE DETAILS »</a></span>
									</p>
								</div>
														
							</div>
							<? endforeach; ?>
						<? else: ?>
						No yachtshares were found, try changing the search parameters.
						<? endif;?>
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