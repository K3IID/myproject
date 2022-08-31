<?php 

include("conn.php");

$output = "";

if (isset($_POST['register'])) {
	$fname = $_POST['fname'];
	$sname = $_POST['sname'];
	$number = $_POST['number'];
	$city = $_POST['city'];
	$uname = $_POST['uname'];
	$role = $_POST['role'];
	$pass = $_POST['pass'];
	$c_pass = $_POST['c_pass'];

	$error = array();

	if (empty($fname)) {
		$error['error'] = "Firstname is Empty";
	}else if(empty($sname)){
		$error['error'] = "Surname is empty";
	}else if(empty($uname)){
		$error['error'] = "username is empty";
	}else if(empty($role)){
		$error['error'] = "Select role";
	}else if(empty($pass)){
		$error['error'] = "Enter Password";
	}else if(empty($c_pass)){
		$error['error'] = "Confirm Password";
	}else if($pass != $c_pass){
		$error['error'] = "Both password do not match";
	}



	if (isset($error['error'])) {
		$output .= $error['error'];
	}else{
		$output .= "";
	}

//tite 
	if (count($error) < 1) {
		$query = "INSERT INTO users(firstname,surname,number,city,username,gender,role,password) VALUES('$fname','$sname','$number','$city','$uname','$role','$pass')";
		$res = mysqli_query($connect,$query);

		if ($res) {
			$output .= "You have successfully registered";
			header("Location:index.php");
		}else{
			$output .= "Failed to register";
		}
	}
}



 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>I-Agri</title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<link href="common/css/bootstrap.css" rel="stylesheet">
    <link href="common/css/bootstrap.min.css" rel="stylesheet">
    <link href="common/css/styles.css" rel="stylesheet" />
    <link href="common/css/index.css" rel="stylesheet" />
    </head>
<body>

	<?php include("include/navbar.php"); ?>

	<div class="container">
		<div class="col-md-12">
			<div class="row d-flex justify-content-center">
				<div class="col-md-6 shadow-sm" style="margin-top:100px;">
					<form method="post">
						<h3 class="text-center my-3">Register</h3>

						<div class="text-center"><?php echo $output; ?></div>

						<label>Firstname</label>
						<input type="text" name="fname" class="form-control my-2" placeholder="Enter Firstname" autocomplete="off">

						<label>Surname</label>
						<input type="text" name="sname" class="form-control my-2" placeholder="Enter Surname" autocomplete="off">

						<label>Phone Number</label>
						<input type="text" name="number" class="form-control my-2" placeholder="Enter Number" autocomplete="off">

						<label>City</label>
						<input type="text" name="city" class="form-control my-2" placeholder="Enter your City" autocomplete="off">

						<label>Username</label>
						<input type="text" name="uname" class="form-control my-2" placeholder="Enter Username" autocomplete="off">

                         <label>User Type</label>
						<select name="role" class="form-control my-2">
							<option value="">User Type</option>
							<option value="Client">Client</option>
							<option value="Buyer">Buyer</option>
						</select>

						<label>Password</label>
						<input type="password" name="pass" class="form-control my-2" placeholder="Enter Password">

						<label>Confirm Password</label>
						<input type="password" name="c_pass" class="form-control my-2" placeholder="Enter Confirm Password">
						<center>
						<input type="submit" name="register" class="btn btn-success" value="Register">
						<input type="submit" name="cancel" class="btn btn-success" value="Cancel">
						</center>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="" style="margin-top: 30px;"></div>
		<!-- Footer -->
		<?php include 'include/footer.php'; ?>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
</body>
</html>