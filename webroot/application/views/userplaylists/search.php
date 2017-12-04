<div class="container">

<div class="card">
	<div class="card-body">
		<h2 class="text-center">User Playlists</h2>
<?php $attr = [ 'class' => 'form-inline', 'method' => 'get'];
	echo form_open('userplaylists/search', $attr); 
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

<?php if(empty($playlists)): ?>
	<h3 class="text-center text-muted">No playlists available.</h3>
<?php endif; ?>
<?php foreach ($playlists as $playlist): ?>
	<a style="text-decoration: none;" href="<?php echo site_url('userplaylists/'.$playlist['id']); ?>">
		<div class="card">
			<div class="card-body">
				<h3><?php if ($playlist['private']): ?>
						<span class="text-dark"><i class="fa fa-lock" aria-label="private"></i> (Private)</span>
					<?php endif; ?> <?php echo $playlist['title']; ?> 
					<small class="text-muted">
						by <span class="text-dark"><?php if ($this->session->id !== $playlist['author_id']) { echo $playlist['author_name'][0]; }
						else { echo 'you'; } ?>
					</span></small></h3>
				<p class="card-text text-dark"><?php echo $playlist['desc']; ?></p>
			</div>
		</div>
	</a>
<?php endforeach; ?>
</div>
</div>