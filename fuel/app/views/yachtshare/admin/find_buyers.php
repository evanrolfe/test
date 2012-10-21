<?= render('yachtshare/admin/_nav', array('yachtshare' => $yachtshare)); ?>

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
});
</script>

<div class="widget fluid">       
    <ul class="tabs">
        <li class="activeTab" style=""><a href="#tabb1">Filter</a></li>
        <li class=""><a href="#tabb2">Search</a></li>
    </ul>
    
    <div class="tab_container" style="position: relative;">
				<div id="tabb1" class="tab_content" style="display: none; ">
					<form action="<?= Uri::create('yachtshare/search/'.$yachtshare->id); ?>" method="POST" accept-charset="utf-8">
					<input type="hidden" name="filter" value="1" />
					<div class="formRow">
						<div class="grid3"><label>Type:</label></div>
						<div class="grid9 noSearch" align="left">
							<select class='select' name='type' onchange="show_search()" style="width: 175px;">
									<option value="">Select</option>
								<? foreach($types as $type): ?>
									<option value="<?=$type;?>" <? if($search_terms['type'] == $type): ?>selected="selected"<? endif; ?>><?=$type;?></option>
								<? endforeach; ?>
							</select>			
						</div>
						<div class="clear"></div>
					</div>

					<div class="formRow">
						<div class="grid3" align="left"><label>Location (General):</label></div>
						<div class="grid9 noSearch" align="left">
							<select class='select' name='location_general' onchange="show_search()" style="width: 175px;">
									<option value="">Select</option>
								<? foreach($location_general as $loc): ?>
									<option value="<?=$loc;?>" <? if($search_terms['location_general'] == $loc): ?>selected="selected"<? endif; ?>><?=$loc;?></option>
								<? endforeach; ?>
							</select>	
						</div>
						<div class="clear"></div>
					</div>

					<div class="formRow">
						<div class="grid3"><label>Location (Specific):</label></div>
						<div class="grid9 noSearch" align="left">
							<select class='select' name='location_specific' onchange="show_search()" style="width: 175px;">
								<option value="">Only search general area</option>
								<? foreach($location_specific as $loc): ?>
									<option value="<?=$loc;?>" <? if(strtolower($search_terms['location_specific']) == strtolower($loc)): ?>selected="selected"<? endif; ?>><?=$loc;?></option>
								<? endforeach; ?>
							</select>			
						</div>
						<div class="clear"></div>
					</div>

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
						<div class="grid9"><input type='text' name='share_size' style="width: 40px;" value="<?=$search_terms['share_size'];?>" /></div>
						<div class="clear"></div>
					</div>			

					<div class="formRow" align="right">
<a href="<?=Uri::create('buyer');?>"><button class="buttonS bGreen" style="margin: 3px 0px;" type="button">List All Buyers</button></a>
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
					<td>Introduce?</td>
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

			            <td><?= $buyer->preferences['min_share_size']; ?> -> <?= $buyer->preferences['max_share_size']; ?></td>
					<? else: ?>
						<td></td>
					<? endif; ?>
				<? endforeach; ?>
						<td><a href="<?=Uri::create('actionstep/create/'.$yachtshare->id.'/'.$buyer->id.'/introduction');?>">Introduce</a></td>
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
