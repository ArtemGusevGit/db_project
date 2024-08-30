<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = htmlspecialchars($_GET["id"]);

    if ($id) {
        try {
            require_once "includes/dbh.inc.php";
            $query = "SELECT * FROM users WHERE id = :id;";

            $stmt = $pdo->prepare($query);

            $stmt->bindParam(":id", $id);

            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            $pdo = null;
            $stmt = null;

        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());

        }
    } else {
        header('Location: ../index.php');
    }
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Demo DB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<section class="p-4">
    <form action="includes/user-update.inc.php" class="p-3" method="post">
        <h3>Update</h3>

        <div class="form-group">
            <label for="id">ID</label>
            <?php
            echo '<input disabled type="text" name="id" class="form-control" id="id" value="' . htmlspecialchars($user['id']) . '">';
            ?>
        </div>

        <?php
        echo '<input type="hidden" name="id" value="' . htmlspecialchars($user['id']) . '">';
        ?>

        <div class="form-group">
            <label for="email">Email address</label>
            <?php
            echo '<input type="email" name="email" class="form-control" id="email" value="' . htmlspecialchars($user['email']) . '">';
            ?>

        </div>
        <div class="form-group">
            <label for="username">username</label>
            <?php
            echo '<input type="text" name="username" class="form-control" id="username" value="' . htmlspecialchars($user['username']) . '">';
            ?>

        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <?php
            echo '<input type="text" name="password" class="form-control" id="password" value="' . htmlspecialchars($user['pwd']) . '">';
            ?>
        </div>

        <div class="d-flex justify-content-end mt-2 gap-2">
            <a href="index.php" class="btn btn-secondary">Back</a>

            <?php


            echo '<a href="includes/user-delete.inc.php?id=' . htmlspecialchars($user['id']) . '" class="btn btn-danger">Delete</a>';

            ?>
            <button type="submit" class="btn btn-primary">Edit</button>
        </div>
    </form>


</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>