$(".remove_tag_button").click(function(){
	console.log($(this).data());

	var self = $(this);
	var data = $(this).data();
	$.ajax({
		method: "DELETE",
		url: "/restaurants/" + data.restaurant_id + "/tags/" + data.tag_id,
		data: { }
	}).done(function( result ) {
		if (result.success)
		{
			location.reload();
		}
	});
})

$(".edit_reviews").click(function(){
	document.getElementById('show-review').style = "visibility: hidden";
	document.getElementById('edit-field').type = "text";
	document.getElementById('submit-edit-btn').style = "visibility: none";
})
