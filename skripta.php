<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naslov = htmlspecialchars($_POST['naslov']);
    $kratki_sadrzaj = htmlspecialchars($_POST['kratki_sadrzaj']);
    $sadrzaj = htmlspecialchars($_POST['sadrzaj']);
    $kategorija = htmlspecialchars($_POST['kategorija']);
    $arhiva = isset($_POST['arhiva']) ? 'Da' : 'Ne';

    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["slika"]["name"]);
    if (move_uploaded_file($_FILES["slika"]["tmp_name"], $target_file)) {
        $slika = $target_file;
    } else {
        $slika = 'uploads/default.jpg';
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title><?php echo $naslov; ?></title>
</head>
<body>
    <header>
        <h1>Le Monde</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="politika.html">Politika</a></li>
                <li><a href="sport.html">Sport</a></li>
                <li><a href="kultura.html">Kultura</a></li>
                <li><a href="unos.html">Unos vijesti</a></li>
            </ul>
        </nav>
    </header>
    <main style="margin-bottom:50px">
        <section class="content">
        <p class="category" style="color: #666; font-weight: bold;"><?php echo strtoupper($kategorija); ?></p>
            <h2><?php echo $naslov; ?></h2>
            <p><?php echo $kratki_sadrzaj; ?></p>
            <img src="<?php echo $slika; ?>" alt="News Image">
            <p><?php echo $sadrzaj; ?></p>
        </section>
        <div class="footer-space"></div>
    </main>
</body>
</html>
