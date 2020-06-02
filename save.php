<?php

		include("includes/connect.php");

		$cat = $_POST['cat'];
		$cat_get = $_GET['cat'];
		$act = $_POST['act'];
		$act_get = $_GET['act'];
		$id = $_POST['id'];
		$id_get = $_GET['id'];

		
				if($cat == "qiwi" || $cat_get == "qiwi"){
					$phone = mysqli_real_escape_string($link,$_POST["phone"]);
$token = mysqli_real_escape_string($link,$_POST["token"]);
$trans_type = mysqli_real_escape_string($link,$_POST["trans_type"]);


				if($act == "add"){
					mysqli_query($link, "INSERT INTO `qiwi` (  `phone` , `token` , `trans_type` ) VALUES ( '".$phone."' , '".$token."' , '".$trans_type."' ) ");
				}elseif ($act == "edit"){
					mysqli_query($link, "UPDATE `qiwi` SET  `phone` =  '".$phone."' , `token` =  '".$token."' , `trans_type` =  '".$trans_type."'  WHERE `id` = '".$id."' "); 	
					}elseif ($act_get == "delete"){
						mysqli_query($link, "DELETE FROM `qiwi` WHERE id = '".$id_get."' ");
					}
					header("location:"."qiwi.php");
				}
				
				if($cat == "users" || $cat_get == "users"){
					$name = mysqli_real_escape_string($link,$_POST["name"]);
$email = mysqli_real_escape_string($link,$_POST["email"]);
$password = mysqli_real_escape_string($link,$_POST["password"]);
$role = mysqli_real_escape_string($link,$_POST["role"]);


				if($act == "add"){
					mysqli_query($link, "INSERT INTO `users` (  `name` , `email` , `password` , `role` ) VALUES ( '".$name."' , '".$email."' , '".md5($password)."', '".$role."' ) ");
				}elseif ($act == "edit"){
					mysqli_query($link, "UPDATE `users` SET  `name` =  '".$name."' , `email` =  '".$email."' , `role` =  '".$role."'  WHERE `id` = '".$id."' "); 	
					}elseif ($act_get == "delete"){
						mysqli_query($link, "DELETE FROM `users` WHERE id = '".$id_get."' ");
					}
					header("location:"."users.php");
				}
				?>