<div class="container">
	<div class="card">
		<img class="card-img-top" src="http://via.placeholder.com/600x200" alt="placeholder">
		<div class="card-body">
			<h3><?php echo $restaurant['name']; ?> 
				<small class="text-muted">(<?php echo $restaurant['rating']; ?>/5)</small></h3>
			<?php /* Address Line follows, maybe we should fix it later */ ?>
			<p class="card-text"><?php if (empty($restaurant['addr1'])) { echo "No address (yet). " } else { echo $restaurant['addr1']; echo ', '; } ?><?php if (! empty($restaurant['addr2'])) { echo $restaurant['addr2']; echo ', '; } ?><?php echo $restaurant['city']; ?><?php if (! empty($restaurant['state-prov-code'])) { echo ', '; echo $restaurant['state-prov-code']; } ?></p>
			<a href="#" class="btn btn-primary">Reviews</a>
			<a href="<?php echo site_url('restaurants/edit'.$restaurant['id']); ?>" class="btn btn-secondary">Edit</a>
		</div>
	</div>
	
</div>