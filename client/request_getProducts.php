<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "iagri");
?>
<?php

$query = "SELECT * FROM tbl_product";
$result = mysqli_query($connect, $query);

$resultData = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $query2 = "SELECT SUM(quantity) AS 'sold_quantity' FROM order_items WHERE item_id = " . $row["id"];
        $result2 = mysqli_query($connect, $query2);

        $resultData2 = [];

        if (mysqli_num_rows($result2) > 0) {
            while ($row2 = mysqli_fetch_array($result2)) {
                $row["quantity"] = intval($row["quantity"]) - intval($row2["sold_quantity"]);
            }
        }
        array_push($resultData, $row);
    }
}

echo json_encode($resultData);
