<div class="container">
	<div class="card">
		<img class="card-img-top" src="http://via.placeholder.com/800x300" alt="placeholder">
		<div class="card-body">
			<h3><?php echo $restaurant['name']; ?> 
				<small class="text-muted">(<?php 
					if (empty($restaurant['rating'])) 
					{
						echo 'No ratings yet';
					}
					else
					{
						echo $restaurant['rating'];
						echo '/5'; 
					}
					?>)</small></h3>
			<p class="card-text">
				<?php 
				if (empty($restaurant['addr_1'])) 
				{ 
					echo "No address (yet)"; 
				} 
				else 
				{ 
					echo $restaurant['addr_1'];  
				} 
				echo ', ';
				echo $restaurant['city']; 
				if (!empty($restaurant['state_prov_code'])) 
				{ 
					echo ', '; echo $restaurant['state_prov_code']; 
				} 
				echo ', ';
				echo $restaurant['country'];
				?>
			</p>
			<p class="card-text" id="tags-list">
			<?php if (!empty($restaurant['tags'])): ?>
				<?php foreach($restaurant['tags'] as $tag): ?>
					<span class="badge badge-pill badge-primary"><?php echo $tag['name']; ?> <a href="#" class="remove_tag_button" data-tag_id="<?php echo $tag['id']; ?>" data-restaurant_id="<?php echo $restaurant['id']; ?>">&times;</a></span>
				<?php endforeach; ?>
			<?php else: ?>
				<p>No tags.</p>
			<?php endif; ?>
			</p>
			<a href="#" class="btn btn-primary">Reviews</a>
			<a href="<?php echo site_url('/restaurants/edit/'.$restaurant['id']); ?>" class="btn btn-secondary">Edit</a>
			<a class="btn btn-outline-primary" href="/restaurants">Restaurant List</a>
			<hr />
			<blockquote class="blockquote text-center">
				<p class="mb-0">I enjoyed consuming things here.</p>
				<footer class="blockquote-footer">Cthulu in <cite title="Diner's Choice">Diner's Choice</cite></footer>
			</blockquote>
			<blockquote class="blockquote text-center">
				<p class="mb-0">Great selection, would visit again.</p>
				<footer class="blockquote-footer">Merlin in <cite title="Food Weekly">Food Weekly</cite></footer>
			</blockquote>
		</div>
	</div>
</div>