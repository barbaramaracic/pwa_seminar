<?php include 'header.php'; ?>
<style>
        .error {
            border: 2px solid red;
        }
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: -10px; /* Adjust this value as needed */
            margin-bottom: 10px; /* Ensure there is some space below */
        }
    </style>
<body>
    <main>
        <section class="content">
            <h2 class="centered">Unos vijesti</h2>
            <?php
            include 'connect.php';
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $naslov = $_POST['naslov'];
                $kratki_sadrzaj = $_POST['kratki_sadrzaj'];
                $sadrzaj = $_POST['sadrzaj'];
                $kategorija = $_POST['kategorija'];
                $arhiva = isset($_POST['arhiva']) ? 1 : 0;

                $slika = $_FILES['slika']['name'];
                $target_dir = 'images/' . $slika;
                move_uploaded_file($_FILES['slika']['tmp_name'], $target_dir);

                $query = "INSERT INTO Vijesti (datum, naslov, kratki_sadrzaj, sadrzaj, slika, kategorija, arhiva, vijest_time) 
                          VALUES (NOW(), '$naslov', '$kratki_sadrzaj', '$sadrzaj', '$slika', '$kategorija', '$arhiva', NOW())";
                $result = mysqli_query($dbc, $query) or die('Error querying database: ' . mysqli_error($dbc));
                mysqli_close($dbc);
                echo '<p>Vijest uspješno unesena!</p>';
            }
            ?>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                <label for="naslov">Naslov vijesti</label>
                <input type="text" id="naslov" name="naslov">
                
                <label for="kratki_sadrzaj">Kratki sadržaj vijesti (do 50 znakova)</label>
                <textarea id="kratki_sadrzaj" name="kratki_sadrzaj" maxlength="50"></textarea>
                
                <label for="sadrzaj">Sadržaj vijesti</label>
                <textarea id="sadrzaj" name="sadrzaj"></textarea>
                
                <label for="slika">Slika:</label>
                <input type="file" id="slika" name="slika" accept="image/*">
                
                <label for="kategorija">Kategorija vijesti</label>
                <select id="kategorija" name="kategorija">
                    <option value="">Odaberite kategoriju</option>
                    <option value="politika">Politika</option>
                    <option value="sport">Sport</option>
                    <option value="kultura">Kultura</option>
                </select>
                
                <div class="checkbox-wrapper">
                    <label for="arhiva">Spremiti u arhivu:</label>
                    <input type="checkbox" id="arhiva" name="arhiva">
                </div>
                
                <div class="form-buttons">
                    <button type="reset">Poništi</button>
                    <button type="submit">Prihvati</button>
                </div>
            </form>
        </section>
    </main>
    <?php include 'footer.php'; ?>
</body>
<script>
    function validateForm(event) {
        // Get form elements
        const naslov = document.getElementById('naslov');
        const kratki_sadrzaj = document.getElementById('kratki_sadrzaj');
        const sadrzaj = document.getElementById('sadrzaj');
        const slika = document.getElementById('slika');
        const kategorija = document.getElementById('kategorija');

        // Validation flags
        let valid = true;

        // Clear previous error messages
        document.querySelectorAll('.error-message').forEach(el => el.remove());
        naslov.classList.remove('error');
        kratki_sadrzaj.classList.remove('error');
        sadrzaj.classList.remove('error');
        slika.classList.remove('error');
        kategorija.classList.remove('error');

        // Validate naslov
        if (naslov.value.length < 5 || naslov.value.length > 30) {
            valid = false;
            naslov.classList.add('error');
            const error = document.createElement('div');
            error.classList.add('error-message');
            error.textContent = 'Naslov vijesti mora imati 5 do 30 znakova.';
            naslov.after(error);
        }

        // Validate kratki_sadrzaj
        if (kratki_sadrzaj.value.length < 10 || kratki_sadrzaj.value.length > 100) {
            valid = false;
            kratki_sadrzaj.classList.add('error');
            const error = document.createElement('div');
            error.classList.add('error-message');
            error.textContent = 'Kratki sadržaj vijesti mora imati 10 do 100 znakova.';
            kratki_sadrzaj.after(error);
        }

        // Validate sadrzaj
        if (sadrzaj.value.trim() === '') {
            valid = false;
            sadrzaj.classList.add('error');
            const error = document.createElement('div');
            error.classList.add('error-message');
            error.textContent = 'Tekst vijesti nesmije biti prazan.';
            sadrzaj.after(error);
        }

        // Validate slika
        if (slika.files.length === 0) {
            valid = false;
            slika.classList.add('error');
            const error = document.createElement('div');
            error.classList.add('error-message');
            error.textContent = 'Slika mora biti odabrana.';
            slika.after(error);
        }

        // Validate kategorija
        if (kategorija.value === '') {
            valid = false;
            kategorija.classList.add('error');
            const error = document.createElement('div');
            error.classList.add('error-message');
            error.textContent = 'Kategorija mora biti odabrana.';
            kategorija.after(error);
        }

        // If form is not valid, prevent submission
        if (!valid) {
            event.preventDefault();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        form.addEventListener('submit', validateForm);
    });
</script>
</html>
