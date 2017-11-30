<?php if(empty($playlists)): ?>
	<span>No playlists available</span>
<? else: ?>
	<table class="table">
		<tr>
			<th>Title</th>
			<th>Description</th>
			<th>ID</th>
			<th>Author Name</th>
		</tr>
		<?php foreach($playlists as $playlist): ?>
			<?php if ($playlist['private'] === FALSE or $playlist['author_id'] === $user_id): ?>
				<tr>
					<td><a href="<?php echo site_url('/userplaylists/'.$playlist['id']); ?>"><?php echo $playlist['title']; ?></a></td>
					<td><?php echo $playlist['desc']; ?></td>
					<td><?php echo $playlist['id']; ?></td>
					<td><?php echo $playlist['author_name']; ?></td>
				</tr>
			<?php endif; ?>
		<?php endforeach; ?>
	</table>
<?php endif; ?>