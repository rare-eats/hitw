$(".remove_tag_button").click(function(){

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

$("#thumbs_up").click(function(){
	var data = $(this).data();
	$.ajax({
		method: "PUT",
		url: "/restaurants/"+ data.restaurant_id+"/reviews/thumbs_up",
		data: { }
	}).done($(this).disabled = true)
	// $.ajax({
	// 	method: "PUT",
	// 	url: "/restaurants/"+ data.restaurant_id +"/upvote",
	// 	data: { }
	// }).done(
	// 	$.ajax({
	// 		method: "PUT",
	// 		url: "/restaurants/"+ data.restaurant_id+"/reviews/thumbs_up",
	// 		data: { }
	// 	}).done($(this).disabled = true)
	// );
		// $(this).load(result);
})

$("#thumbs_down").click(function(){
	var data = $(this).data();
	$.ajax({
		method: "PUT",
		url: "/restaurants/"+ data.restaurant_id +"/reviews/thumbs_down",
		data:{ }
	}).done($(this).disabled = true)
	// $.ajax({
	// 	method: "PUT",
	// 	url: "/restaurants/"+ data.restaurant_id +"/downvote",
	// 	data: { }
	// }).done(
	// 	$.ajax({
	// 		method: "PUT",
	// 		url: "/restaurants/"+ data.restaurant_id +"/reviews/thumbs_down",
	// 		data:{ }
	// 	}).done($(this).disabled = true)
	// );
})
