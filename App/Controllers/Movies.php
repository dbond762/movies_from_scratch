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
        $name   = $_POST['name'];
        $year   = $_POST['year'];
        $format = $_POST['format'];
        $this->movies_model->add($name, $year, $format);
        Response::redirect('/movies/list');
    }

    public function delete($ctx) {
        $id = $ctx['params']['id'];
        $this->movies_model->delete($id);
        Response::redirect('/movies/list');
    }

    public function detail($ctx) {
        $id = $ctx['params']['id'];
        $data['movie'] = $this->movies_model->get($id);
        Response::view('movies/detail', $data);
    }

    public function search($ctx) {
        $query = $_GET['q'];
        $data['movies'] = $this->movies_model->search($query);
        Response::view('movies/list', $data);
    }

    public function import($ctx) {
        // import
        Response::redirect('/movies/list');
    }
}
