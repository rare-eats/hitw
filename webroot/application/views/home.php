<?php
    $this->load->model('tags_model');
    $this->load->model('restaurants_model');

    $this->tags_model->make_tags_api_call();
    #Get restaurants, and within restaurants get a few associated reviews if available.
    $this->restaurants_model->make_restaurants_api_call();
?>
<div class="container-fluid">
<?php if (isset($author_id)): ?>
	   	<div class="row heading">
			<div class="col text-center">
				<h2 class="display-3">Explore</h2>
			</div>
		</div>
		<div class="row d-flex flex-row">
	        <div class="col d-lg-flex justify-content-sm-center">
			<?php if (isset($recommended)): ?>
		        <div class="card" style="width: 20rem; display: inline-block; margin: 1rem;">
		            <a style="text-decoration: none;" href="/autoplaylists/view/<?php echo $recommended['id'] ?>">
		            <div class="card-body">
		            	<h4 class="card-title text-dark"><?php echo $recommended['title']; ?></h4>
						<p class="card-text text-dark"><?php echo $recommended['desc']; ?></p>
		            </div>
		            </a>
		        </div>
		    <?php endif ?>
		   	<?php if (isset($time_list)): ?>
		        <div class="card" style="width: 20rem; display: inline-block; margin: 1rem;">
	        		<a style="text-decoration: none;" href="/autoplaylists/view/<?php echo $time_list['id'] ?>">
		        	<div class="card-body">
		            	<h4 class="card-title text-dark"><?php echo $time_list['title']; ?></h4>
						<p class="card-text text-dark"><?php echo $time_list['desc']; ?></p>
		            </div>
					</a>
		        </div>
		    <?php endif ?>
		   	<?php if (isset($time_list)): ?>
		   		<div class="card" style="width: 20rem; display: inline-block; margin: 1rem;">
	        		<a style="text-decoration: none;" href="/autoplaylists/view/<?php echo $season_list['id'] ?>">
		        	<div class="card-body">
		            	<h4 class="card-title text-dark"><?php echo $season_list['title']; ?></h4>
						<p class="card-text text-dark"><?php echo $season_list['desc']; ?></p>
		            </div>
					</a>
		        </div>
		    <?php endif ?>
	        </div>
	    </div>
	<div class="row heading">
		<div class="col text-center">
			<h2 class="display-3"><a style="text-decoration: none; color: #ec1046" href="/users/view">My Lists</a> <a href="/userplaylists/create">&plus;</a></h2>
		</div>
	</div>
	<div class="row d-flex flex-row">
		<div class="col d-lg-flex justify-content-sm-center">
		<?php if (empty($playlists)): ?>
			<div class="card">
				<div class="card-body text-center">
					<p class="card-text">You don't have any lists yet.</p>
					<p class="card-text"><a href="/userplaylists/create">Why not make one?</a></p>
				</div>
			</div>
		<?php else: ?>
		<?php foreach ($playlists as $playlist): ?>
			<div class="card">
				<div class="card-block">
				<a style="text-decoration: none;" href="/userplaylists/view/<?php echo $playlist['id'] ?>">
					<div class="card-body">
						<h4 class="text-dark"><?php echo $playlist['title']; ?></h4>
						<p class="card-text text-dark"><?php echo $playlist['desc']; ?></p>
					</div>
				</a>
				</div>
			</div>
		<?php endforeach; ?>
		<?php endif; ?>
		</div>
	</div>
<?php else: ?>
	<div class="jumbotron jumbotron-fluid front-page-img">
		<div class="container text-center">
			<h1 class="display-2">Rare Eats</h1>
			<p class="lead"><strong>Find and Discover Restaurants You Love</strong></p>
			<hr class="my-4">
			<div class="font-weight-bold" style="display: inline-block; text-align: left;">
				<p>
					<i class="fa fa-check" aria-hidden="true"></i>&nbsp; Create lists of your favorite restaurants
				</p>
				<p>
					<i class="fa fa-check" aria-hidden="true"></i>&nbsp; Receive recommendations based on your favorite eats
				</p>
			</div>
			<p class="lead">
			<a class="btn btn-primary btn-lg" href="/users/create" role="button">Sign Up</a>
			</p>
			<p class="font-weight-bold">Already Have an Account?</p>
			<p class="lead">
			<a class="btn btn-primary btn-sm" href="/users/login" role="button">Login</a>
			</p>
		</div>
	</div>
<?php endif ?>
	<div class="row heading">
		<div class="col text-center">
			<h2 class="display-3">Featured Eats</h2>
		</div>
	</div>
	<div class="row d-flex flex-row">
		<div class="col d-lg-flex justify-content-sm-center">
<?php if(!empty($restaurants)): ?>
		<?php foreach ($restaurants as $restaurant): ?>
			<div class="card align-top">
				<a style="text-decoration: none;" href="<?php echo '/restaurants/'.$restaurant['id']; ?>">
				<div class="restaurant-image">
					<img class="card-img-top align-middle" src="<?php
						if (!empty($restaurant['image_url'])) {
							echo $restaurant['image_url'][0];
						}
						else
						{
							echo 'http://via.placeholder.com/300x150';
						}
					?>" alt="Restaurant Image">
				</div>
				<div class="card-body">
					<h4 class="card-title"><?php echo $restaurant['name']; ?></h4>
					</a>
				</div>
			</div>
		<?php endforeach; ?>
<?php else: ?>
			<div class="card">
				<div class="card-body">
					<h3 class="text-center">No restaurants found.</h3>
					<p class="card-text">Try reloading the page.</p>
				</div>
			</div>
<?php endif; ?>
		</div>
	</div>
</div>