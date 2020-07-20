<?php view('header'); ?>
<div class="container">
    <div class="row">
        <div class="movie_item">
            <div class="row">
                <div class="col-md-8">
                    <span class="movie_item__name"><?php echo $movie['name']; ?></span>
                    <span class="movie_item__year"><?php echo $movie['year']; ?></span>
                </div>
                <div class="col-md-2">
                    <span class="movie_item__format"><?php echo $movie['format']; ?></span>
                </div>
                <div class="col-md-2">
                    <form action="/delete/<?php echo $movie['id']; ?>" method="post">
                        <input type="submit" value="X">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php view('footer'); ?>