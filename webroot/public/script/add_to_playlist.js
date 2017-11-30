$("#playlist-add").submit(function(e){
	e.preventDefault();
	var playlist_id = $("#playlist-select").val();
	var restaurant_id = $("#playlist-add").data("restaurant_id");
	$.ajax({
		type: "POST",
		url: '/userplaylists/add_to_list',
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
});