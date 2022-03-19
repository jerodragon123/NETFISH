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
?>

<?php

$pdo = require 'DBconfig.php';

$sql = 'SELECT * FROM movie';

$statement = $conn->query($sql);

// get all publishers
$publishers = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($publishers) {
	// show the publishers
	foreach ($publishers as $publisher) {
		echo $publisher['title'] . ' | ';
        echo $publisher['year'] . ' | ';
        ?>
        <a href="index.php?page=delete&id=<?php echo $publisher['id']; ?>">Delete</a><br>
        <?php
	}
}
?>