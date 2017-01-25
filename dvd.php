<?php
if(empty($_REQUEST['title'])) {
    header('Location: index.php');
}

$host = 'itp460.usc.edu';
$database_name = 'dvd';
$username = 'student';
$password = 'ttrojan';

$pdo = new PDO("mysql:host=$host;dbname=$database_name", $username, $password);

$sql = "SELECT title, genre_name, format_name, rating_name
FROM dvds
INNER JOIN genres ON dvds.genre_id = genres.id
INNER JOIN formats ON dvds.format_id = formats.id
INNER JOIN ratings ON dvds.rating_id = ratings.id
WHERE title LIKE ?";
// dvds.genre_id = genres.id AND
// dvds.format_id = formats.id
//  AND dvds.rating_id = ratings.id AND
// title LIKE ?";

$statement = $pdo->prepare($sql);
$like = '%' . $_GET['title'] . '%';
$statement->bindParam(1, $like);
$statement->execute();
$dvds = $statement->fetchAll(PDO::FETCH_OBJ);


?>

<ul>
   <p> You searched for "<?php echo  $_GET['title']?>" </p>
    <?php foreach($dvds as $dvd) : ?>
        <h2><?= $dvd->title ?></h2>
        <p>Genre: <?= $dvd->genre_name?></p>
        <p>Format: <?= $dvd->format_name?></p>
        <p>Rating: <?= $dvd->rating_name?></p>
        <p><a href="ratings.php?rating=<?= $dvd->rating_name ?>">View other <?= $dvd->rating_name?> rated movies</a></p>
        <br>
    <?php endforeach; ?>

    <?php
    if (empty($dvds)) {
        echo "<h2>No results </h2>";
        echo "<a href='/'>Return to search</a>";
    }
    ?>
</ul>
