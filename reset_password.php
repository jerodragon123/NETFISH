<!DOCTYPE html>
<html lang="en">
<?php include_once("header.html"); ?>
    <head>
        <title>Netfish</title>
        <link rel="stylesheet" href="css/stylesheet.scss"/>
    </head>
    <body>
        <div class="content">
            <form name="resetformulier" method="POST" enctype="multipart/form-data" action="" onsubmit="if(document.resetformulier.password1 !== document.resetformulier.password2){alert('Wachtwoorden moeten gelijk zijn'); return false;">
                <label for="email">Email</label>
                <input class="forminput" required type="email" name="email"/><br>
                <label for="password1">Nieuw Wachtwoord</label>
                <input class="forminput" required type="password" name="password1"/>
                <label for="password2">Wachtwoord ter controle</label>
                <input class="forminput" required type="password" name="password2"/><br>
                <div class="icon_container">
                    <input type="submit" class="link" id="submit" name="submit" value="[RESET]"/>
                </div>
            </form>
        </div>
    </body>
</html>

<?php
if(isset($_POST["submit"])) {
    if(isset($_GET["token"]) && isset($_GET["timestamp"])) {
        $token = $_GET["token"];
        $timestamp1 = $_GET["timestamp"];
        $alert = "";
        // Zoek in database de e-mail en het token uit de link
        include("DBconfig.php");
        $email = htmlspecialchars($_POST["email"]);
        $password = htmlspecialchars($_POST["password1"]);
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        try {
            $sql = "SELECT * FROM user WHERE email = ? AND token = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute(array($email, $token));
            $stmt = $stmt->fetch(PDO::FETCH_ASSOC);
            // Hier controleren we of de link verlopen is
            if($stmt) {
                $timestamp2 = new DateTime("now");
                $timestamp2 = $timestamp2->getTimestamp();
                $dif = $timestamp2 - $timestamp1;
                // Als de link geldig is slaan we het nieuwe wachtwoord op
                if(($timestamp2 - $timestamp1) < 43200){
                    $query = "UPDATE user SET `password` = ? WHERE email = ?";
                    $stmt = $conn->prepare($query);
                    $stmt = $stmt->execute(array($passwordHash, $email));
                    if($stmt) {
                        echo "<script> alert('Uw wachtwoord is gereset.'); location.href='index.php';</script>";
                    }
                }else{
                    echo "<script>alert('Link is verlopen.'); location.href='index.php';</script>";
                }
            }
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>