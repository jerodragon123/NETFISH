<?php
    if(!isset($_SESSION["ID"])&&($_SESSION["STATUS"]!="ACTIEF")){
        echo "<script> alert('U heeft geen toegang tot deze pagina.'); location.href='../index.php';</script>";
    }
    try {
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($_SESSION["E-MAIL"] ));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }catch(PDOException $e) {
        echo $e->getMessage();
    }

    try {
        $sql = 'DELETE FROM movie WHERE id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($_GET["id"] ));
    }catch(PDOException $e) {
        echo $e->getMessage();
    }
    header('location:index.php?page=movie_edit');