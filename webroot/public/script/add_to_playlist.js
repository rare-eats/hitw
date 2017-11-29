$("#playlist-add").submit(function(e){
	e.preventDefault();
	var playlist_id = $("#playlist-select").val();
	var restaurant_id = <?php echo $restaurant['id'] ?>;
	$.ajax({
		type: "POST",
		url: '<?php echo base_url() ?>userplaylists/add_to_list',
		data: {playlist_id:playlist_id,restaurant_id:restaurant_id},
		success:function(data)
		{
			$("#added-message").replaceWith("<p>Added to playlist!</p>");
		},
		error:function()
		{
			alert('Failed to add restaurant to playlist!');
		}
	});
})