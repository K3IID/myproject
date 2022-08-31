<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>I-Agri - Login</title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<link href="../common/css/bootstrap.css" rel="stylesheet">
    <link href="../common/css/bootstrap.min.css" rel="stylesheet">
    <link href="../common/css/styles.css" rel="stylesheet" />
    <link href="../common/css/index.css" rel="stylesheet" />

</head>
<?php include 'include/header.php'; ?>
<body>
	<?php include 'navbar.php'; ?>
		<!-- login_block -->
		<div class="login_block">
			<div class="wrap">
				<div class="login-container">
					<div class="user_card bg-light">
						<div class="d-flex justify-content-center">
							<div class="brand_logo_container">
								<p class="login_mark text-white"><i class="fa fa-user-circle" aria-hidden="true"></i><span>Client Login</span></p>
							</div>
						</div>
						<div class="d-flex justify-content-center form_container">
							<form action="login.php" method="post">
								<div class="mb-3">
									<div class=" links">
										<!-- <p class="login-remarks">Please enter your credentials to login!</p> -->
										<?php if (isset($_GET['error'])) { ?>
										<p class="alert alert-danger"><?php echo $_GET['error']; ?></p>
										<?php } ?>
									</div>
								</div>
								<div class="input-group mb-3">
									<div class="input-group-append">
										<span class="input-group-text"><i class="fas fa-user"></i></span>
									</div>
									<input type="text" name="username" class="form-control input_user"  placeholder="username">
								</div>
								<div class="input-group mb-3">
									<div class="input-group-append">
										<span class="input-group-text"><i class="fas fa-key"></i></span>
									</div>
									<input type="password" name="password" class="form-control input_pass"  placeholder="password">
								</div>
								<div class="d-flex justify-content-center mt-3 btn_container">
									<button type="submit" name="button" class="btn login_btn" >Login</button>
								</div>
								<div>
								<a href="resetpass.php">Forgot password</a>.</p>
								</div>
								<p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
							</form>
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-center h-100"></div>
			</div>
		</div>
	</div>
	<!--/end here-->
	<!--footer-->
	<?php include 'include/footer.php'; ?>
	<!-- <script src="common/js/jquery-3.5.1.min.js"></script> -->
	<script src="common/js/jquery-3.5.1.slim.min.js"></script>
	<script src="common/js/bootstrap.bundle.min.js"></script>
	<script src="common/js/jquery.plugin.js"></script>
	<script src="common/js/script.js"></script>
	<!-- <script src="js/index.js"></script> -->

</body>
</html>