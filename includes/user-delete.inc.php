<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = htmlspecialchars($_GET["id"]);


    if ($id) {
        try {
            require_once "dbh.inc.php";
            $query = "DELETE FROM users WHERE id = :id";

            $stmt = $pdo->prepare($query);

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