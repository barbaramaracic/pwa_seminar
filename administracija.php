<?php
session_start();
include 'header.php';
include 'connect.php';

if (!isset($_SESSION['korisnicko_ime'])) {
    header('Location: login.php');
    exit;
}

if ($_SESSION['admin']) {
    // Kod za administraciju
    // Obrada brisanja
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];
        $query = "DELETE FROM Vijesti WHERE id = $delete_id";
        mysqli_query($dbc, $query) or die('Error querying database.');
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    // Obrada uređivanja
    if (isset($_POST['edit_id'])) {
        $edit_id = $_POST['edit_id'];
        $datum = $_POST['datum'];
        $naslov = $_POST['naslov'];
        $kratki_sadrzaj = $_POST['kratki_sadrzaj'];
        $sadrzaj = $_POST['sadrzaj'];
        $slika = $_POST['slika'];
        $kategorija = $_POST['kategorija'];
        $arhiva = $_POST['arhiva'];

        $query = "UPDATE Vijesti SET datum=?, naslov=?, kratki_sadrzaj=?, sadrzaj=?, slika=?, kategorija=?, arhiva=? WHERE id=?";
        $stmt = $dbc->prepare($query);
        $stmt->bind_param('sssssssi', $datum, $naslov, $kratki_sadrzaj, $sadrzaj, $slika, $kategorija, $arhiva, $edit_id);
        $stmt->execute() or die('Error querying database.');
        $stmt->close();
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    // Dohvaćanje unosa iz baze podataka
    $query = "SELECT * FROM Vijesti";
    $result = mysqli_query($dbc, $query) or die('Error querying database.');

    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Administratorska stranica</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>

    <h1>Administratorska stranica</h1>

    <!-- Dodaj logout gumb -->
    <form action="logout.php" method="post">
        <input type="submit" value="Odjava">
    </form>

    <h2>Unosi</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Datum</th>
            <th>Naslov</th>
            <th>Kratki sadržaj</th>
            <th>Akcije</th>
        </tr>
        <?php while ($row = mysqli_fetch_array($result)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['datum']; ?></td>
                <td><?php echo $row['naslov']; ?></td>
                <td><?php echo $row['kratki_sadrzaj']; ?></td>
                <td>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?edit_id=<?php echo $row['id']; ?>">Uredi</a> |
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?delete_id=<?php echo $row['id']; ?>">Izbriši</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <?php
    // Prikaz forme za uređivanje
    if (isset($_GET['edit_id'])) {
        $edit_id = $_GET['edit_id'];
        $query = "SELECT * FROM Vijesti WHERE id = ?";
        $stmt = $dbc->prepare($query);
        $stmt->bind_param('i', $edit_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        ?>
        <h2>Uredi unos</h2>
        <form class="edit-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
            <label for="datum">Datum:</label>
            <input type="text" id="datum" name="datum" value="<?php echo $row['datum']; ?>">
            <label for="naslov">Naslov:</label>
            <input type="text" id="naslov" name="naslov" value="<?php echo $row['naslov']; ?>">
            <label for="kratki_sadrzaj">Kratki sadržaj:</label>
            <input type="text" id="kratki_sadrzaj" name="kratki_sadrzaj" value="<?php echo $row['kratki_sadrzaj']; ?>">
            <label for="sadrzaj">Sadržaj:</label>
            <textarea id="sadrzaj" name="sadrzaj"><?php echo $row['sadrzaj']; ?></textarea>
            <label for="slika">Slika:</label>
            <input type="text" id="slika" name="slika" value="<?php echo $row['slika']; ?>">
            <label for="kategorija">Kategorija:</label>
            <input type="text" id="kategorija" name="kategorija" value="<?php echo $row['kategorija']; ?>">
            <label for="arhiva">Arhiva:</label>
            <input type="text" id="arhiva" name="arhiva" value="<?php echo $row['arhiva']; ?>">
            <input type="submit" value="Spremi">
        </form>
        <?php
        $stmt->close();
    }
    ?>
<?php
include 'footer.php';
?>
    </body>
    </html>

    <?php
} else {
    echo "Pozdrav " . $_SESSION['ime'] . ", nemate dovoljna prava za
pristup ovoj stranici.";
?>
    <!-- Logout button -->
    <form action="logout.php" method="post">
        <input type="submit" value="Odjava">
    </form>
    <?php
}
?>
