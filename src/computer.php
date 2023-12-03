<?php
include 'data/repository.php';
include 'helpers/table.php';

$repository = create_repository();
$table_name = 'Computer';
$primary_key = 'id_computer';
$columns = ['cpu_model', 'gpu_model', 'ram_gb', 'ip_address'];

if (!empty($_POST)) {
    if ($_POST['submit'] === 'Add') {
        $repository->insert_computer($_POST[$primary_key], $_POST['cpu_model'], $_POST['gpu_model'], $_POST['ram_gb'], $_POST['ip_address']);
    } elseif ($_POST['submit'] === 'Update') {
        $repository->update_computer($_POST[$primary_key], $_POST['cpu_model'], $_POST['gpu_model'], $_POST['ram_gb'], $_POST['ip_address']);
    } elseif ($_POST['submit'] === 'Delete') {
        $repository->delete_computer($_POST[$primary_key]);
    }
}

$rows = $repository->get_computers();

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
