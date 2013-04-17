<script type="text/javascript">
function search_for()
{
	var re = new RegExp($("#search").val(),"i");

	$("tr.boat").each(function(i, tr) {
		name = $(this).find(".boatname").html();
		
		//alert("Table Value: "+name+"\nSearch regex: "+re+"\n\nResult: "+name.search(re));

		if($("#search").val() == ""){
			$(this).show();

		}else if(name.search(re) == -1){
			$(this).hide();

		}else{
			$(this).show();
		}
	});	
}

function show_search()
{
	$("#search_button").show();
}

$(function(){
	$("#search_form").hide();
});
</script>

<? if(isset($buyer)): ?>
	<?= render('buyer/_nav', array('buyer' => $buyer)); ?>
<? endif; ?>

<div class="widget fluid">       
    <ul class="tabs">
        <li class="activeTab" style=""><a href="#tabb1">Filter</a></li>
        <li class=""><a href="#tabb2">Search</a></li>
        <li class=""><a href="#tabb3">Select Columns</a></li>
    </ul>
    
    <div class="tab_container" style="position: relative;">
				<div id="tabb1" class="tab_content" style="display: none; ">
					<form action="<?= Uri::create($current_page); ?>" method="POST" accept-charset="utf-8">
					<input type="hidden" name="filter" value="1" />

					<?= render('forms/_dropdown',array('field'=>$type,'value' => $search_terms['type'], 'width'=>175),false); ?>

					<?= render('forms/_dropdown',array('field'=>$location_general,'value' => $search_terms['location_general'], 'width'=>175),false); ?>

					<?= render('forms/_dropdown',array('field'=>$location_specific,'value' => $search_terms['location_specific'], 'width'=>175),false); ?>

					<div class="formRow">
						<div class="grid3"><label>Price (£):</label></div>
						<div class="grid9">Min: <input type='text' name='min_budget' style="width: 70px;" value="<?=$search_terms['min_budget'];?>" onkeyup="show_search()"/> Max: <input type='text' name='max_budget'  style="width: 70px;" value="<?=$search_terms['max_budget'];?>" onkeyup="show_search()"/></div>
						<div class="clear"></div>
					</div>

					<div class="formRow">
						<div class="grid3"><label>LOA:</label></div>
						<div class="grid9">Min: <input type='text' name='min_loa' style="width: 40px;" value="<?=$search_terms['min_loa'];?>" onkeyup="show_search()"/> Max: <input type='text' name='max_loa'  style="width: 40px;" value="<?=$search_terms['max_loa'];?>" onkeyup="show_search()"/></div>
						<div class="clear"></div>
					</div>
		
					<div class="formRow">
						<div class="grid3"><label>Share size minimum:</label></div>
						<div class="grid9 noSearch" align="left">
							<input type='text' name="min_share_size_numerator" style='width: 45px;' value="<?=$search_terms['min_share_size_numerator'];?>" /> / <input type='text' name="min_share_size_denomenator" style='width: 45px;' value="<?=$search_terms['min_share_size_denomenator'];?>" />
						<br>
						</div>
						 <div class="clear"></div>
					</div>

					<div class="formRow">
						<div class="grid3"><label>Share size maximum:</label></div>
						<div class="grid9 noSearch" align="left">
							<input type='text' name="max_share_size_numerator" style='width: 45px;' value="<?=$search_terms['max_share_size_numerator'];?>" /> / <input type='text' name="max_share_size_denomenator" style='width: 45px;' value="<?=$search_terms['max_share_size_denomenator'];?>" />
						<br>
						</div>
						 <div class="clear"></div>
					</div>

					<div class="formRow">
						<div class="grid3"><label>Select Share with Status:</label></div>
						<div class="grid9">
							<input type="checkbox" name="available" <? if(isset($search_terms['available'])): ?>checked="yes"<? endif; ?>> Available<br>
							<input type="checkbox" name="sale_in_progress" <? if(isset($search_terms['sale_in_progress'])): ?>checked="yes"<? endif; ?>> Sale in progress<br>
							<input type="checkbox" name="on_hold" <? if(isset($search_terms['on_hold'])): ?>checked="yes"<? endif; ?>> On hold<br>
							<input type="checkbox" name="sold" <? if(isset($search_terms['sold'])): ?>checked="yes"<? endif; ?>> Sold<br>
							<input type="checkbox" name="deactivated" <? if(isset($search_terms['deactivated'])): ?>checked="yes"<? endif; ?>> Deactivated<br>
							<input type="checkbox" name="temp" <? if(isset($search_terms['temp'])): ?>checked="yes"<? endif; ?>>Unfinished Seller Listings<br>
						</div>
						<div class="clear"></div>
					</div>

					<div class="formRow" align="right">
						<button id="search_button" class="buttonS bBlue" style="margin: 3px 0px;" type="submit"><span class="icon-search"></span><span>Update Filter</span></button>
					</div>
	</form>
	</div>

				<div id="tabb2" class="tab_content" style="">

					<div class="widget searchWidget noBorderB" style="width: 270px; margin-top: 0px;">
						<div class="whead" style="width: 248px;">
							<input type="text" name="srch" class="" placeholder="Search..." style="width: 217px;" id="search" onkeyup="search_for();">
							<button type="submit" name="swSubmit"><span class="icos-search"></span></button>
						</div>
					</div>
				</div>

				<div id="tabb3" class="tab_content" style="display: block; ">
					<form action="<?= Uri::create($current_page); ?>" method="POST" accept-charset="utf-8">
					<input type="hidden" name="column" value="1" />
					<div class="formRow">
						<div class="grid3">
							<input type="checkbox" name="name" <? if(in_array('name',$columns)): ?>checked="yes"<? endif; ?> /> Boat name<br>
							<input type="checkbox" name="make" <? if(in_array('make',$columns)): ?>checked="yes"<? endif; ?> /> Boat make<br>
							<input type="checkbox" name="type" <? if(in_array('type',$columns)): ?>checked="yes"<? endif; ?> /> Type<br>
							<input type="checkbox" name="location_general" <? if(in_array('location_general',$columns)): ?>checked="yes"<? endif; ?> /> Location (general)<br>
							<input type="checkbox" name="location_specific" <? if(in_array('location_specific',$columns)): ?>checked="yes"<? endif; ?> /> Location (specific)<br>
							<input type="checkbox" name="length" <? if(in_array('length',$columns)): ?>checked="yes"<? endif; ?> /> Length<br>
							<input type="checkbox" name="price" <? if(in_array('price',$columns)): ?>checked="yes"<? endif; ?> /> Price<br>
							<input type="checkbox" name="share_size" <? if(in_array('share_size',$columns)): ?>checked="yes"<? endif; ?> /> Share size<br>
						</div>
						<div class="grid3" align="left">
							<input type="checkbox" name="introductions" <? if(in_array('introductions',$columns)): ?>checked="yes"<? endif; ?> /> # Introductions<br>
							<input type="checkbox" name="last_activity" <? if(in_array('last_activity',$columns)): ?>checked="yes"<? endif; ?> /> Date of last activity<br>
							<input type="checkbox" name="sale_progress" <? if(in_array('sale_progress',$columns)): ?>checked="yes"<? endif; ?> /> Sale progress bar<br>
							<input type="checkbox" name="status" <? if(in_array('status',$columns)): ?>checked="yes"<? endif; ?> />Status of Yachtshare<br>
							<input type="checkbox" name="seller_name" <? if(in_array('seller_name',$columns)): ?>checked="yes"<? endif; ?> />Seller's Name<br>
							<input type="checkbox" name="created_at" <? if(in_array('created_at',$columns)): ?>checked="yes"<? endif; ?> />Registration Date<br>

						</div>
						<div class="clear"></div>
					</div>

					<div class="formRow" align="right">
							<button id="search_button" class="buttonS bBlue" style="margin: 3px 0px;" type="submit"><span class="icon-search"></span><span>Update Columns</span></button>
						<div class="clear"></div>
					</div>
					</form>
				</div>
    </div>	
