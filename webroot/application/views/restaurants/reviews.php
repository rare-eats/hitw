<div class="container">
	<div class="card" style="padding: 1rem;">
		<h3><?php echo $restaurant['name']; echo " "; echo $title; ?></h3>
	<?php echo validation_errors(); ?>
  <?php echo form_open('restaurants/reviews/'.$restaurant['id']); ?>
  <!-- <div class="form-group">
    <label for="rating">Rating</label>
    <input type="boolean" id="rating" name="rating" class="form-control" required>
  </div> -->
  <div class="form-group">
    <label for="body">Leave a review!</label>
    <input type="text" id="body" name="body" class="form-control">
  </div>
  <div class="row">
    <div class="col text-center">
      <!-- check if user is logged in -->
      <?php
      if(!$this->session->id){
        $alert = "alert('Please log in to leave a review');";
      }
      else{
        $alert = "alert('Success');";
      }
      ?>
      <button onclick="<?php echo $alert;?>" type="submit" class="btn btn-primary">
        Leave Review
      </button>
      <a class="btn btn-secondary" href="<?php echo site_url('restaurants/reviews/'.$restaurant['id']); ?>">Cancel</a>
    </div>
  </div>
  <div class="container-fluid">
  	<div class="row">
  		<div class="col">
  			<div class="list-group">
  			<?php foreach ($reviews as $review): ?>

          <div class="list-group-item list-group-item-action d-flex flex-row justify-content-between" id="<?php echo $review['id']; ?>">
  					<div class="mr-auto p-2">
              <?php $firstname = $this->users_model->get_first_name($review['author_id'])[0]["first_name"];
              ?>
              <p vclass="h3"> <?php echo $firstname; ?></p>
  						<p class="h3"><?php echo $review['body']; ?></p>
  					</div>
            <?php if (!is_null($this->session->id) && $this->session->id === $review["author_id"]) { ?>
            <div class="p-2">
              <a href="<?php echo site_url('/reviews/edit/'.$review['id']); ?>" class="btn btn-secondary">Edit</a>
              <a href="<?php echo site_url('/reviews/delete/'.$review['id']); ?>" class="btn btn-secondary">Delete</a>
  					</div>
            <?php } ?>
  				</div>
  			<?php endforeach; ?>
  			</div>
  		</div>
  	</div>
  </div>
  </div>
</div>
