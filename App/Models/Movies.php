<?php

namespace App\Models;

use Lib\Model\Model;

class Movies extends Model {
    public function get_movies_list() {
        return $this->pdo->query(
            "SELECT `m`.*, GROUP_CONCAT(CONCAT(`a`.`first_name`, ' ', `a`.`last_name`) SEPARATOR ', ') `authors` "
            . "FROM `movie` `m` "
            . "    LEFT JOIN `movie_actor` `ma` ON `m`.`id` = `ma`.`movie_id` "
            . "    LEFT JOIN `actor` `a` ON `ma`.`actor_id` = `a`.`id` "
            . "GROUP BY `m`.`id` "
            . "ORDER BY `m`.`name` "
        )->fetchAll();
    }

    public function add($name, $year, $format) {
        $stmt = $this->pdo->prepare('INSERT INTO `movie`(`name`, `year`, `format`) VALUES (?, ?, ?)');
        $stmt->execute([$name, $year, $format]);
        return $this->pdo->lastInsertId();
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare('DELETE FROM `movie` WHERE `id` = ?');
        $stmt->execute([$id]);
    }

    public function get($id) {
        $stmt = $this->pdo->prepare(
            "SELECT `m`.*, GROUP_CONCAT(CONCAT(`a`.`first_name`, ' ', `a`.`last_name`) SEPARATOR ', ') `authors` "
            . "FROM `movie` `m` "
            . "    LEFT JOIN `movie_actor` `ma` ON `m`.`id` = `ma`.`movie_id` "
            . "    LEFT JOIN `actor` `a` ON `ma`.`actor_id` = `a`.`id` "
            . "WHERE `m`.`id` = ? "
            . "GROUP BY `m`.`id` "
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function search(string $query) {
        $query = strtolower($query);
        $query = "%{$query}%";
        $stmt = $this->pdo->prepare(
            "SELECT `m`.* "
            . "FROM `movie` `m` "
            . "    LEFT JOIN `movie_actor` `ma` ON `m`.`id` = `ma`.`movie_id` "
            . "    LEFT JOIN `actor` `a` ON `ma`.`actor_id` = `a`.`id` "
            . "WHERE `m`.`name` LIKE ? "
            . "    OR concat(`a`.`last_name`, ' ', `a`.`first_name`) LIKE ? "
            . "ORDER BY `m`.`name` "
        );
        $stmt->execute([$query, $query]);
        return $stmt->fetchAll();
    }

    public function add_actor($first_name, $last_name) {
        $stmt = $this->pdo->prepare("INSERT INTO `actor`(`first_name`, `last_name`) VALUES (?, ?)");
        $stmt->execute([$first_name, $last_name]);
        return $this->pdo->lastInsertId();
    }

    public function add_actor_to_movie($movie_id, $actor_id) {
        $stmt = $this->pdo->prepare("INSERT INTO `movie_actor`(`movie_id`, `actor_id`) VALUES (?, ?)");
        $stmt->execute([$movie_id, $actor_id]);
    }
}
