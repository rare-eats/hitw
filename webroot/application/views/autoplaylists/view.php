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
            <table class="table">
                <?php foreach ($restaurants as $key => $restaurant): ?>
                <tr>
                    <th scope="row"><?php echo $key+1; ?></th>
                    <td><a href="<?php echo site_url('/restaurants/'.$restaurant['id']); ?>"><?php echo $restaurant['name']; ?></a></td>
                </tr>
                <?php endforeach; ?>
            </table> 
        </div>
    </div>
</div>