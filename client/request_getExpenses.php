<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "iagri");
?>
<?php

$query = "SELECT * FROM expenses";
$result = mysqli_query($connect, $query);

$resultData = [];
if (mysqli_num_rows($result) > 0) {
    $ctr = 1;
    while ($row = mysqli_fetch_array($result)) {
        /* array_push($resultData, $row); */
?>
        <tr>
            <th scope="row"><?= $ctr ?></th>
            <td><?= $row["name"] ?></td>
            <td><?= $row["quantity"] ?></td>
            <td><?= $row["price"] ?></td>
        </tr>
<?php
        $ctr++;
    }
}

/* echo json_encode($resultData); */
