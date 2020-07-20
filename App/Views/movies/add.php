<?php view('header'); ?>
<div class="container">
    <form action="/movies/add" method="post">
        <div class="row">
            <div class="mb-3">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Movie name" required="">
                <div class="invalid-feedback">
                    Please enter movie name.
                </div>
            </div>
        </div>
        <div class="row">
            <div class="mb-3">
                <label for="year">Year</label>
                <input type="number" class="form-control" id="year" name="year" placeholder="1972" required="">
                <div class="invalid-feedback">
                    Year is required.
                </div>
            </div>
        </div>
        <div class="row">
            <h4 class="mb-3">Format</h4>
            <div class="d-block my-3">
                <div class="custom-control custom-radio">
                    <input id="vhs" name="format" value="VHS" type="radio" class="custom-control-input" checked="" required="">
                    <label class="custom-control-label" for="vhs">VHS</label>
                </div>
                <div class="custom-control custom-radio">
                    <input id="dvd" name="format" value="DVD" type="radio" class="custom-control-input" required="">
                    <label class="custom-control-label" for="dvd">DVD</label>
                </div>
                <div class="custom-control custom-radio">
                    <input id="blu-ray" name="format" value="Blu-Ray" type="radio" class="custom-control-input" required="">
                    <label class="custom-control-label" for="blu-ray">Blu-Ray</label>
                </div>
            </div>
        </div>
        <input type="submit" value="Сохранить" class="btn btn-success">
    </form>
</div>
<?php view('footer'); ?>