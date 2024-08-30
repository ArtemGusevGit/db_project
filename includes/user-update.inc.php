<?php
// user-update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = htmlspecialchars($_POST["id"]);
    $username = htmlspecialchars($_POST["username"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);

    if ($id && $username && $email && $password && $id) {
        try {
            require_once "dbh.inc.php";
            $query = "UPDATE users SET username=:username, pwd=:password, email=:email WHERE id=:id";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":id", $id);

            $stmt->execute();

            $pdo = null;
            $stmt = null;

            header('Location: ../index.php');
            die();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    } else {
        header('Location: ../index.php');
    }
}

