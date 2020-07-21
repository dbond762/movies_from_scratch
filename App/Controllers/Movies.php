<?php

namespace App\Controllers;
use Lib\Response\Response;
use App\Models\Movies as MoviesModel;
use Lib\Router\Router;

class Movies {
    /**
     * @var MoviesModel
     */
    private $movies_model;

    public function __construct() {
        $this->movies_model = new MoviesModel();
    }

    public function movies_list($ctx) {
        $data['movies'] = $this->movies_model->get_movies_list();
        Response::view('movies/list', $data);
    }

    public function add_view($ctx) {
        Response::view('movies/add');
    }

    public function add($ctx) {
        $name   = htmlentities($_POST['name']);
        $year   = htmlentities($_POST['year']);
        $format = htmlentities($_POST['format']);
        $this->movies_model->add($name, $year, $format);
        Response::redirect('/movies/list');
    }

    public function delete($ctx) {
        $id = htmlentities($ctx['params']['id']);
        $this->movies_model->delete($id);
        Response::redirect('/movies/list');
    }

    public function detail($ctx) {
        $id = htmlentities($ctx['params']['id']);
        $data['movie'] = $this->movies_model->get($id);
        Response::view('movies/detail', $data);
    }

    public function search($ctx) {
        $query = htmlentities($_GET['q']);
        $data['search_query'] = $query;
        $data['movies'] = $this->movies_model->search($query);
        Response::view('movies/list', $data);
    }

    public function import($ctx) {
        $file = $_FILES['file'];
        if ($file['type'] !== 'text/plain') {
            Response::redirect('/movies/list');
        }

        $get_value = function ($val) {
            return trim(explode(':', htmlentities($val))[1]);
        };

        $fd = fopen($file['tmp_name'], 'r') or die("не удалось открыть файл");
        while (!feof($fd)) {
            $title  = $get_value(fgets($fd));
            $year   = $get_value(fgets($fd));
            $format = $get_value(fgets($fd));
            $actors = explode(',', $get_value(fgets($fd)));
            $actors = array_map('trim', $actors);

            $movie_id = $this->movies_model->add($title, $year, $format);
            foreach ($actors as $actor) {
                $actor_names = explode(' ', $actor);
                $actor_id = $this->movies_model->add_actor($actor_names[0], $actor_names[1]);
                $this->movies_model->add_actor_to_movie($movie_id, $actor_id);
            }

            if (!feof($fd)) {
                fgets($fd);
            }
        }
        fclose($fd);

        Response::redirect('/movies/list');
    }
}
