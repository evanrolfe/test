<?= render('buyer/_nav', array('buyer' => $buyer)); ?>
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
					<form action="<?= Uri::create('buyer/search/'.$buyer->id); ?>" method="POST" accept-charset="utf-8">
					<input type="hidden" name="filter" value="1" />
					<div class="formRow">
						<div class="grid3"><label>Type:</label></div>
						<div class="grid9 noSearch" align="left">
							<select class='select' name='type' onchange="show_search()" style="width: 175px;">
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
									<option value="<?=$loc;?>" <? if($search_terms['location_specific'] == $loc): ?>selected="selected"<? endif; ?>><?=$loc;?></option>
								<? endforeach; ?>
							</select>			
						</div>
						<div class="clear"></div>
					</div>

					<div class="formRow">
						<div class="grid3"><label>Price:</label></div>
						<div class="grid9">Min: <input type='text' name='min_budget' style="width: 70px;" value="<?=$search_terms['min_budget'];?>" onkeyup="show_search()"/> Max: <input type='text' name='max_budget'  style="width: 70px;" value="<?=$search_terms['max_budget'];?>" onkeyup="show_search()"/></div>
						<div class="clear"></div>
					</div>

					<div class="formRow">
						<div class="grid3"><label>LOA:</label></div>
						<div class="grid9">Min: <input type='text' name='min_loa' style="width: 40px;" value="<?=$search_terms['min_loa'];?>" onkeyup="show_search()"/> Max: <input type='text' name='max_loa'  style="width: 40px;" value="<?=$search_terms['max_loa'];?>" onkeyup="show_search()"/></div>
						<div class="clear"></div>
					</div>

					<div class="formRow">
						<div class="grid3"><label>Share size between:</label></div>
						<div class="grid9">Min: <input type='text' name='min_share_size' class="maskFraction" style="width: 40px;" value="<?=$search_terms['min_share_size'];?>" onkeyup="show_search()"/> Max: <input type='text' name='max_share_size'  style="width: 40px;" class="maskFraction" value="<?=$search_terms['max_share_size'];?>" onkeyup="show_search()"/></div>
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
    </div>	
</div>

<form action="<?= Uri::create('email/buyer/'.$buyer->id); ?>" method="POST" accept-charset="utf-8">
<div class="widget">
    <div class="whead">
		<div>
			<h6>Yacht Shares</h6>
		</div>
		<div style='text-align: right'>
			<button id="email_button" class="buttonS bBlue" style="margin: 6px 6px; display: none;"><span class="icon-email"></span><span>Email to Buyer</span></button></a>
		</div>
		<div class="clear"></div>
	</div>

    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault" id="resize2">
<?php if ($yachtshares): ?>
        <thead>
            <tr>
                <td class="sortCol" width="175px"><div>Boat Name<span></span></div></td>
                <td class="sortCol"><div class="tipN" title="The buyer: <?= $buyer->name; ?> has specifically marked an interested in the boat">Interest?<span></span></div></td>
                <td class="sortCol"><div>Location General<span></span></div></td>
                <td class="sortCol" width="175px"><div>Location Specific<span></span></div></td>
                <td class="sortCol"><div>Length<span></span></div></td>
                <td class="sortCol"><div>Price<span></span></div></td>
                <td class="sortCol"><div>Share Size<span></span></div></td>
				<td class="sortCol">Status</td>
				<td class="sortCol">Introduce</td>
            </tr>
        </thead>
        <tbody>
	<?php foreach ($yachtshares as $yachtshare): 
		$interest = (in_array($yachtshare->id, $buyer->preferences['interested'])); ?>
	        <tr class="boat" <? if($interest): ?>style="background-color: #FFCCCC;"<? endif; ?>>
	            <td class="boatname"><a href="<?= Uri::create('yachtshare/view/'.$yachtshare->id); ?>"><?= $yachtshare->name; ?></a></td>
	            <td class="boatname tipN" ><? if($interest): ?>Yes<? endif; ?></td>
	            <td><?= $yachtshare->location_general; ?></td>
	            <td><?= $yachtshare->location_specific; ?></td>
	            <td><?= $yachtshare->length; ?></td>
	            <td><?= $yachtshare->price; ?></td>
	            <td><?= $yachtshare->share_size; ?></td>
	            <td><?= $yachtshare->status(); ?></td>
	            <td><? if($yachtshare->status() == 'On hold'): ?>On hold<? else: ?><a href="<?= Uri::create('actionstep/create/'.$yachtshare->id.'/'.$buyer->id.'/introduction'); ?>">Introduce</a><? endif; ?></td>
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
</form>
