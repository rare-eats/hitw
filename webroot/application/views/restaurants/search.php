<div class="container">

<div class="card">
<?php $attr = [ 'class' => 'form-inline', 'method' => 'get'];
	echo form_open('restaurants/search', $attr); 
?>
<div class="container-fluid">
	<div class="form-control-lg input-group">
		<input type="text" class="form-control form-control-lg" name="terms" placeholder="I'm feeling like..." 
		<?php if(isset($terms))
		{ 
			echo 'value="'.$terms.'"'; 
		}
		?> >
		<span class="input-group-btn">
			<button class="btn btn-secondary btn-lg" type="submit">Search</button>
		</span>
	</div>
</div>
<?php echo form_close(); ?>
</div>

<?php if(empty($restaurants)): ?>
	<h3 class="text-center text-muted">No restaurants available.</h3>
<?php endif; ?>
<?php foreach ($restaurants as $restaurant): ?>
	<a style="text-decoration: none;" href="<?php echo site_url('restaurants/'.$restaurant['id']); ?>">
		<div class="card">
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