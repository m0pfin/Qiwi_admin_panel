<?php
$config = require 'config.php';
		$link = mysqli_connect($config['host'], $config['user'], $config['password']);
		mysqli_select_db($link, $config['db_name']);
		mysqli_query($link, "SET CHARACTER SET utf8");
		?>
		