<?php
include 'header.php';
include 'connect.php'; // Include the file to connect to the database

define('UPLPATH', 'images/');

// Get the article ID from the URL
$id = $_GET['id'];

// Query to retrieve the full article
$query = "SELECT naslov, kratki_sadrzaj, sadrzaj, slika, datum FROM vijesti WHERE id = $id";
$result = mysqli_query($dbc, $query);
$row = mysqli_fetch_array($result);

?>

<main>
    <section class="content">
        <h2><?php echo $row['naslov']; ?></h2>
        <img src="<?php echo UPLPATH . $row['slika']; ?>" alt="<?php echo $row['naslov']; ?>">
        <p><?php echo $row['datum']; ?></p>
        <p><?php echo $row['kratki_sadrzaj']; ?></p>
        <p><?php echo $row['sadrzaj']; ?></p>
    </section>
</main>
<?php
include 'footer.php';
?>
</body>
</html>
