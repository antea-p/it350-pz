<?php
include 'data/repository.php';
include 'helpers/table.php';

$repository = create_repository();
$table_name = 'SponsorAward';
$primary_key = ['id_sponsor', 'id_award'];
$columns = ['sponsor_name', 'award_name'];

$rows = $repository->get_sponsorAwards();

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
