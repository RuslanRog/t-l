<?php

class Connection
{
    public PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:server=localhost; dbname=task_list', 'root');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    public function getNotesPagination($start, $limit)
    {
        $statment = $this->pdo->prepare("SELECT SQL_CALC_FOUND_ROWS id, title, description, create_date FROM task_list LIMIT {$start}, {$limit}");
        $statment->execute();
        return $statment = $statment->fetchAll(PDO::FETCH_ASSOC);
//        echo '<pre>';
//        var_dump($statment);
//        echo '</pre>';
    }

    public function getTotalPagesPagination($limit)
    {
        $total = $this->pdo->query("SELECT FOUND_ROWS() as total")->fetch()['total'];
        return $pages = ceil($total / $limit);
    }

//    public function getNotes(): array
//    {
//        $statment = $this->pdo->prepare("SELECT * FROM task_list ORDER BY create_date DESC");
//        $statment->execute();
//        return $statment->fetchAll(PDO::FETCH_ASSOC);
//    }

    public function addNote($note): bool
    {
        $statment = $this->pdo->prepare("INSERT INTO task_list(title, description, create_date) VALUE (:title, :description, :date)");
        $statment->bindValue('title', $note['title']);
        $statment->bindValue('description', $note['description']);
        $statment->bindValue('date', date('Y-m-d H:i:s')); // H:i:S
        // var_dump($a);
        // exit;
        return $statment->execute();
    }

    public function getNoteById($id): array
    {
        $statment = $this->pdo->prepare("SELECT * FROM task_list WHERE id = :id");
        $statment->bindValue('id', $id);
        $statment->execute();
        return $statment->fetch(PDO::FETCH_ASSOC);
    }

    public function updateNote($id, $note): bool
    {
        $statment = $this->pdo->prepare("UPDATE task_list SET title = :title, description = :description WHERE id = :id");
        $statment->bindValue('id', $id);
        $statment->bindValue('title', $note['title']);
        $statment->bindValue('description', $note['description']);
        return $statment->execute();
    }

    public function removeNote($id): bool
    {
        $statment = $this->pdo->prepare("DELETE FROM task_list WHERE id = :id");
        $statment->bindValue('id', $id);
        return $statment->execute();
    }
}

return new Connection();