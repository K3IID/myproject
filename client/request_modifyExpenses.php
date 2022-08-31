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
$prodName = getPostData("txtName");
$prodPrice = getPostData("txtPrice");
$prodQuantity = getPostData("txtQuantity");

$query = "INSERT INTO expenses(name, price, quantity) VALUES('" . $prodName . "', " . $prodPrice . ", " . $prodQuantity . ")";
$result = mysqli_query($connect, $query);
if ($result) {
}


?>
