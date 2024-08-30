<?php
// fetch DB data
try {
    require_once 'includes/dbh.inc.php';

    $query = "SELECT * FROM users";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $foundUser = null;

    // To find a user data by username on index.php page
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
        $username = trim($_POST['username']);
        $searchQuery = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $searchStmt = $pdo->prepare($searchQuery);
        $searchStmt->bindParam(':username', $username);
        $searchStmt->execute();
        $foundUser = $searchStmt->fetch(PDO::FETCH_ASSOC);
    }

    $pdo = null;
    $stmt = null;

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
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
</head>
<body>

<section class="p-4">


    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Email</th>
            <th scope="col">Username</th>
            <th scope="col">Password</th>
            <th class='text-center' scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($users as $user) {
            echo "<tr>";
            echo "<th scope='row'>" . htmlspecialchars($user['id']) . "</th>";
            echo "<td>" . htmlspecialchars($user['email']) . "</td>";
            echo "<td>" . htmlspecialchars($user['username']) . "</td>";
            echo "<td>" . '*****' . "</td>";
            echo "<td class='text-center'>";
            echo '<a href="user-update.php?id=' . htmlspecialchars($user['id']) . '" class="btn btn-secondary">Edit</a>';
            echo "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>

    <form action="includes/user-create.inc.php" class="p-3" method="post">
        <h3>Add user to DB</h3>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" name="email" class="form-control" id="email"
                   placeholder="name@example.com" required>
        </div>
        <div class="form-group">
            <label for="username">username</label>
            <input type="text" name="username" class="form-control" id="username"
                   placeholder="user name" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" id="password" name="password" type="password" placeholder="password" required>
        </div>
        <div class="d-flex justify-content-end mt-2">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

    <?php if (isset($_GET['error']) && $_GET['error'] == 'userexists'): ?>
        <div class="alert alert-danger mt-3">
            <strong>Error:</strong> Username or email already exists.
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success']) && $_GET['success'] == 'usercreated'): ?>
        <div class="alert alert-success mt-3">
            <strong>Success:</strong> User created successfully.
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error']) && $_GET['error'] == 'invalidinput'): ?>
        <div class="alert alert-danger mt-3">
            <strong>Error:</strong> Invalid input. Please try again.
        </div>
    <?php endif; ?>


    <form action="" class="p-3" method="post">
        <h3>Find email and id by username</h3>
        <div class="form-group">
            <label for="user-find">User name</label>
            <input type="text" name="username" class="form-control" id="user-find"
                   placeholder="username" required>
        </div>

        <div class="d-flex justify-content-end mt-2">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>


    <?php if ($foundUser): ?>
        <div class="alert alert-success mt-3">
            <strong>Email found:</strong> <?php echo htmlspecialchars($foundUser['email']); ?>
            <br/>
            <strong>ID:</strong> <?php echo htmlspecialchars($foundUser['id']); ?>
        </div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div class="alert alert-danger mt-3">
            <strong>No email found with that user.</strong>
        </div>
    <?php endif; ?>

</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>