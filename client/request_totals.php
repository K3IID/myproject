<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "iagri");
?>

<?php
$response = [];
$response["totalSales"] = number_format(0, 2);
$response["totalProducts"] = number_format(0);
$response["totalUsers"] = number_format(0);
$response["totalSalesToday"] = number_format(0, 2);



$query = "SELECT SUM(price * quantity) as 'total' FROM order_items";
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $response["totalSales"] = number_format($row["total"], 2);
    }
}


$query = "SELECT COUNT(*) as 'total' FROM tbl_product";
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $response["totalProducts"] = number_format($row["total"]);
    }
}


$query = "SELECT COUNT(*) as 'total' FROM buyer";
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $response["totalUsers"] = number_format($row["total"]);
    }
}


$query = "SELECT SUM(price * quantity) as 'total' FROM order_items WHERE DATE(created_at) = CURDATE()";
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $response["totalSalesToday"] = number_format($row["total"], 2);
    }
}



echo json_encode($response);
