<!-- Login Page -->
<?php
require_once("../classes/database.php");

?>
<div class="center">
    <?php
    if (isset($_COOKIE['temp_message'])) {
        echo "<b>" . $_COOKIE['temp_message'] . "</b>";
        // Unset the flash message cookie
        setcookie('temp_message', '', time() - 3600, "/");
    }
    ?>
    <h1>Logg inn</h1>
    <p>Logg inn på kontoen din</p>
    <form action="login.php" method="post">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required title="Vennligst fyll inn en gyldig e-postadresse." oninvalid="this.setCustomValidity('Vennligst fyll inn en email.')" oninput="this.setCustomValidity('')"><br>
        <label for="password">Passord:</label><br>
        <input type="password" id="password" name="password" required title="Vennligst fyll inn et passord." oninvalid="this.setCustomValidity('Vennligst fyll inn et passord.')" oninput="this.setCustomValidity('')"><br>
        <input type="submit" value="Logg inn" name="login">
    </form>
    <p>Har du ikke en konto? <a href="sign_up.php">Opprett en bruker</a></p>

    <?php
    // Check if login form is submitted
    if (isset($_POST['login'])) {

        // Check if email or password field is not empty
        if ($_POST['email'] != "" || $_POST['password'] != "") {

            // Get email from form
            $email = $_POST['email'];

            // Get password from form
            $password = $_POST['password'];

            $pdo = new Database($pdo);

            $user = $pdo->selectUserFromDBEmail($email);

            // Check if user exists
            if ($user != null) {

                // Verify the password
                if (password_verify($password, $user->password)) {

                    // Start a new session
                    session_start();

                    // Store user ID in session
                    $_SESSION['userID'] = $user->userID;

                    // Redirect to index.php
                    header('location: index.php');
                } else {

                    // Incorrect password
                    echo "Feil email eller passord";
                }
            } else {

                // Incorrect email or password
                echo "Feil email eller passord";
            }
        } else {

            // Required field is empty
            echo "Vennligst fyll ut alle skjemafelt!<br>";
        }
    }

    ?>
</div>