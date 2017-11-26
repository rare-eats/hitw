<div class="container">
    <div class="card">
        <div class="card-body">
            <h2><?php echo $playlist['title']; ?>
                <br><small class="text-muted">
                </small>
            </h2>
            <p class="card-text">
                <?php
                echo $playlist['desc'];
                ?>
            </p>
            <ul>
            <?php foreach ($restaurants as $restaurant): ?>
                <li>
                    <?php echo $restaurant['name']; ?>
                </li>
            <?php endforeach ?>
            </ul>
            <hr />
        </div>
    </div>
    <div class="row" style="margin-top: 1rem;">
        <div class="col text-center">
            <a class="btn btn-outline-primary" href="<?php echo site_url('/'); ?>">Go back</a>
        </div>
    </div>
</div>