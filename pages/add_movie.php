<?php
if(!isset($_SESSION["ID"])&&$_SESSION["STATUS"]!="ACTIEF"){
    echo "<script alert('U heeft geen toegang tot deze pagina.'); location.href='../index.php';</script>";
}
try {
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($_SESSION["E-MAIL"] ));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $alert = "";
}catch(PDOException $e) {
    echo $e->getMessage();
}

    // (A) PROCESS RESERVATION
    if (isset($_POST['submit'])) {
      require "insert_movie.php";
      if ($_RSV->save(
        $_POST['title'], $_POST['url'], $_POST['year'], $_POST['description'])) {
      } else { $alert = 'Error'; }
    }
?>

    <!-- (B) RESERVATION FORM -->
    <div class="content">
        <form id="movieForm" method="post" target="_self">
            <label for="title">Titel</label>
            <input class="forminput" type="text" required name="title"/>
            <label for="url">Url</label>
            <input class="forminput" type="url" required name="url"/>
            <label for="year">Year</label>
            <input class="forminput" type="text" required name="year" min="1900" max="9999"/>
            <label for="">Beschrijving</label>
            <input class="forminput" type="text" required name="description"/>
            <div class="icon_container">
                <input type="submit" class="link" id="submit" name="submit" value="[TOEVOEGEN]"/>
            </div>
        </form>
    </div>