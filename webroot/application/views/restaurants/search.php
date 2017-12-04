<div class="container">

<div class="card">
	<div class="card-body">
		<h2 class="text-center">Restaurant Search</h2>
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
</form>

<?php if(empty($restaurants)): ?>
	<h3 class="text-center text-muted">No restaurants available.</h3>
<?php endif; ?>
<?php foreach ($restaurants as $restaurant): ?>
	<a style="text-decoration: none;" href="<?php echo site_url('restaurants/'.$restaurant['id']); ?>">
		<div class="card">
			<div class="card-body">
			<h3><?php echo $restaurant['name']; ?>
			<small class="text-muted">(
				<i class="fa fa-thumbs-o-up" aria-label="Thumbs up"></i> <?php echo $restaurant['upvotes']; ?> &nbsp;|&nbsp;
				<i class="fa fa-thumbs-o-down" aria-label="Thumbs down"></i>
				<?php echo $restaurant['downvotes']; ?>
			)</small></h3>
		</div>
	</div>
	</a>
<?php endforeach; ?>
</div>
</div>