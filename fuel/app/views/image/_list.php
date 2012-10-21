<div class="gallery">
		<? if(sizeof($images) > 0): ?>
		<ul>
			<? foreach($images as $image): ?>
			<li><a href="<?= Uri::create('public/uploads/'.$image->url); ?>" title="" class="lightbox"><img src="<?= Uri::create('public/uploads/'.$image->url); ?>" alt="" width='150px' height='110px'></a>
			</li>
			<? endforeach; ?>
		</ul> 
		<? else: ?>
			<div style='margin-top:7px;'>No images have been uploaded for this boat.</div>
		<? endif; ?>
</div>
