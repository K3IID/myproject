<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "iagri");

if (isset($_POST["add_to_cart"])) {
	if (isset($_SESSION["shopping_cart"])) {
		$item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
		if (!in_array($_GET["id"], $item_array_id)) {
			$count = count($_SESSION["shopping_cart"]);
			$item_array = array(
				'item_id'			=>	$_GET["id"],
				'item_name'			=>	$_POST["hidden_name"],
				'item_price'		=>	$_POST["hidden_price"],
				'item_quantity'		=>	$_POST["quantity"]
			);
			$_SESSION["shopping_cart"][$count] = $item_array;
		} else {
			echo '<script>alert("Item Already Added")</script>';
		}
	} else {
		$item_array = array(
			'item_id'			=>	$_GET["id"],
			'item_name'			=>	$_POST["hidden_name"],
			'item_price'		=>	$_POST["hidden_price"],
			'item_quantity'		=>	$_POST["quantity"]
		);
		$_SESSION["shopping_cart"][0] = $item_array;
	}
}

if (isset($_GET["action"])) {
	if ($_GET["action"] == "delete") {
		foreach ($_SESSION["shopping_cart"] as $keys => $values) {
			if ($values["item_id"] == $_GET["id"]) {
				unset($_SESSION["shopping_cart"][$keys]);
				echo '<script>alert("Item Removed")</script>';
				echo '<script>window.location="index.php"</script>';
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
		</br>
		</br>
		</br>
		<h3 align="center">Product</h3><br />
		<section class="py-5">
			<div class="container px-4 px-lg-5 mt-5">
				<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
					<?php
					$query = "SELECT * FROM tbl_product ORDER BY id ASC";
					$result = mysqli_query($connect, $query);
					if (mysqli_num_rows($result) > 0) {
						while ($row = mysqli_fetch_array($result)) {
					?>
							<form method="post" action="index.php?action=add&id=<?php echo $row["id"]; ?>">
								<div class="col mb-5">
									<div class="card h-100">

										<!-- Product image-->
										<img class="card-img-top" src="images/<?php echo $row["image"]; ?>" class="img-responsive" />

										<!-- Product details-->
										<div class="card-body p-4">
											<div class="text-center">

												<!-- Product name-->
												<h5 class="fw-bolder"><?php echo $row["name"]; ?></h5>

												<!-- Product price-->
												<h5 class="fw-bolder">₱ <?php echo $row["price"]; ?></h5>
												<input type="text" name="quantity" value="1" class="form-control" />
												<input type="hidden" name="hidden_id" value="<?php echo $row["id"]; ?>" />
												<input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />
												<input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />
											</div>
										</div>

										<!-- Product actions-->
										<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
											<div class="text-center">
												<button type="submit" name="add_to_cart" class="btn btn-outline-dark mt-auto">Add to Cart</button>
											</div>
										</div>
									</div>
								</div>
							</form>
					<?php
						}
					}
					?>
				</div>
		</section>
	</div>
	<!-- Footer -->
	<?php include 'include/footer.php'; ?>
	<!-- Bootstrap core JS-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
	<!-- Core theme JS-->
	<script src="js/scripts.js"></script>
</body>

</html>