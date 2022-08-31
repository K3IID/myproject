<?php
session_start();

include "include/conn.php";
if (isset($_POST['username']) && isset($_POST['password']))
{
    function validate($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);

		return $data;
}
$username = validate($_POST['username']);
$password = validate($_POST['password']);

if(empty($username) && empty($password)) {
    header("Location: index.php?error=Fields cannot be empty, Please fill up all the fields!");
} else if (empty($username)) {
    header("Location: index.php?error=Please enter your username.");

} else if (empty($password)) {
    header("Location: index.php?error=Please enter your password.");

} else
{
    $sql = "Select * from buyer where username = '$username' AND password = '$password'";
   $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);

        if($row['username'] === $username && $row['password'] === $password && $row['usertype'] === 'Buyer')
        {
            $_SESSION['firstname'] = $row['firstname'];
			$_SESSION['lastname'] = $row['lastname'];
			$_SESSION['username'] = $row['username'];
			$_SESSION['usertype'] = $row['usertype'];
            echo "<script>
				alert('Successfully Login');
				window.location.href='index.php';
				</script>";
        } else {
            header("Location: buyerlogin.php?error=Incorrect Username or Password");
        }
    } else {
        header("Location: buyerlogin.php?error=Incorrect Username or Password");
        exit();
    }

}
} else {
header("Location: buyerlogin.php");
exit();
}