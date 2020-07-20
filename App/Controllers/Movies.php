<?php

namespace App\Controllers;
use App\Models\Movies as MoviesModel;

class Movies {
    /**
     * @var MoviesModel
     */
    private $movies_model;

    public function __construct() {
        $this->movies_model = new MoviesModel();
    }

    public function movies_list($ctx) {
        var_dump($this->movies_model->get_movies_list());
    }
}
