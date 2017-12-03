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
			// $("#thumbs_up").attr("disabled", true);
			if(data.message =="unliked"){
				// $("#thumbs_down").attr("active", true);
				$('#thumbs_up').removeClass("active");
			}
			else{
				$('#thumbs_up').addClass("active");
				if(data.message == "changed mind"){
					$('#thumbs_down').removeClass("active");
				}
			}
			update_btn(data);
	});
})

$("#thumbs_down").click(function(){
	var data = $(this).data();
	$.ajax({
		method: "PUT",
		url: "/restaurants/"+ data.restaurant_id +"/reviews/thumbs_down",
		data:{ }
	}).done(function(data) {
		if(data.message=="undisliked"){
			$('#thumbs_down').removeClass("active");
		}
		else{
			$('#thumbs_down').addClass("active");
			if(data.message == "changed mind"){
				$('#thumbs_up').removeClass("active");
			}
		}
		update_btn(data);
	});
})

function update_btn(data){
	if(data.upvotes==1){
		$("#thumbs_up").html('<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> '+String(data.upvotes)+' like');
	}
	else{
		$("#thumbs_up").html('<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> '+String(data.upvotes)+' likes');
	}
	if(data.downvotes==1){
		$("#thumbs_down").html('<i class="fa fa-thumbs-o-down" aria-hidden="true"></i> '+String(data.downvotes)+' dislike');
	}
	else{
		$("#thumbs_down").html('<i class="fa fa-thumbs-o-down" aria-hidden="true"></i> '+String(data.downvotes)+' dislikes');
	}
}
