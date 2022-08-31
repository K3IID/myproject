<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "iagri");
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
			<div class="text-center">
				<h3>I-AGRI</h3>
				<hr>
				<h4>Your Order is ON THE WAY</h4>
				<hr>
				<h8>your order will be delivered to:</h8>
				<br>
				<br>
			</div>
			<div class="table-responsive">
				<table class="table table-bordered">
					<tr>
						<th width="40%">Item Name</th>
						<th width="10%">Quantity</th>
						<th width="20%">Price</th>
					</tr>
					<?php
					if (!empty($_SESSION["shopping_cart"])) {
						$total = 0;
						$order_id = 1;
						$query = "SELECT (MAX(order_id)+1) as 'max_order_id' FROM order_items";
						$result = mysqli_query($connect, $query);
						if (mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_array($result)) {
								$order_id = $row["max_order_id"] ? $row["max_order_id"] : 1;
							}
						}

						foreach ($_SESSION["shopping_cart"] as $keys => $values) {
							$buyer_username = isset($_SESSION['username']) ? $_SESSION['username'] : "GUEST";
							$item_id = $values["item_id"];
							$item_price = $values["item_price"];
							$item_qty = $values["item_quantity"];

							$query = "INSERT INTO order_items(buyer_username, item_id, quantity, price, order_id) VALUES('" . $buyer_username . "', '" . $item_id . "', " . $item_qty . ", " . $item_price . ", " . $order_id . ")";
							$result = mysqli_query($connect, $query);
							if ($result) {
							}

					?>
							<tr>
								<td><?php echo $values["item_name"]; ?></td>
								<td><?php echo $values["item_quantity"]; ?></td>
								<td>$ <?php echo $values["item_price"]; ?></td>
							</tr>
					<?php
						}
					}


					?>
				</table>
			</div>
		</div>
		<form method="post" action="index.php">
			<div class="text-center">
				<button type="submit" name="button" class="btn btn-outline-dark mt-auto" style="background-color:#0f531c">Back</button>
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