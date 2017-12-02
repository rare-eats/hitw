<?php
	#$this->restaurants_model->load_food_categories();
    $this->tags_model->make_tags_api_call();
    #Get restaurants, and within restaurants get a few associated reviews if available.
    $this->restaurants_model->make_restaurants_api_call();
    #$this->restaurants_model->associate_restaurants_with_tags();
?>

<div class="container-fluid">
<?php if (isset($author_id)): ?>
	<?php if (isset($recommended)): ?>
	   	<div class="row heading">
			<div class="col text-center">
				<h2 class="display-2">Explore</h2>
			</div>
		</div>
		<div class="row d-flex flex-row">
	        <div class="col d-lg-flex justify-content-sm-center">
		        <div class="card" style="width: 20rem; display: inline-block; margin: 1rem;">
		            <a style="text-decoration: none;" href="/autoplaylists/view/<?php echo $recommended['id'] ?>">
		            <div class="card-body">
		            	<h4 class="card-title text-dark"><?php echo $recommended['title']; ?></h4>
						<p class="card-text text-dark"><?php echo $recommended['desc']; ?></p>
		            </a>
		            </div>
		        </div>
	        </div>
	    </div>
	<?php endif ?>
	<div class="row heading">
		<div class="col text-center">
			<h2 class="display-2"><a style="text-decoration: none; color: #ec1046" href="/users/view">My Lists</a> <a href="/userplaylists/create">&plus;</a></h2>
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
<?php endif ?>
	<div class="row heading">
		<div class="col text-center">
			<h2 class="display-2">Quick Bites</h2>
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