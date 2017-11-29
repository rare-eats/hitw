<div class="container">
	<div class="card">		
		<div class="card-body">
			<div class="clearfix">
				<a class="btn btn-secondary float-right" aria-label="Return to Restaurant List" href="/restaurants">&times;</a>
			<h2><?php echo $restaurant['name']; ?>
				<small class="text-muted">(<?php if (empty($restaurant['rating'])) 
				{
					echo 'No ratings yet';
				}
				else
				{
					echo ($restaurant['rating'].'/5');
				}
				?>)</small>
			</h2>
			</div>
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
					<span class="badge badge-pill badge-primary"><?php echo $tag['name']; ?>
					<?php if($admin): ?> 
						<a href="#" class="remove_tag_button" data-tag_id="<?php echo $tag['id']; ?>" data-restaurant_id="<?php echo $restaurant['id']; ?>">&times;</a>
					<?php endif; ?></span>
				<?php endforeach; ?>
			<?php else: ?>
				<p>No tags.</p>
			<?php endif; ?>
			</p>
		<?php if($admin): ?>
			<a href="<?php echo site_url('/restaurants/edit/'.$restaurant['id']); ?>" class="btn btn-primary">Edit</a>
		<?php endif; ?>
		</div>

		<div id="image_carousel" class="carousel slide" data-ride="carousel">
			<?php if(empty($photos)): ?>
				<img src="http://via.placeholder.com/800x300" alt="Placeholder">
			<?php else: ?>
			<ol class="carousel-indicators">
				<?php for($i = 0; $i < count($photos); $i++): ?>
				<li data-target="#image_carousel" data-slide-to="<?php echo $i; ?>" 
					<?php if($i == 0) {echo 'class="active"'; }; ?>></li>
				<?php endfor; ?>
			</ol>
			<div class="carousel-inner">
			<?php for($i = 0; $i < count($photos); $i++): ?>
				<div class="carousel-item w-100 <?php if($i == 0) echo 'active'; ?>">
					<img class="d-block align-middle w-100" src="<?php echo $photos[$i]['image_url']; ?>" alt="Slide <?php echo $i+1; ?>">
				</div>
			<?php endfor; ?>
 			</div>
			<a class="carousel-control-prev" href="#image_carousel" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#image_carousel" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a> 
			<?php endif; ?>
		</div>





		<div class="card-body">
			<h3 class="card-title text-center">User Reviews</h3>
			<?php if(!empty($reviews)): ?>
				<div class="container-fluid">
					<?php foreach($reviews as $review): ?>
						<div class="row <?php 
							if($review['author_id'] == $user_id) {echo 'own-review';}; 
						?>">
							<div class="col-md-10 col-sm-12">
								<blockquote class="blockquote">
									<?php if(($review['author_id'] == $user_id) || ($admin)): ?>
										<p id="show-review" style="display: block"> <?php echo $review['body']; ?> </p>
										<form id="edit-form" class="edit-form" style="display:none" action="/restaurants/<?php echo $restaurant_id; ?>/review/put" method="post" accept-charset="utf-8">
											<input id="edit-field" name="body" class="form_control" value="<?php echo $review['body']; ?>">
											<button id = "submit-edit-btn" type="submit" class = "btn btn-primary">Submit</button>
										</form>
									<?php else: ?>
										 <p> <?php echo $review['body']; ?> </p>
									<?php endif; ?>
									<footer class="blockquote-footer"><?php echo $review['first_name']." ".$review['last_name'];?></footer>
								</blockquote>
							</div>
							<?php if(($review['author_id'] == $user_id) || ($admin)): ?>
							<div class='btn-group col-md-2 col-sm-12 justify-content-end align-items-center'>
								<form class="edit_reviews" action="/restaurants/<?php echo $restaurant_id; ?>/review/<?php echo $review['id']; ?>/put" method="post">
									<button id="edit-btn" type="button" class="btn btn-secondary edit_reviews" style="margin-right:5px">Edit</button>
								</form>
								<form action="/restaurants/<?php echo $restaurant_id; ?>/review/<?php echo $review['id']; ?>/delete" method="post">
									<button type="submit" class="btn btn-danger">&times;</button>
								</form>
							</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if(empty($user_id)): ?>
				<p class="text-center"><a href="/users/login">Log in to leave a review.</a></p>
			<?php elseif(empty($reviews) || (isset($user_left_review) && $user_left_review < 1) ): ?>
				<p class="text-center">Let your voice be heard, leave a review now!</p>
					<form action="/restaurants/<?php echo $restaurant_id; ?>/review/put" method="post" accept-charset="utf-8">
						<div class="form-group">
							<input type="text" id="body" name="body" class="form-control" placeholder="What did you think of this location?" value="<?php empty($user_review) || empty($user_review['body']) ? "" : html_escape($user_review['body']); ?>">
						</div>
						<button type="submit" class="btn btn-primary">Submit</button>
					</form>
			<?php endif; ?>
			<!-- End user reviews and recommendations -->
		</div>
	</div>
</div>
