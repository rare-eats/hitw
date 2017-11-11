$('#removeConfirmModal').on('show.bs.modal', function (event) {
	var btn = $(event.relatedTarget)
	var modal = $(this)

	modal.find('.modal-body code').text(btn.data("tagname"))
	modal.find('.modal-footer .modal-accept').click(function(){
		console.log(btn.data("tagid"))
	})
})

$("#btnAddTag").click(function(){
	
	console.log($("#tagToAdd").val())
})