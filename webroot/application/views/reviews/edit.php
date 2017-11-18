<div class="container">
	<div class="card" style="padding: 1rem;">
  <head>
    <title>Edit</title>
  </head>
    <body>

      <?php echo validation_errors(); ?>

  <?php echo form_open('/restaurants/reviews/'.$review_id); ?>
  <div class="form-group">
			<label for="body">Your Review</label>
			<?php $body = $this->reviews_model->get_review($review_id)[0]["body"]; ?>
    <input type="text" id="body" name="body" value= "<?php echo $body ?>" class="form-control">
  </div>
<button type="submit" class="btn btn-primary">Edit Review</button>

  </body>
  </div>
</div>