</div>


<div class="widget">
    <div class="whead">
		<div>
			<h6>Yacht Shares</h6>
		</div>
		<? if(isset($show_new_button)): ?>
		<div style='text-align: right'>
			<a href="<?= Uri::create('yachtshare/create'); ?>" class="buttonS bBlue" style="margin: 6px 6px; color: white;"><span class="icon-add"></span><span>New</span></a>
		</div>
		<? endif; ?>
		<div class="clear"></div>
	</div>

    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault" id="resize2">
<?php if ($yachtshares): ?>
        <thead>
            <tr>
				<? foreach($columns as $col): ?>
                <td class="sortCol"><div><?=$column_labels[$col];?><span></span></div></td>					
				<? endforeach; ?>

				<? if(isset($buyer)): ?>
					<td>Introduce?</td>
				<? endif; ?>
            </tr>
        </thead>
        <tbody>
	<?php foreach ($yachtshares as $yachtshare): ?>
	        <tr class="boat" <? if(isset($yachtshares_interest) and in_array($yachtshare->id, $yachtshares_interest)): ?>style="background-color: #729fcf;"<? endif; ?>>
				<? foreach($columns as $col): ?>
					<td class="boatname">
						<? if($col == 'introductions'): ?>

							<?= $yachtshare->num_introductions(); ?>

						<? elseif($col == 'name'): ?>

							<a href="<?= Uri::create('yachtshare/view/'.$yachtshare->id); ?>" <? if(isset($yachtshares_interest) and in_array($yachtshare->id, $yachtshares_interest)): ?>class="tipS" title="The buyer has marked a specific interest in this yachtshare."<? endif; ?>><?=$yachtshare->name;?></a>

						<? elseif($col == 'last_activity'): ?>

							<?= $yachtshare->date_last_activity(); ?>

						<? elseif($col == 'sale_progress'): ?>

							<? foreach($yachtshare->buyers(true) as $b): ?>
							<ul  class="ui-progressbar ui-widget ui-widget-content ui-corner-all" ><? foreach($b->actionsteps as $actionstep): ?><? $width = 10; ?><li title="<?= $actionstep->title; ?><br>Buyer:<?=$b->name;?><br><?= Date::forge($actionstep->occurred_at)->format('%d %b %Y'); ?>" class="tipN ui-progressbar-value ui-widget-header ui-corner-left" style="margin-left: 0; width: <?= $width; ?>%; " original-title="hello world"></li><? endforeach; ?></ul>
							<? endforeach; ?>

						<? elseif($col == 'status'): ?>

							<?= $yachtshare->status(); ?>

						<? elseif($col == 'share_size'): ?>

							<?=$yachtshare->boat_details['share_size_fraction']; ?>

						<? elseif($col == 'seller_name'): ?>

								<?=$yachtshare->boat_details['first_name']; ?> <?=$yachtshare->boat_details['seller_name']; ?>

						<? elseif($col == 'created_at'): ?>

							<?=Date::forge($yachtshare->created_at)->format("%d/%m/%Y"); ?>

						<? else: ?>

							<?=$yachtshare->$col;?>

						<? endif; ?>
					</td>
				<? endforeach; ?>

				<? if(isset($buyer)): ?>
					<? if($yachtshare->is_onhold()): ?>
						<td>On Hold</td>
					<? elseif($yachtshare->already_introduced_to_buyer($buyer->id)): ?>
						<td>Already Introduced</td>
					<? else: ?>
						<td><a href="<?=Uri::create('actionstep/create/'.$yachtshare->id.'/'.$buyer->id.'/introduction/'.$from_page);?>">Introduce</a></td>
					<? endif; ?>
				<? endif; ?>

	        </tr>
	<?php endforeach; ?>
<?php else: ?>
			<tr>
				<td>No yachtshares available</td>
			</tr>
        </tbody>
<?php endif; ?>
    </table>
</div>
