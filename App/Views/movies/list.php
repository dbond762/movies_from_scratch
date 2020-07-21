<?php view('header'); ?>
<div class="container">
    <?php if (!empty($search_query)) : ?>
        <h4 class="my-4"><?php echo "Результат поиска по запросу: {$search_query}"; ?></h4>
    <?php endif; ?>
    <table class="table my-4">
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
            <?php foreach ($movies as $movie) : ?>
                <tr>
                    <td>
                        <a href="/movies/detail/<?php echo $movie['id']; ?>"><?php echo $movie['name']; ?></a>
                    </td>
                    <td><?php echo $movie['year']; ?></td>
                    <td><?php echo $movie['format']; ?></td>
                    <td><?php echo $movie['authors']; ?></td>
                    <td>
                        <form action="/movies/delete/<?php echo $movie['id']; ?>" method="post">
                            <input type="submit" value="&times;">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if (is_page('/movies/list')) : ?>
        <a href="/movies/add" class="btn btn-success">Добавить</a>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#import">Импортировать</button>
    <?php endif; ?>
</div>

    <!-- Modal -->
    <div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="importLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="/movies/import" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importLabel">Импорт фильмов</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="import-file">Файл для импорта</label>
                        <input type="file" name="file" id="import-file">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary">Импортировать</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php view('footer'); ?>