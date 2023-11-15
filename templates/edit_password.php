<!-- HTML form for password updating -->

<?php

include_once('../includes/db.inc.php');
include_once('../classes/database.php');

// using the database.php class to get the user information from the database
$userDB = new Database($pdo);
$user = $userDB->fetchUserFromDB($_SESSION['userID']);


// Check if the 'update' button has been clicked
if (isset($_POST['update'])) {

    // Check if the password fields are not empty
    if ($_POST['oldpassword'] != "" || $_POST['newpassword'] != "" || $_POST['repetepassword'] != "") {

        if ($_POST['newpassword'] == $_POST['repetepassword'] && password_verify($_POST['oldpassword'], $user->password)) {

            $password = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);

            // using the database.php class to update the user information in the database
            $userDB->updatePasswordInDB($password, $_SESSION['userID']);

            // Redirect the user to index.php
            header('location:profile.php');
            $_SESSION['message'] = "Ditt passord er oppdatert";
        } else {
            echo "Passordene er ikke like. Prøv på nytt.";
        }
    } else {
        // Print a message if the fields are empty and redirect the user to the registration page
        echo "Please fill up the required field!";
        header('location:edit_profile.php');
    }
}

?>
<div>
    <h1>Oppdatere Passord</h1>
    <p>Følg stegende under for å opppdatere ditt passord</p>
    <form action="" method="post">
        <label for="password">Gammelt Passord:</label><br>
        <input type="password" id="password" name="oldpassword" required oninvalid="this.setCustomValidity('Vennligst fyll inn ditt gamle passord.')" oninput="this.setCustomValidity('')"><br>
        <label for="password">Nytt Passord:</label><br>
        <input type="password" id="password" name="newpassword" required oninvalid="this.setCustomValidity('Vennligst fyll inn et nytt passord.')" oninput="this.setCustomValidity('')"><br>
        <label for="password">Repeter Nytt Passord:</label><br>
        <input type="password" id="password" name="repetepassword" required oninvalid="this.setCustomValidity('Vennligst repeter nytt passord.')" oninput="this.setCustomValidity('')"><br>
        <input type="submit" value="Lagre endringer" name="update">
        <input type="button" value="Gå tilbake" onclick="history.back()">
    </form>
</div>