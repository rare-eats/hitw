$('#removeConfirmModal').on('show.bs.modal', function (event) {
	var btn = $(event.relatedTarget);
	var modal = $(this);

	modal.find('.modal-body code').text(btn.data("tagname"));
	modal.find('.modal-footer .modal-accept').click(function(){
		console.log(btn.data("tagid"));
		$.ajax({
			method: "DELETE",
			url: "/restaurants/tags",
			data: { id: btn.data("tagid"), name: btn.data('tagname') }
		}).done(function( result ) {
			if (result.success)
			{
				location.reload();
			}
			else
			{
				$('#errorModal').find('.modal-body').html("<p>" + result.message + "</p><code>" + result.data.name + "</code>");
				$('#errorModal').modal('show');
			}
		});
	});
});

$("#btnAddTag").click(function(){
	tagToAdd = $("#tagToAdd").val();
	if(tagToAdd)
	{
		$.ajax({
			method: "PUT",
			url: "/restaurants/tags",
			data: { name: tagToAdd }
		}).done(function( result ) {
			if (result.success)
			{
				location.reload();
			}
			else
			{
				$('#errorModal').find('.modal-body').html("<p>" + result.message + "</p><code>" + result.data.name + "</code>");
				$('#errorModal').modal('show');
			}
		});
	}
});