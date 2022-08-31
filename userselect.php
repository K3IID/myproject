<!DOCTYPE html>
<?php
session_start();
$servername="localhost";
$username="root";
$password="";
$dbname="iagri";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if(isset($_POST['button'])){
$usertype=$_POST['usertype'];
$query = "SELECT * FROM `userlogin` WHERE usertype='".$usertype."'";
$result = mysqli_query($conn, $query);
if($result){
while($row=mysqli_fetch_array($result)){
echo'<script type="text/javascript">alert("you are to logined as ' .$row['usertype'].'")</script>';

}
if($usertype=="Client"){
?>
<script type="text/javascript">
window.location.href="client/clientlogin.php"</script>
<?php

}else if($usertype=="Buyer"){
?>
<script type="text/javascript">
window.location.href="buyer/buyerlogin.php"</script>
<?php

}
}else if($usertype=="default"){
echo 'no result';
}
}
$_SESSION['login'] = true;

?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>I-Agri - Login</title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<link href="common/css/bootstrap.css" rel="stylesheet">
    <link href="common/css/bootstrap.min.css" rel="stylesheet">
    <link href="common/css/styles.css" rel="stylesheet" />
    <link href="common/css/index.css" rel="stylesheet" />

</head>
<?php include 'include/header.php'; ?>
<body>
	<?php include 'include/navbar.php'; ?>
		<!-- login_block -->
		<div class="login_block">
			<div class="wrap">
				<div class="login-container">
					<div class="user_card bg-light">
						<div class="d-flex justify-content-center">
							<div class="brand_logo_container">
								<p class="login_mark text-white"><i class="fa fa-user-circle" aria-hidden="true"></i><span>Login</span></p>
							</div>
						</div>
						<div class="d-flex justify-content-center form_container">
							<form method="post">
								<div>
									<select name="usertype" class="custom-select mb-3">
                                    <option value="default" selected>Select User Type</option>
									<option value="Client">Client</option>
									<option value= "Buyer">Buyer</option>
									</select>
								</div>
								<div class="d-flex justify-content-center mt-3 btn_container">
									<button type="submit" name="button" class="btn login_btn" >Next</button>
								</div>
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