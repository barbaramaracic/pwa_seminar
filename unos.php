<?php
include 'header.php';
?>
    <main>
        <section class="content">
            <h2 class="centered">Unos vijesti</h2>
            <?php
            // Include the database connection file
            include 'connect.php';

            // Check if form data is submitted
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Retrieve form data
                $naslov = $_POST['naslov'];
                $kratki_sadrzaj = $_POST['kratki_sadrzaj'];
                $sadrzaj = $_POST['sadrzaj'];
                $kategorija = $_POST['kategorija'];
                $arhiva = isset($_POST['arhiva']) ? 1 : 0;

                // Handle file upload
                $slika = $_FILES['slika']['name'];
                $target_dir = 'images/' . $slika;
                move_uploaded_file($_FILES['slika']['tmp_name'], $target_dir);

                // Insert data into database
                $query = "INSERT INTO Vijesti (datum, naslov, kratki_sadrzaj, sadrzaj, slika, kategorija, arhiva, vijest_time) 
                VALUES (NOW(), '$naslov', '$kratki_sadrzaj', '$sadrzaj', '$slika', '$kategorija', '$arhiva', NOW())";
  
      $result = mysqli_query($dbc, $query) or die('Error querying database: ' . mysqli_error($dbc));
                // Close database connection
                mysqli_close($dbc);

                // Display success message
                echo '<p>Vijest uspješno unesena!</p>';
            }
            ?>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                <label for="naslov">Naslov vijesti</label>
                <input type="text" id="naslov" name="naslov" required>
                
                <label for="kratki_sadrzaj">Kratki sadržaj vijesti (do 50 znakova)</label>
                <textarea id="kratki_sadrzaj" name="kratki_sadrzaj" maxlength="50" required></textarea>
                
                <label for="sadrzaj">Sadržaj vijesti</label>
                <textarea id="sadrzaj" name="sadrzaj" required></textarea>
                
                <label for="slika">Slika:</label>
                <input type="file" id="slika" name="slika" accept="image/*" required>
                
                <label for="kategorija">Kategorija vijesti</label>
                <select id="kategorija" name="kategorija" required>
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
    <?php
include 'footer.php';
?>
</body>
</html>
