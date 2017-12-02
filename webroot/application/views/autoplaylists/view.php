<div class="container">
    <div class="card">
        <div class="card-body">
            <h2><?php echo $playlist['title']; ?><br>
                </small class="text-muted">
            </h2>
            <p class="card-text">
                <?php echo $playlist['desc']; ?>
            </p>
            <?php if (!empty($restaurants)): ?>
                <ol>
                <?php foreach ($restaurants as $restaurant): ?>
                    <li>
                        <a href="/restaurants/<?php echo $restaurant['id']?>"><?php echo $restaurant['name']; ?></a>
                    </li>
                <?php endforeach ?>
                </ol>
            <?php else: ?>
                <p class="text-muted">No Restaurants in this List</p>
            <?php endif ?>
            <hr />
        </div>
    </div>
    <div class="row" style="margin-top: 1rem;">
        <div class="col text-center">
            <a class="btn btn-outline-primary" href="/">Return to Homepage</a>
        </div>
    </div>
</div>