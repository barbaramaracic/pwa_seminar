<?php
include 'header.php';
include 'connect.php';

define('UPLPATH', 'img/');

if(isset($_POST['update'])){
    $id=$_POST['id'];
    $picture = $_FILES['pphoto']['name'];
    $title=$_POST['title'];
    $about=$_POST['about'];
    $content=$_POST['content'];
    $category=$_POST['category'];
    $archive = isset($_POST['archive']) ? 1 : 0;

    if(!empty($picture)) {
        $target_dir = 'img/'.$picture;
        move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_dir);
        $query = "UPDATE vijesti SET naslov='$title', sazetak='$about', tekst='$content', slika='$picture', kategorija='$category', arhiva='$archive' WHERE id=$id ";
    } else {
        $query = "UPDATE vijesti SET naslov='$title', sazetak='$about', tekst='$content', kategorija='$category', arhiva='$archive' WHERE id=$id ";
    }
    $result = mysqli_query($dbc, $query);
}

if(isset($_POST['delete'])){
    $id=$_POST['id'];
    $query = "DELETE FROM vijesti WHERE id=$id ";
    $result = mysqli_query($dbc, $query);
}

$query = "SELECT * FROM vijesti";
$result = mysqli_query($dbc, $query);

echo '<form enctype="multipart/form-data" action="" method="POST">';

while ($row = mysqli_fetch_array($result)) {
    echo '<div class="form-item">
            <label for="title">Naslov vijesti:</label>
            <div class="form-field">
                <input type="text" name="title" class="form-field-textual" value="'.$row['naslov'].'">
            </div>
          </div>
          <div class="form-item">
            <label for="about">Kratki sadržaj vijesti (do 50 znakova):</label>
            <div class="form-field">
                <textarea name="about" cols="30" rows="10" class="formfield-textual">'.$row['sazetak'].'</textarea>
            </div>
          </div>
          <div class="form-item">
            <label for="content">Sadržaj vijesti:</label>
            <div class="form-field">
                <textarea name="content" cols="30" rows="10" class="formfield-textual">'.$row['tekst'].'</textarea>
            </div>
          </div>
          <div class="form-item">
            <label for="pphoto">Slika:</label>
            <div class="form-field">
                <input type="file" class="input-text" id="pphoto" name="pphoto"/> <br><img src="' . UPLPATH . $row['slika'] . '" width=100px>
            </div>
          </div>
          <div class="form-item">
            <label for="category">Kategorija vijesti:</label>
            <div class="form-field">
                <select name="category" class="form-field-textual">
                    <option value="sport" '.($row['kategorija']=='sport' ? 'selected' : '').'>Sport</option>
                    <option value="kultura" '.($row['kategorija']=='kultura' ? 'selected' : '').'>Kultura</option>
                </select>
            </div>
          </div>
          <div class="form-item">
            <label>Spremiti u arhivu:
            <div class="form-field">';
                if($row['arhiva'] == 0) {
                    echo '<input type="checkbox" name="archive" id="archive"/> Arhiviraj?';
                } else {
                    echo '<input type="checkbox" name="archive" id="archive" checked/> Arhiviraj?';
                }
            echo '</div>
            </label>
          </div>
          <input type="hidden" name="id" class="form-field-textual" value="'.$row['id'].'">';
}

echo '<div class="form-item">
        <button type="reset" value="Poništi">Poništi</button>
        <button type="submit" name="update" value="Prihvati">Izmjeni</button>
        <button type="submit" name="delete" value="Izbriši">Izbriši</button>
      </div>
    </form>';

include 'footer.php';
?>
