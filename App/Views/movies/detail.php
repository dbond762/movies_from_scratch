<?php view('header'); ?>
<div class="container">
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Year</th>
            <th>Format</th>
            <th>Authors</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <a href="/movies/detail/<?php echo $movie['id']; ?>"><?php echo $movie['name']; ?></a>
                </td>
                <td><?php echo $movie['year']; ?></td>
                <td><?php echo $movie['format']; ?></td>
                <td><?php echo $movie['authors']; ?></td>
                <td>
                    <form action="/movies/delete/<?php echo $movie['id']; ?>" method="post">
                        <input type="submit" value="X">
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<?php view('footer'); ?>