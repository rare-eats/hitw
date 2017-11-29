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
			<form action="/restaurants/<?php echo $restaurant_id; ?>/review/leave_rating" method="post">
				<button type="button" class="btn btn-info btn-lg">
	          <span class="glyphicon glyphicon-thumbs-up"></span>
	      </button>
			</form>
			<?php if (!empty($restaurant['tags'])): ?>
				<?php foreach($restaurant['tags'] as $tag): ?>
					<span class="badge badge-pill badge-primary"><?php echo $tag['name']; ?> <a href="#" class="remove_tag_button" data-tag_id="<?php echo $tag['id']; ?>" data-restaurant_id="<?php echo $restaurant['id']; ?>">&times;</a></span>
				<?php endforeach; ?>
			<?php else: ?>
				<p>No tags.</p>
			<?php endif; ?>
			</p>
			<a href="<?php echo site_url('/restaurants/edit/'.$restaurant['id']); ?>" class="btn btn-secondary">Edit</a>
			<hr />

			<p class="card-text text-center">
				Critic Reviews
			</p>
			<blockquote class="blockquote text-center">
				<p class="mb-0">I enjoyed consuming things here.</p>
				<footer class="blockquote-footer">Cthulu in <cite title="Diner's Choice">Diner's Choice</cite></footer>
			</blockquote>
			<blockquote class="blockquote text-center">
				<p class="mb-0">Great selection, would visit again.</p>
				<footer class="blockquote-footer">Merlin in <cite title="Food Weekly">Food Weekly</cite></footer>
			</blockquote>

			<hr />
			<!-- User Reviews and Recommendations -->
			<p class="card-text text-center">
				User Reviews
			</p>
			<?php if(!empty($reviews)): ?>
				<div class="container-fluid">
					<?php foreach($reviews as $review): ?>
						<div class="row">
							<div class="col-10">
								<blockquote class="blockquote">
									<div id="show-review"> <?php echo $review['body']; ?> </div>
									<form action="/restaurants/<?php echo $restaurant_id; ?>/review/put" method="post" accept-charset="utf-8">
										<input id="edit-review" type="hidden" name="body" value="<?php echo $review['body']; ?>" class="form_control">
										<button id = "edit-review-btn" style="visibility: hidden" type="submit" class = "btn btn-primary">Submit</button>
									</form>
									<footer class="blockquote-footer"><?php echo $review['first_name']." ".$review['last_name'];?></footer>
								</blockquote>
							</div>
							<?php if($review['author_id'] == $user_id): ?>
							<div class='btn-group col-2'>
								<form action="/restaurants/<?php echo $restaurant_id; ?>/review/<?php echo $review['id']; ?>/put" method="post">
									<button id="edit-btn" onclick="editReview()" type="button" class="btn btn-danger edit-btn" style="margin-right:5px">Edit</button>
								</form>
								<form action="/restaurants/<?php echo $restaurant_id; ?>/review/<?php echo $review['id']; ?>/delete" method="post">
									<button type="submit" class="btn btn-danger">Delete</button>
								</form>
							</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if(empty($reviews) || (isset($user_left_review) && $user_left_review < 1) ): ?>
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
	<div class="row" style="margin-top: 1rem;">
		<div class="col text-center">
			<a class="btn btn-outline-primary" href="<?php echo site_url('/'); ?>">Go back</a>
		</div>
	</div>
</div>

<script type="text/javascript">
	function editReview() {
		document.getElementById('show-review').style = "visibility: hidden";
		document.getElementById('edit-review').type = "text";
		document.getElementById('edit-review-btn').style = "visibility: none";
	}
</script>
