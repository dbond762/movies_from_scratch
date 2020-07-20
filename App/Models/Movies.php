<?php

namespace App\Models;

use Lib\Model\Model;

class Movies extends Model {
    public function get_movies_list() {
        return $this->pdo->query('SELECT * FROM `movie` ORDER BY `name`')->fetchAll();
    }

    public function add($name, $year, $format) {
        $stmt = $this->pdo->prepare('INSERT INTO `movie`(`name`, `year`, `format`) VALUES (?, ?, ?)');
        $stmt->execute([$name, $year, $format]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare('DELETE FROM `movie` WHERE `id` = ?');
        $stmt->execute([$id]);
    }

    public function get($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM `movie` WHERE `id` = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function search($query) {
        $query = "%{$query}%";
        $stmt = $this->pdo->prepare('SELECT * FROM `movie` WHERE `name` LIKE ?');
        $stmt->execute([$query]);
        return $stmt->fetchAll();
    }
}
