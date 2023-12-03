<?php
include 'data/repository.php';
include 'helpers/table.php';

$repository = create_repository();
$table_name = 'Game';
$primary_key = 'id_game';
$columns = ['game_title', 'year', 'publisher'];

if (!empty($_POST)) {
    if ($_POST['submit'] === 'Add') {
        $repository->insert_game($_POST[$primary_key], $_POST['game_title'], $_POST['year'], $_POST['publisher']);
    } elseif ($_POST['submit'] === 'Update') {
        $repository->update_game($_POST[$primary_key], $_POST['game_title'], $_POST['year'], $_POST['publisher']);
    } elseif ($_POST['submit'] === 'Delete') {
        $repository->delete_game($_POST[$primary_key]);
    }
}

$rows = $repository->get_games();

?>

<html>
<head>
    <title><?php echo $table_name; ?></title>
    <link rel='stylesheet' type='text/css' href='resources/style.css'>
</head>
<body>
<a href="/">Back</a>

<h2>Add <?php echo $table_name; ?></h2>
<form method="post">
    <?php foreach ([$primary_key, ...$columns] as $column): ?>
        <input type='text' name='<?php echo $column; ?>' placeholder='<?php echo $column; ?>'>
    <?php endforeach; ?>
    <input type='submit' name='submit' value='Add'>
</form>

<h2>All <?php echo $table_name; ?>s</h2>
<?php
create_table([$primary_key, ...$columns], $rows, $primary_key, 'Delete');
?>

<h2>Update <?php echo $table_name; ?></h2>
<form method='post'>
    <select name='<?php echo $primary_key; ?>'>
        <?php foreach ($rows as $row): ?>
            <option value='<?php echo $row[$primary_key]; ?>'><?php echo $row[$primary_key]; ?></option>
        <?php endforeach; ?>
    </select>
    <?php foreach ($columns as $column): ?>
        <input type='text' name='<?php echo $column; ?>' placeholder='<?php echo $column; ?>'>
    <?php endforeach; ?>
    <input type='submit' name='submit' value='Update'>
</form>
</body>
</html>
