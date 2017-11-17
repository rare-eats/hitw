<?php if(empty($playlists)) 
{
	echo 'No playlists available.';
}
?>
<table class="table">
    <tr>
        <th>Title</th>
        <th>Description</th>
        <th>ID</th>
        <th>Author ID</th>
        <th>Private</th>
    </tr>
    <?php foreach($playlists as $playlist): ?>
    <tr>
        <td><a href="<?php echo site_url('/userplaylists/'.$playlist['id']); ?>"><?php echo $playlist['title']; ?></a></td>
        <td><?php echo $playlist['desc']; ?></td>
        <td><?php echo $playlist['id']; ?></td>
        <td><?php echo $playlist['author_id']; ?></td>
        <td><?php echo $playlist['private']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>