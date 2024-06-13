<?php
include 'header.php';
include 'connect.php';

define('UPLPATH', 'images/');

$kategorija = isset($_GET['kategorija']) ? $_GET['kategorija'] : '';

$query = "SELECT id, naslov, kratki_sadrzaj, slika, datum FROM vijesti WHERE arhiva = 0 AND kategorija = '$kategorija' ORDER BY datum DESC";
$result = mysqli_query($dbc, $query);

if (!$result) {
    die('Error querying database: ' . mysqli_error($dbc));
}
?>

<main>
    <section class="content">
        <h2><?php echo ucfirst($kategorija); ?></h2>
        <div class="articles">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    echo '<article>';
                    echo '<img src="' . UPLPATH . $row['slika'] . '" alt="' . $row['naslov'] . '" style="width:100%; height:auto;">';
                    echo '<h3 class="title"><a href="clanak.php?id=' . $row['id'] . '">' . $row['naslov'] . '</a></h3>';
                    echo '</article>';
                }
            } else {
                echo '<p>No news available in this category.</p>';
            }
            ?>
        </div>
    </section>
</main>
<?php
include 'footer.php';
?>
</body>
</html>
