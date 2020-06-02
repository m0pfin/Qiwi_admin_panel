<?php
				include "includes/header.php";
				$data=[];

				$act = $_GET['act'];
				if($act == "edit"){
					$id = $_GET['id'];
					$users = getById("users", $id);
				}
				?>

				<form method="post" action="save.php" enctype='multipart/form-data'>
					<fieldset>
						<legend class="hidden-first">Добавление нового пользователя</legend>
						<input name="cat" type="hidden" value="users">
						<input name="id" type="hidden" value="<?=$id?>">
						<input name="act" type="hidden" value="<?=$act?>">
				
							<label>Name</label>
							<input class="form-control" type="text" name="name" value="<?=$users['name']?>" /><br>
							
							<label>Email</label>
							<input class="form-control" type="text" name="email" value="<?=$users['email']?>" /><br>
							
							<label>Password</label>
							<input class="form-control" type="text" name="password" value="<?=$users['password']?>" /><br>
							
							<label>Chat ID</label>
							<input class="form-control" type="text" name="role" value="<?=$users['role']?>" /><br>
							<br>
					<input type="submit" value=" Save " class="btn btn-success">
					</form>
					<?php include "includes/footer.php";?>
				