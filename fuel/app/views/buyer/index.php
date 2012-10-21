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
	$("#menu").easytabs();

	//$("#filter_form").validate();
});
</script>

<? if(isset($yachtshare)): ?>
	<?= render('yachtshare/admin/_nav', array('yachtshare' => $yachtshare)); ?>
<? endif; ?>

<div class="widget fluid">       
    <ul class="tabs">
        <li class="activeTab" style=""><a href="#tabb1">Filter</a></li>
        <li class=""><a href="#tabb2">Search</a></li>
        <li class=""><a href="#tabb3">Select Columns</a></li>
    </ul>
    
    <div class="tab_container" style="position: relative;">
				<div id="tabb1" class="tab_content" style="display: none; ">
					<form action="<?= Uri::create($current_page); ?>" method="POST" accept-charset="utf-8" id="filter_form">
					<input type="hidden" name="filter" value="1" />

					<?= render('forms/_dropdown',array('field'=>$type,'value' => $search_terms['type'], 'width'=>175),false); ?>

					<?= render('forms/_dropdown',array('field'=>$location_general,'value' => $search_terms['location_general'], 'width'=>175),false); ?>

					<?= render('forms/_dropdown',array('field'=>$location_specific,'value' => $search_terms['location_specific'], 'width'=>175),false); ?>

					<div class="formRow">
						<div class="grid3"><label>Price:</label></div>
						<div class="grid9"><input type='text' name='price' style="width: 70px;" value="<?=$search_terms['price'];?>" /></div>
						<div class="clear"></div>
					</div>

					<div class="formRow">
						<div class="grid3"><label>Length:</label></div>
						<div class="grid9"><input type='text' name='length' style="width: 70px;" value="<?=$search_terms['length'];?>" /></div>
						<div class="clear"></div>
					</div>

					<div class="formRow">
						<div class="grid3"><label>Share size:</label></div>
						<div class="grid9 noSearch" align="left">
							<input type='text' name="share_size_num" style='width: 45px;' value="<?=$search_terms['share_size_num'];?>" /> / <input type='text' name="share_size_den" style='width: 45px;' value="<?=$search_terms['share_size_den'];?>" />
						<br>
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
							<input type="text" name="srch" class="" placeholder="Search..." style="width: 217px;" id="search" onkeyup="search_for()">
							<button type="submit" name="swSubmit"><span class="icos-search"></span></button>
						</div>
					</div>

				</div>

				<div id="tabb3" class="tab_content" style="display: block; ">
					<form action="<?= Uri::create($current_page); ?>" method="POST" accept-charset="utf-8">
					<input type="hidden" name="column" value="1" />
					<div class="formRow">
						<div class="grid3">
							<input type="checkbox" name="name" <? if(in_array('name',$columns)): ?>checked="yes"<? endif; ?> /> Name<br>
							<input type="checkbox" name="email" <? if(in_array('email',$columns)): ?>checked="yes"<? endif; ?> /> Email<br>
							<input type="checkbox" name="location_general" <? if(in_array('location_general',$columns)): ?>checked="yes"<? endif; ?> /> Location (general)<br>
							<input type="checkbox" name="location_specific" <? if(in_array('location_specific',$columns)): ?>checked="yes"<? endif; ?> /> Location (specific)<br>
							<input type="checkbox" name="type" <? if(in_array('type',$columns)): ?>checked="yes"<? endif; ?> /> Type<br>
							<input type="checkbox" name="num_introductions" <? if(in_array('num_introductions',$columns)): ?>checked="yes"<? endif; ?> /> # Introductions<br>
							<input type="checkbox" name="price_range" <? if(in_array('price_range',$columns)): ?>checked="yes"<? endif; ?> /> Price Range<br>
							<input type="checkbox" name="length_range" <? if(in_array('length_range',$columns)): ?>checked="yes"<? endif; ?> /> Length Range<br>
							<input type="checkbox" name="share_size_range" <? if(in_array('share_size_range',$columns)): ?>checked="yes"<? endif; ?> /> Share Size Range<br>
							<input type="checkbox" name="sale_progress" <? if(in_array('sale_progress',$columns)): ?>checked="yes"<? endif; ?> />Sale Progress
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
			<h6>Listing Buyers</h6>
		</div>
		<div style='text-align: right'>
			<a href="<?= Uri::create('buyer/create'); ?>"><button class="buttonS bBlue" style="margin: 6px 6px;"><span class="icon-add"></span><span>New</span></button></a>
		</div>
		<div class="clear"></div>
	</div>

    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault" id="resize2">
