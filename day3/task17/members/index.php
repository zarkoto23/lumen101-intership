<?php

require "../config.php";
require "../nav.php";

$search = $_GET['search'] ?? '';


if ($search != '') {


    $stmt = $pdo->prepare(
        "SELECT *
         FROM members
         WHERE first_name LIKE ?
         OR last_name LIKE ?
         OR email LIKE ?"
    );


    $stmt->execute([
        "%$search%",
        "%$search%",
        "%$search%"
    ]);


} else {


    $stmt = $pdo->query(
        "SELECT *
         FROM members"
    );


}


$members = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<h1>Clients</h1>

<form method="GET">

    <input type="text" name="search" placeholder="Search name or email" value="<?= $_GET['search'] ?? '' ?>">

    <button>
        Search
    </button>

</form>

<a href="create.php">Add client</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Birth date</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($members as $member): ?>

        <tr>
            <td><?= $member['id'] ?></td>
            <td>
                <?= $member['first_name'] ?>
                <?= $member['last_name'] ?>
            </td>
            <td><?= $member['email'] ?></td>
            <td><?= $member['phone'] ?></td>
            <td><?= $member['birth_date'] ?></td>
            <td>

                <a href="workouts.php?id=<?= $member['id'] ?>">
                    View workouts
                </a>
                <a href="edit.php?id=<?= $member['id'] ?>">
                    Edit
                </a>
                <a href="delete.php?id=<?= $member['id'] ?>"
                    onclick="return confirm('Are you sure you want to delete this client?');">
                    Delete
                </a>
            </td>
        </tr>

    <?php endforeach; ?>

</table>