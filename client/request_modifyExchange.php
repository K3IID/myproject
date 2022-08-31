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

$action = getPostData("hiddenAction");
$exchangeId = getPostData("hiddenExchangeId");
$requestor = getPostData("fromBuyer");
$approver = getPostData("toBuyer");

if ($action == "new") {
    $query = "INSERT INTO exchange(buyer_username_from, buyer_username_to) VALUES('" . $requestor . "', '" . $approver . "')";
    $result = mysqli_query($connect, $query);
    $exchangeId = $connect->insert_id;
    if ($result) {
        $ctr = 0;
        while (isset($_POST["txtFromProductName" . $ctr])) {
            $prodName = $_POST["txtFromProductName" . $ctr];
            $prodUnit = $_POST["txtFromProductUnit" . $ctr];
            $prodQuantity = $_POST["txtFromProductQuantity" . $ctr];

            $query = "INSERT INTO exchange_items(person_num, exchange_id, product_name, quantity, product_unit) VALUES('1', '" . $exchangeId . "', '" . $prodName . "', '" . $prodQuantity . "', '" . $prodUnit . "')";
            $result = mysqli_query($connect, $query);
            if ($result) {
            }
            $ctr++;
        }

        $ctr = 0;
        while (isset($_POST["txtToProductName" . $ctr])) {
            $prodName = $_POST["txtToProductName" . $ctr];
            $prodUnit = $_POST["txtToProductUnit" . $ctr];
            $prodQuantity = $_POST["txtToProductQuantity" . $ctr];

            $query = "INSERT INTO exchange_items(person_num, exchange_id, product_name, quantity, product_unit) VALUES('2', '" . $exchangeId . "', '" . $prodName . "', '" . $prodQuantity . "', '" . $prodUnit . "')";
            $result = mysqli_query($connect, $query);
            if ($result) {
            }
            $ctr++;
        }
    }
}


if ($action == "approve") {
    $query = "UPDATE exchange SET status = 'APPROVED' WHERE id = " . $exchangeId;
    $result = mysqli_query($connect, $query);
    if ($result) {
    }
}


?>