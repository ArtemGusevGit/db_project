// user-create
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST["username"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);

    if ($username && $email && $password) {
        try {
            require_once "dbh.inc.php";

            // Check if the username or email already exists
            $checkQuery = "SELECT COUNT(*) FROM users WHERE username = :username OR email = :email";
            $checkStmt = $pdo->prepare($checkQuery);
            $checkStmt->bindParam(":username", $username);
            $checkStmt->bindParam(":email", $email);
            $checkStmt->execute();
            $count = $checkStmt->fetchColumn();

            if ($count > 0) {
                // User already exists, redirect back with an error
                header('Location: ../index.php?error=userexists');
                exit();
            }

            $query = "INSERT INTO users (username, pwd, email) VALUES (:username, :password, :email);";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":email", $email);

            $stmt->execute();

            $pdo = null;
            $stmt = null;

            header('Location: ../index.php?success=usercreated');
            exit();

        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    } else {
        header('Location: ../index.php?error=invalidinput');
        exit();
    }
}
