<?php
include 'header.php';
include 'connect.php';

define('UPLPATH', 'images/');

$query_sport = "SELECT * FROM vijesti WHERE arhiva = 0 AND kategorija = 'sport' ORDER BY vijest_time DESC LIMIT 3";
$result_sport = mysqli_query($dbc, $query_sport);

$query_kultura = "SELECT * FROM vijesti WHERE arhiva = 0 AND kategorija = 'kultura' ORDER BY vijest_time DESC LIMIT 3";
$result_kultura = mysqli_query($dbc, $query_kultura);
?>

<main>
    <section class="content">
        <hr class="section-divider">
        <h2>Sport</h2>
        <div class="articles">
            <?php
            while ($row_sport = mysqli_fetch_array($result_sport)) {
                echo '<article>';
                echo '<img src="' . UPLPATH . $row_sport['slika'] . '" alt="' . $row_sport['naslov'] . '" style="width:100%; height:auto;">';
                echo '<h3 class="title"><a href="clanak.php?id=' . $row_sport['id'] . '">' . $row_sport['naslov'] . '</a></h3>';
                echo '</article>';
            }
            ?>
        </div>
    </section>

    <section class="content">
        <hr class="section-divider">
        <h2>Kultura</h2>
        <div class="articles">
            <?php
            while ($row_kultura = mysqli_fetch_array($result_kultura)) {
                echo '<article>';
                echo '<img src="' . UPLPATH . $row_kultura['slika'] . '" alt="' . $row_kultura['naslov'] . '" style="width:100%; height:auto;">';
                echo '<h3 class="naslov"><a href="clanak.php?id=' . $row_kultura['id'] . '">' . $row_kultura['naslov'] . '</a></h3>';
                echo '</article>';
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
