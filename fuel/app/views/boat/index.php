<script type="text/javascript">
function search_for()
{
	var re = new RegExp($("#search").val(),"i");

	$("tr.boat").each(function(i, tr) {
		name = $(this).find(".boatname").html();
		
		if($("#search").val() == ""){
			$(this).show();

		}else if(name.search(re) == -1){
			$(this).hide();

		}else{
			$(this).show();
		}
	});	
}
</script>
	<div class="widget searchWidget noBorderB" style="width: 270px;">
		<div class="whead" style="width: 248px;">
		    <input type="text" name="srch" class="" placeholder="Search..." style="width: 217px;" id="search" onkeyup="search_for()">
		    <button type="submit" name="swSubmit"><span class="icos-search"></span></button>
		</div>
	</div>


<div id="test"></div>
<div class="widget">
    <div class="whead">
		<div>
			<h6>Listing Boats</h6>
		</div>
		<div style='text-align: right'>
			<a href="<?= Uri::create('boat/create'); ?>"><button class="buttonS bBlue" style="margin: 6px 6px;"><span class="icon-add"></span><span>New</span></button></a>
		</div>
		<div class="clear"></div>
	</div>

    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault" id="resize2">
<?php if ($boats): ?>
        <thead>
            <tr>
                <td class="sortCol" width="225px"><div>Boat Name<span></span></div></td>
                <td class="sortCol" width="225px"><div>Area<span></span></div></td>
                <td class="sortCol" width="225px"><div>Location<span></span></div></td>
                <td class="sortCol"><div>Shares Purchased<span></span></div></td>
                <td class="sortCol"><div>Shares Total<span></span></div></td>
                <td class="sortCol"><div>#Introductions<span></span></div></td>
            </tr>
        </thead>
        <tbody>
	<?php foreach ($boats as $boat): ?>
	        <tr class="boat">
	            <td class="boatname"><a href="<?= Uri::create('boat/view/'.$boat->id); ?>"><?= $boat->name; ?></a></td>
	            <td><?= $boat->location_general; ?></td>
	            <td><?= $boat->location_specific; ?></td>
	            <td>1</td>
	            <td>4</td>
	            <td><?= sizeof($boat->shares); ?></td>
	        </tr>
	<?php endforeach; ?>
<?php else: ?>
			<tr>
				<td>No boats available</td>
			</tr>
        </tbody>
<?php endif; ?>
    </table>
</div>
