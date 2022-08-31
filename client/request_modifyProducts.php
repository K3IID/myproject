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

function fileData($field)
{
    return (isset($_FILES[$field])) ? $_FILES[$field] : '';
}
?>


<?php

$ctr = 0;

$imagesFolder = $_SERVER['DOCUMENT_ROOT'] . "/IAGRI/buyer/images";

while (isset($_POST["txtProductName" . $ctr])) {
    $prodId = $_POST["txtProductId" . $ctr];
    $prodName = $_POST["txtProductName" . $ctr];
    $prodQuantity = $_POST["txtProductQty" . $ctr];
    $prodPrice = $_POST["txtProductPrice" . $ctr];
    $prodSKU = $_POST["txtProductSKU" . $ctr];
    $prodUnit = $_POST["txtProductUnit" . $ctr];
    $prodQuantity = $_POST["txtProductQty" . $ctr];
    $prodImage = fileData("txtProductFile" . $ctr);
    $strImage = "";

    if (isset($_FILES["txtProductFile" . $ctr]) && $_FILES["txtProductFile" . $ctr]["size"] > 0) {
        $strImage = "img-" . strtolower($prodName) . "." . pathinfo(basename($prodImage['name']), PATHINFO_EXTENSION);
    }

    if ($prodId == "") {
        // ADD
        $query = "INSERT INTO tbl_product(name, price, quantity, image, sku, unit) VALUES('" . $prodName . "', " . $prodPrice . ", " . $prodQuantity . ", '" . $strImage . "', '" . $prodSKU . "', '" . $prodUnit . "')";
        $result = mysqli_query($connect, $query);
        if ($result) {
        }
    } else {
        if ($prodName == "") {
            //DELETE
            $query = "DELETE FROM tbl_product WHERE id = " . $prodId;
            $result = mysqli_query($connect, $query);
            if ($result) {
            }
        } else {
            //UPDATE
            $query = "UPDATE tbl_product SET unit = '" . $prodUnit . "', sku = '" . $prodSKU . "', name = '" . $prodName . "' , price = " . $prodPrice . ", quantity = " . $prodQuantity . " WHERE id = " . $prodId;
            $result = mysqli_query($connect, $query);
            if ($result) {
            }

            if ($strImage != "") {
                $query = "UPDATE tbl_product SET image = '" . $strImage . "' WHERE id = " . $prodId;
                $result = mysqli_query($connect, $query);
                if ($result) {
                }
            }
        }
    }

    try {
        $strImage ? move_uploaded_file($prodImage['tmp_name'], $imagesFolder . "/" . $strImage) : 0;
    } catch (Exception $e) {
        $data["remarks"] = "failed";
        $data["message"] = "Exception:" . $e;
    }


    $ctr++;
}

?>
