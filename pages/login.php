<div class="content">
    <form name="login" method="POST" enctype="multipart/form-data" action=" ">
        <label for="username">Gebruikersnaam</label>
        <input class="forminput" required type="username" name="username" /><br>
        <label for="password">Wachtwoord</label>
        <input class="forminput" required type="password" name="password"/>
        <div class="icon_container">
            <input type="submit" class="loginbtn" id="submit" name="submit" value="[LOGIN]"/>
        </div><br>
        <a class="link" href="register.php">[REGISTREREN]</a><br>
        <a class="link" href="forgot_password.php">[WACHTWOORD VERGETEN]</a>
    </form>
</div>
    <?php
    if(isset($_POST["submit"])) {
        $alert = "";
        $email = htmlspecialchars($_POST["username"]);
        $password = htmlspecialchars($_POST["password"]);
        try {
            $sql = "SELECT * FROM user WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute(array($email));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result) {
                $passwordInDatabase = $result["password"];
                $rol = $result["is_admin"];
                if(password_verify($password,$passwordInDatabase)){
                    $_SESSION["ID"] = session_id();
                    $_SESSION["USER_ID"] = $result["id"];
                    $_SESSION["USER_NAME"] = $result["username"];
                    $_SESSION["E-MAIL"] = $result["email"];
                    $_SESSION["STATUS"] = "ACTIEF";
                    $_SESSION["ROL"] = $rol;

                    if($rol == 0){
                        echo "<script>location.href='index.php?page=movie_list'</script>";
                    } elseif($rol == 1){
                        echo "<script>location.href='index.php?page=add_movie';</script>";
                    } else {
                        $alert = "Toegang geweigerd<br>";
                    }
                } else {
                    $alert = "Probeer nogmaals in te loggen<br>";
                }
            } else {
                $alert = "Probeer nogmaals in te loggen<br>";
            }
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
            echo "<div id='melding'>$alert</div>";
    }
?>