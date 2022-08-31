<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "iagri");
?>
<?php

$query = "SELECT e.*, b1.username AS 'from_buyer', b2.username AS 'to_buyer' FROM EXCHANGE e
                LEFT JOIN client b1 ON b1.username = e.buyer_username_from
                LEFT JOIN client b2 ON b2.username = e.buyer_username_to
                GROUP BY e.id";
$result = mysqli_query($connect, $query);

$resultData = [];
if (mysqli_num_rows($result) > 0) {
    $ctr = 1;
    while ($row = mysqli_fetch_array($result)) {
        /* array_push($resultData, $row); */
?>
        <tr onclick="getExchangeItems(<?= $row['id'] ?>)">
            <td><?= $row["from_buyer"] ?></td>
            <td><?= $row["to_buyer"] ?></td>
            <td><?= $row["created_at"] ?></td>
            <td><?= $row["status"] ?></td>
        </tr>
<?php
        $ctr++;
    }
}

/* echo json_encode($resultData); */
?>

<script>

</script>