<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "iagri");
?>
<?php

$query = "SELECT * FROM client WHERE username != '" . $_SESSION['username'] . "'";
$result = mysqli_query($connect, $query);

$resultData = [];
if (mysqli_num_rows($result) > 0) {
    $ctr = 1;
    while ($row = mysqli_fetch_array($result)) {
        /* array_push($resultData, $row); */
?>
        <option value='<?= $row["username"] ?>'><?= $row["username"] ?></option>
<?php
        $ctr++;
    }
}

/* echo json_encode($resultData); */
