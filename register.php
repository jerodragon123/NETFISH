<?php
include("header.html");
include("register.html");
include("library/mails.php");
include("DBconfig.php");
if(isset($_POST["submit"])) {
    $alert = "";
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password1 = htmlspecialchars($_POST['password1']);
    $passwordHash = password_hash($password1, PASSWORD_DEFAULT);
    $password2 = htmlspecialchars($_POST['password2']);

    // Controleeer of e-mail al bestaat (geen dubbele adressen)
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($email));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result) {
        $alert = "Dit e-mailadres is al geregistreerd";
    } else {
        if($password1 === $password2) {
            $sql = "INSERT INTO user (id, username, email, `password`, is_admin) values (null,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            try {
                $stmt->execute(array(
                    $username,
                    $email,
                    $passwordHash,
                0)
            );
            $alert = "Nieuw account aangemaakt.";
            }catch(PDOException $e) {
                $alert = "Kon geen account aanmaken.";
                $e->getMessage();
    
            }
            echo "<div id='melding'>" .$alert, "</div>";
            // Bevestiging per e-mail
            $subject = "Nieuw account";
            $message = "Geachte $username, uw account is aangemaakt.";
            mailing($email, $username, $subject, $message);            
        } else {
            echo "Wachtwoorden zijn niet hetzelfde";
        }
    }
}
?>