<?php if ($buyers): ?>
        <thead>
            <tr>
				<? foreach($columns as $col): ?>
                	<td class="sortCol"><div><?=$column_labels[$col];?><span></span></div></td>					
				<? endforeach; ?>

				<? if(isset($yachtshare)): ?>
					<td class="sortCol"><div>Introduce?</div></td>
				<? endif; ?>
            </tr>
        </thead>
        <tbody>
	<?php foreach ($buyers as $buyer): ?>
	        <tr class="boat">
				<? foreach($columns as $col): ?>
					<? if($col == 'name'): ?>

	            		<td class="boatname"><a href="<?=Uri::create('buyer/view/'.$buyer->id);?>"><?= $buyer->name; ?></a></td>

					<? elseif($col == 'email'): ?>

	            		<td><?= $buyer->email; ?></td>

					<? elseif($col == 'num_introductions'): ?>

	            		<td><?= $buyer->num_introductions(); ?></td>

					<? elseif($col == 'location_general'): ?>

						<td><?= $buyer->preferences['location_general']; ?></td>

					<? elseif($col == 'location_specific'): ?>

						<td><?= $buyer->preferences['location_specific']; ?></td>

					<? elseif($col == 'type'): ?>

						<td><?= $buyer->preferences['type']; ?></td>

					<? elseif($col == 'price_range'): ?>

	           			 <td><?= $buyer->preferences['min_budget']; ?> -> <?= $buyer->preferences['max_budget']; ?></td>

					<? elseif($col == 'length_range'): ?>

	            		<td><?= $buyer->preferences['min_loa']; ?> -> <?= $buyer->preferences['max_loa']; ?></td>

					<? elseif($col == 'share_size_range'): ?>

			            <td><?= $buyer->preferences['min_share_size_fraction']; ?> -> <?= $buyer->preferences['max_share_size_fraction']; ?></td>

					<? elseif($col == 'sale_progress'): ?>
							<td>
							<? foreach($buyer->yachtshares(true) as $b): ?>
						<ul  class="ui-progressbar ui-widget ui-widget-content ui-corner-all" ><? foreach($b->actionsteps as $actionstep): ?><? $width = 10; ?><li title="<?= $actionstep->title; ?><br>Buyer:<?=$b->name;?><br><?= Date::forge($actionstep->occurred_at)->format('%d %b %Y'); ?>" class="tipN ui-progressbar-value ui-widget-header ui-corner-left" style="margin-left: 0; width: <?= $width; ?>%; " original-title="hello world"></li><? endforeach; ?></ul>
							<? endforeach; ?>
							</td>
					<? endif; ?>
				<? endforeach; ?>

				<? if(isset($yachtshare)): ?>
					<? if($buyer->already_introduced_to_yachtshare($yachtshare->id)): ?>
						<td>Already Introduced</td>
					<? else: ?>
						<td><a href="<?=Uri::create('actionstep/create/'.$yachtshare->id.'/'.$buyer->id.'/introduction/'.$from_page);?>">Introduce</a></td>
					<? endif; ?>
				<? endif; ?>
	        </tr>
	<?php endforeach; ?>
<?php else: ?>
			<tr>
				<td>No buyers available</td>
			</tr>
        </tbody>
<?php endif; ?>
    </table>
</div>
