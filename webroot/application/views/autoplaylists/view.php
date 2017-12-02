<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="clearfix">
                <a class="btn btn-secondary float-right" aria-label="Return to Playlist Search" href="/">&times;</a>
                <h2><?php echo $playlist['title']; ?>
                    <br><small class="text-muted">
                </small></h2>
            </div>
            <p class="card-text">
                <?php
                echo $playlist['desc'];
                ?>
            </p>
            <ul>
            <?php foreach ($restaurants as $restaurant): ?>
                <li>
                    <a href="/restaurants/<?php echo $restaurant['id'];  ?>"><?php echo $restaurant['name']; ?></a>
                </li>
            <?php endforeach ?>
            </ul>
        </div>
    </div>
</div>