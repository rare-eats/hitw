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
		            <div class="card-body">
		            	<h4 class="card-title"><?php echo $recommended['title']; ?></h4>
						<p class="card-text"><?php echo $recommended['desc']; ?></p>
		                <a href="/autoplaylists/view/<?php echo $recommended['id'] ?>" class="btn btn-primary">Taste It</a>
		            </div>
		        </div>
	        </div>
	    </div>
	<?php endif ?>
	<div class="row heading">
		<div class="col text-center">
			<h2 class="display-2">My Lists <a href="/userplaylists/create">&plus;</a></h2>
		</div>
	</div>
	<div class="row d-flex flex-row">
		<div class="col d-lg-flex justify-content-sm-center">
		<?php foreach ($playlists as $playlist): ?>
			<div class="card">
				<div class="card-body">
					<h4 class="card-title"><?php echo $playlist['title']; ?></h4>
					<p class="card-text"><?php echo $playlist['desc']; ?></p>
					<a href="/userplaylists/view/<?php echo $playlist['id'] ?>" class="btn btn-primary">Taste It</a>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
<?php endif ?>
<?php if(!empty($restaurants)): ?>
	<div class="row heading">
		<div class="col text-center">
			<h2 class="display-2">Quick Bites</h2>
		</div>
	</div>
	<div class="row d-flex flex-row">
		<div class="col d-lg-flex justify-content-sm-center">
		<?php foreach ($restaurants as $restaurant): ?>
			<div class="card align-top">
				<div class="restaurant-image">
					<img class="card-img-top align-middle" src="<?php echo $restaurant['image_url'][0]; ?>" alt="Restaurant Image">
				</div>
				<div class="card-body">
					<h4 class="card-title"><?php echo $restaurant['name']; ?></h4>
					<p class="card-text">(<?php
						if (!isset($restaurant['rating'])) {
							echo 'No ratings yet';
						}
						else
						{
							echo $restaurant['rating'];
							echo '/5';
						}
						?>)</p>
					<a href="<?php echo '/restaurants/'.$restaurant['id']; ?>" class="btn btn-primary">Dig in</a>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>
</div>