<?php
include 'header.php';
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $korisnicko_ime = $_POST['korisnicko_ime'];
    $lozinka = password_hash($_POST['lozinka'], PASSWORD_BCRYPT); // Hashiranje lozinke
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    
    $lozinka_potvrda = $_POST['lozinka_potvrda'];
    
    // Provjera da li su lozinke identične
    if($_POST['lozinka'] != $_POST['lozinka_potvrda']) {
        echo "Lozinke se ne podudaraju. Molimo unesite ih ponovno.";
    } else {
        $stmt = $dbc->prepare("INSERT INTO korisnik (korisnicko_ime, lozinka, ime, prezime) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $korisnicko_ime, $lozinka, $ime, $prezime);
    
        if ($stmt->execute()) {
            echo "Registracija uspješna. Možete se <a href='login.php'>prijaviti</a>.";
        } else {
            echo "Greška prilikom registracije: " . $stmt->error;
        }
    
        $stmt->close();
        $dbc->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registracija</title>
</head>
<body>

<h2>Registracija</h2>
<form method="post" action="registracija.php">
    Korisničko ime: <input type="text" name="korisnicko_ime" required><br>
    Lozinka: <input type="password" name="lozinka" required><br>
    Potvrdite lozinku: <input type="password" name="lozinka_potvrda" required><br> <!-- Dodano polje za potvrdu lozinke -->
    Ime: <input type="text" name="ime"><br>
    Prezime: <input type="text" name="prezime"><br>
    <input type="submit" value="Registriraj se">
</form>
<?php
include 'footer.php';
?>
</body>
</html>
