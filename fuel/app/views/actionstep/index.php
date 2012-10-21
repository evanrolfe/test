<h2>Listing Actionsteps</h2>
<br>
<?php if ($actionsteps): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Title</th>
			<th>Note</th>
			<th>Boat share id</th>
			<th>Buyer id</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($actionsteps as $actionstep): ?>		<tr>

			<td><?php echo $actionstep->title; ?></td>
			<td><?php echo $actionstep->note; ?></td>
			<td><?php echo $actionstep->boat_share_id; ?></td>
			<td><?php echo $actionstep->buyer_id; ?></td>
			<td>
				<?php echo Html::anchor('actionstep/view/'.$actionstep->id, 'View'); ?> |
				<?php echo Html::anchor('actionstep/edit/'.$actionstep->id, 'Edit'); ?> |
				<?php echo Html::anchor('actionstep/delete/'.$actionstep->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Actionsteps.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('actionstep/create', 'Add new Actionstep', array('class' => 'btn success')); ?>

</p>
