<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "iagri");

if(isset($_GET["action"]))
{
	if($_GET["action"] == "delete")
	{
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
			if($values["item_id"] == $_GET["id"])
			{
				unset($_SESSION["shopping_cart"][$keys]);
				echo '<script>alert("Item Removed")</script>';
				echo '<script>window.location="cart.php"</script>';
			}
		}
	}
}
?>
<!DOCTYPE html>
<?php
    include 'include/conn.php'
?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>I-Agri</title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<link href="../common/css/bootstrap.css" rel="stylesheet">
    <link href="../common/css/bootstrap.min.css" rel="stylesheet">
    <link href="../common/css/styles.css" rel="stylesheet" />
    <link href="../common/css/index.css" rel="stylesheet" />
 </head>
    <!-- Header -->
    <body>
        <!-- Navbar -->
        <?php include 'include/navbar.php'; ?>
		<div class="container">
			<div div style="clear:both">
				<br />
				<h3>Order Details</h3>
				<div class="table-responsive">
					<table class="table table-bordered">
						<tr>
							<th width="40%">Item Name</th>
							<th width="10%">Quantity</th>
							<th width="20%">Price</th>
							<th width="15%">Total</th>
							<th width="5%">Action</th>
						</tr>
						<?php
						if(!empty($_SESSION["shopping_cart"]))
						{
							$total = 0;
							foreach($_SESSION["shopping_cart"] as $keys => $values)
							{
						?>
						<tr>
							<td><?php echo $values["item_name"]; ?></td>
							<td><?php echo $values["item_quantity"]; ?></td>
							<td>₱ <?php echo $values["item_price"]; ?></td>
							<td>₱ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?></td>
							<td><a href="cart.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
						</tr>
						<?php
								$total = $total + ($values["item_quantity"] * $values["item_price"]);
							}
						?>
						<tr>
							<td colspan="3" align="right">Total</td>
							<td align="right">₱ <?php echo number_format($total, 2); ?></td>
							<td></td>
						</tr>
						<?php
						}
						?>
					</table>
				</div>
			</div>
			<form method="post" action="orderSum.php">
					<div class="text-center">
						<button type="submit" name="button" class="btn btn-outline-dark mt-auto" style="background-color:#0f531c">PLace Order</button>
					</div>
            </form>
		</div>
					</br>
<!-- Footer -->
<?php include 'include/footer.php'; ?>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>