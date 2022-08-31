<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "iagri");
?>
<?php
function getPostData($name)
{
    if (isset($_POST[$name])) {
        return $_POST[$name];
    }
    return "";
}
?>
<?php

$exchangeId = getPostData("exchangeId");

$resultData = [];


$query = "SELECT e.*, b1.username AS 'from_buyer', b2.username AS 'to_buyer' FROM exchange e
            LEFT JOIN client b1 ON b1.username = e.buyer_username_from
            LEFT JOIN client b2 ON b2.username = e.buyer_username_to 
            WHERE e.id = " . $exchangeId . " 
            GROUP BY e.id";
$result = mysqli_query($connect, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $row["fromItems"] = [];
        $row["toItems"] = [];

        $query2 = "SELECT * FROM exchange_items WHERE person_num = 1 AND exchange_id = " . $exchangeId;
        $result2 = mysqli_query($connect, $query2);
        if (mysqli_num_rows($result2) > 0) {
            while ($row2 = mysqli_fetch_array($result2)) {
                array_push($row["fromItems"], $row2);
            }
        }

        $query2 = "SELECT * FROM exchange_items WHERE person_num = 2 AND exchange_id = " . $exchangeId;
        $result2 = mysqli_query($connect, $query2);
        $row["items"] = [];
        if (mysqli_num_rows($result2) > 0) {
            while ($row2 = mysqli_fetch_array($result2)) {
                array_push($row["toItems"], $row2);
            }
        }

        $row["own"] = "false";
        if ($_SESSION['username'] == $row["to_buyer"]) {
            $row["own"] = "true";
        }
        array_push($resultData, $row);
    }
}

$resultData["post-data"] = $_POST;

echo json_encode($resultData);
