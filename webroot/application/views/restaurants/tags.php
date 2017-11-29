<div class="modal" id="removeConfirmModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Remove tag?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				Would you like to remove tag <code>Tag Name</code>?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger modal-accept" data-dismiss="modal">Remove</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="errorModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-danger text-light">
				<h5 class="modal-title">Error</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">OK</button>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
<div class="card">
	<div class="list-group">
		<!-- Add an entry for creating new tags -->
		<div class="list-group-item list-group-item-action">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Tag Name" id="tagToAdd">
				<span class="input-group-btn">
					<button id="btnAddTag" class="btn btn-success" type="button">+</button>
				</span>
			</div>
		</div>

		<!-- Add tags to list -->
	<?php foreach ($tags as $tag): ?>
		<div class="list-group-item list-group-item-action d-flex flex-row justify-content-between" id="<?php echo $tag['id']; ?>">
			<div class="mr-auto p-2">
				<p class="h3"><?php echo $tag['name']; ?></p>
			</div>
			<div class="p-2">
				<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#removeConfirmModal" data-tagid="<?php echo $tag['id']; ?>" data-tagname="<?php echo $tag['name']; ?>">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
	<?php endforeach; ?>
	</div>
</div>
</div>