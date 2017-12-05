<div class="container">
	<div class="card">
		<div class="card-body">
			<div class="clearfix">
				<a class="btn btn-secondary float-right" aria-label="Return to Restaurant List" href="/restaurants"><i class="fa fa-level-up" aria-label="return to list"></i></a>
			<h2><?php echo $restaurant['name']; ?>
				<small class="text-muted">
					<div class='btn-group col-md-2 col-sm-12'>
					<button id = "thumbs_up" type="submit" class="btn btn-primary btn-xs" data-restaurant_id="<?php echo $restaurant['id']; ?>" style="margin-right:5px"
						<?php if(empty($user_id)){ echo 'disabled';} if(!empty($user_review) && isset($user_review['rating']) && $user_review['rating']==TRUE){ echo 'active'; }?>>
			        		<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
			        		<?php if (($restaurant['upvotes'])==1){ echo '1 like ';} else{ echo $restaurant['upvotes'], ' likes ';}?>
			     	</button>
						<button id = "thumbs_down" type="submit" class="btn btn-primary btn-xs" data-restaurant_id="<?php echo $restaurant['id']; ?>"
							<?php if(empty($user_id)){ echo 'disabled'; } if(!empty($user_review) && isset($user_review['rating']) && $user_review['rating']==FALSE){ echo 'active'; }?>>
							<i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
							<?php if (($restaurant['downvotes'])==1){ echo '1 dislike ';} else{ echo $restaurant['downvotes'], ' dislikes ';}?>
						</button>
					</div>
				</small>
			</h2>
			</div>
			<p class="card-text">
				<?php if (!empty($restaurant['latlng'])): ?>
					<a class="btn btn-xs btn-link align-right" href="<?php echo "https://www.google.com/maps/search/?api=1&query=" . $restaurant['latlng'][0] . "," . $restaurant['latlng'][1];?>"><i class="fa fa-map-marker" aria-hidden="true"></i></a>
				<?php endif; ?>
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

			<?php if ($admin): ?>
				<a href="/restaurants/edit/<?php echo $restaurant['id']; ?>" class="btn btn-secondary">Edit</a>
			<?php endif; ?>
			<hr />

		<?php if(empty($photos)): ?>
			<img class="w-100" src="http://via.placeholder.com/800x300" alt="Placeholder">
		<?php else: ?>
		<div id="image_carousel" class="carousel slide" data-ride="carousel">
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
		</div>
		<?php endif; ?>

		<div class="card-body">
			<?php if (isset($user_id)): ?>
			<div class="text-center">
				<h3 class="card-title text-center">Add to Playlist</h3>
				<?php if(empty($playlists)): ?>
					<p class="text-center text-muted">You don't have any playlists yet.</p>
					<a class="btn btn-primary" href="<?php echo site_url('/userplaylists/create'); ?>">Create a playlist</a>
				<?php else: ?>
					<div class="text-success"><span id="added-message"></span></div>
						<form action="" method="POST" id="playlist-add" class="form-group form-inline" data-restaurant_id="<?php echo $restaurant['id']; ?>">
							<div class="container-fluid">
								<div class="form-control-lg input-group">
									<select data-placeholder="Add to Playlist" class="form-control form-control-chosen" id="playlist-select" name="playlist">
									<?php foreach($playlists as $row): ?>
										<option value="<?php echo $row['id'] ?>"><?php if ($row['private']) { echo '(Private)'; } ?> <?php echo $row['title'] ?></option>
									<?php endforeach; ?>
									</select>
									<span class="input-group-btn">
										<input id="submit-p" class="btn btn-primary" type="submit" value="&plus;" aria-label="Add restaurant to selected playlist">
									</span>
								</div>
							</div>
						</form>
				<?php endif; ?>
				</div>
			<?php endif; ?>
		<hr />
		<h3 class="card-title text-center">User Reviews</h3>
			<div class="container-fluid">
			<?php if(!empty($reviews)): ?>
					<?php foreach($reviews as $review):
							if (!empty($review['body'])):?>
						<div class="row <?php if($review['author_id'] == $user_id) {echo 'own-review';};?>">
							<div class="col-md-10 col-sm-12">
								<blockquote class="blockquote">
									<?php if(($review['author_id'] == $user_id) || ($admin)): ?>
										<p id="show-review" style="display: block"><?php echo $review['body']; ?></p>
										<form id="edit-form" class="edit-form" style="display:none" action="/restaurants/<?php echo $restaurant_id; ?>/review/put" method="post" accept-charset="utf-8">
											<div class="container-fluid">
												<div class="form-control-lg input-group">
													<input id="edit-field" name="body" class="form-control" value="<?php echo html_escape($review['body']); ?>">
													<span class="input-group-btn">
														<button id = "submit-edit-btn" type="submit" class = "btn btn-primary">Submit</button>
													</span>
												</div>
											</div>
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
					<?php endif; endforeach; ?>
			<?php else: ?>
				<p class="text-muted text-center">There don't seem to be any reviews yet.</p>
			<?php endif; ?>

			<?php if(empty($user_id)): ?>
				<p class="text-center"><a href="/users/login<?php echo $_SERVER['REQUEST_URI'];?>">Log in to leave a review.</a></p>
			<?php elseif(empty($user_review) || !isset($user_review[0]['body'])): ?>
				<p class="text-center">Let your voice be heard, leave a review now!</p>
					<form action="/restaurants/<?php echo $restaurant_id; ?>/review/put" method="post" accept-charset="utf-8">
						<!-- <div class="container-fluid"> -->
							<div class="form-control-lg input-group">
								<input type="text" id="body" name="body" class="form-control" placeholder="What did you think of this location?" value="<?php empty($user_review) || empty($user_review['body']) ? "" : html_escape($user_review['body']); ?>">
								<span class="input-group-btn">
									<button type="submit" class="btn btn-primary">Submit</button>
								</span>
							<!-- </div> -->
						</div>
					</form>
			<?php endif; ?>
			<!-- End user reviews and recommendations -->
			</div>
		</div>
	</div>
</div>