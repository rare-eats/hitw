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


$("#thumbs_up").click(function(){
	var data = $(this).data();
	// $.ajax({
	// 	method: "POST",
	// 	url: "/restaurants/"+ restaurant_id+"/reviews/thumbs_up",
	// 	data:{restaurant_id}
	// }).done(function(result){
	// 			// console.log(data.restaurant_id);
  //       $("#thumbs_up").html();
	// });
	$.ajax({
		method: "PUT",
		url: "/restaurants/"+ data.restaurant_id +"/upvote",
		data: { }
	}).done(function(result){
		if (result.success)
		{
			location.reload();
			console.log(result);
		}
	});
})

$("#thumbs_down").click(function(){
	var data = $(this).data();
	// $.ajax({
	// 	method: "POST",
	// 	url: "/restaurants/"+ restaurant_id +"/reviews/thumbs_down",
	// 	data:{restaurant_id}
	// }).done(function(result){
	// 		// console.log(data.restaurant_id);
  //     $("#thumbs_down").html();
  //   });
	$.ajax({
		method: "PUT",
		url: "/restaurants/"+ data.restaurant_id +"/downvote",
		data: { }
	}).done(function(result){
		if(result.success)
		{
			console.log(result);
		}
	});
})
