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
		// success:
	}).done(function( data ) {
			$("#thumbs_up").disabled = true;
			change_button_text(data);
	});
})

$("#thumbs_down").click(function(){
	var data = $(this).data();
	$.ajax({
		method: "PUT",
		url: "/restaurants/"+ data.restaurant_id +"/reviews/thumbs_down",
		data:{ }
	}).done(function(data) {
		$("#thumbs_down").disabled = true;
		change_button_text(data);
	});
})

function change_button_text(data){
	if(data.upvotes==1){
		$("#thumbs_up").text(String(data.upvotes)+" like");
	}
	else{
		$("#thumbs_up").text(String(data.upvotes)+" likes");
	}
	if(data.downvotes==1){
		$("#thumbs_down").text(String(data.downvotes)+" dislike");
	}
	else{
		$("#thumbs_down").text(String(data.downvotes)+" dislikes");
	}
}
