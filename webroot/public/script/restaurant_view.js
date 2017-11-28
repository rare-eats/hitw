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
	$("#show-review").css("display", "none");
	$("#edit-form").css("display", "block");
})
