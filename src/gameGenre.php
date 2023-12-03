<?php
include 'data/repository.php';
include 'helpers/table.php';

$repository = create_repository();
$table_name = 'GameGenre';
$primary_key = ['id_genre', 'id_game'];
$columns = ['game_title', 'year'];

$rows = $repository->get_gameGenre();

?>

<html>
<head>
    <title><?php echo $table_name; ?></title>
    <link rel='stylesheet' type='text/css' href='resources/style.css'>
</head>
<body>
<a href="/">Back</a>

<h2>All <?php echo $table_name; ?>s</h2>
<?php
create_table([...$primary_key, ...$columns], $rows, $primary_key);
?>

</body>
</html>
