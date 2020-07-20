<?php

namespace App\Models;

use Lib\Model\Model;

class Movies extends Model {
    public function get_movies_list() {
        return $this->pdo->query('SELECT * FROM `movie` ORDER BY `name`')->fetchAll();
    }
}
