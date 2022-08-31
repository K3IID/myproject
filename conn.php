<?php
	$conn = new mysqli('localhost', 'root', '', 'iagri');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
?>