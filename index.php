<?php


$connection = require_once './Connection.php';

//$tasks = $connection->getNotes();

$currentNote = [
    'id' => '',
    'title' => '',
    'description' => '',
];

if (isset($_GET['id'])) {
    $currentNote = $connection->getNoteById($_GET['id']);
}

//echo '<pre>';
//var_dump($currentNote);
//echo '</pre>';

$page = '';
$limit = '3';
$start = '';

if ($page = isset($_GET['page']) ? (int)$_GET['page'] : 1) {
    $start = ($page > 1) ? ($page * $limit) - $limit : 0;
}

$pages = $connection->getTotalPagesPagination($limit);
$tasks = $connection->getNotesPagination($start, $limit);

?>
<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="cssflex.css">
</head>
<body>
<div>

    <form class="new-task-list" action="save.php" method="post">
        <input type="hidden" name="id" value="<?php echo $currentNote['id'] ?>">
        <input type="text" name="title" placeholder="Задача" autocomplete="off"
               value="<?php echo $currentNote['title'] ?>">
        <textarea name="description" rows="10" placeholder="Описание"><?php echo $currentNote['description'] ?>
        </textarea>
        <button>
            <?php if ($currentNote['id']): ?>
                Обновить задачу
            <?php else: ?>
                Добавить задачу
            <?php endif; ?>
        </button>
    </form>

    <div class="tasks-added">
        <?php foreach ($tasks as $task): ?>
            <div class="task">

                <div class="title">
                    <a href="?id=<?php echo $task['id'] ?>"><?php echo $task['title']; ?></a>
                </div>

                <div class="description">
                    <?php echo $task['description'] ?>
                </div>

                <small><?php echo $task['create_date'] ?></small>

                <form action="delete.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $task['id'] ?>">
                    <button class="close">Удалить</button>
                </form>

            </div>

        <?php endforeach; ?>


    </div>

    <div class="pagination">
        <?php for ($x = 1; $x <= $pages; $x++): ?>
            <a href="?page=<?php echo $x; ?>"><?php echo $x; ?></a>
        <?php endfor; ?>
    </div>

    <!--    <div class="pagination">-->
    <!--        <a href="#">&laquo;</a>-->
    <!--        <a href="#" class="active">1</a>-->
    <!--        <a href="#">2</a>-->
    <!--        <a href="#">3</a>-->
    <!--        <a href="#">4</a>-->
    <!--        <a href="#">&raquo;</a>-->
    <!--    </div>-->


</body>
</html>




