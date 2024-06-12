<?php
include 'header.php';
include 'connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $korisnicko_ime = $_POST['korisnicko_ime'];
    $lozinka = $_POST['lozinka'];

    $stmt = $dbc->prepare("SELECT id, lozinka, ime, admin FROM korisnik WHERE korisnicko_ime = ?");
    $stmt->bind_param('s', $korisnicko_ime);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_lozinka, $ime, $admin);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($lozinka, $hashed_lozinka)) {
            $_SESSION['korisnicko_ime'] = $korisnicko_ime;
            $_SESSION['ime'] = $ime;
            $_SESSION['admin'] = $admin;
            header('Location: administracija.php');
        } else {
            echo "Pogrešna lozinka.";
        }
    } else {
        echo "Korisničko ime ne postoji. Molimo <a href='registracija.php'>registrirajte se</a>.";
    }

    $stmt->close();
    $dbc->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Prijava</title>
</head>
<body>

<h2>Prijava</h2>
<form method="post" action="login.php">
    Korisničko ime: <input type="text" name="korisnicko_ime" required><br>
    Lozinka: <input type="password" name="lozinka" required><br>
    <input type="submit" value="Prijavi se">
</form>
<?php
include 'footer.php';
?>
</body>
</html>
