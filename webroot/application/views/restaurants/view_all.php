<div class="container">
<?php if(empty($restaurant)) 
{
	echo 'No restaurants available.';
}
?>
<?php foreach ($restaurants as $restaurant): ?>
	<a style="text-decoration: none;" href="<?php echo site_url('restaurants/'.$restaurant['id']); ?>">
		<div class="card" style="margin-bottom: 1rem; padding: 1rem;">
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
		</div>
	</a>
<?php endforeach; ?>
</div>