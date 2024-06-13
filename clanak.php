<?php
include 'header.php';
include 'connect.php';

define('UPLPATH', 'images/');

$id = $_GET['id'];

$query = "SELECT naslov, kratki_sadrzaj, sadrzaj, slika, datum, kategorija FROM vijesti WHERE id = $id";
$result = mysqli_query($dbc, $query);
$row = mysqli_fetch_array($result);
?>

<main>
    <section class="article-box">
        <div class="article-content">
            <p class="category-text"><?php echo $row['kategorija']; ?></p>
            <h2><?php echo $row['naslov']; ?></h2>
            <h3><?php echo $row['kratki_sadrzaj']; ?></h3>
            <img src="<?php echo UPLPATH . $row['slika']; ?>" alt="<?php echo $row['naslov']; ?>">
            <p><?php echo $row['sadrzaj']; ?></p>
            <p><?php echo $row['datum']; ?></p>
        </div>
    </section>
</main>

<?php
include 'footer.php';
?>
