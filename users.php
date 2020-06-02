<?php
				include "includes/header.php";
				?>

				<a class="btn btn-primary" href="edit-users.php?act=add"> <i class="glyphicon glyphicon-plus-sign"></i> Добавить нового</a>

				<h1>Пользователи</h1>
				<p>Всего записей: <?php echo counting("users", "id");?></p>

				<table id="sorted" class="table table-striped table-bordered">
				<thead>
				<tr>
							<th>Id</th>
			<th>Name</th>
			<th>Email</th>
			<th>Password</th>
			<th>Chat ID</th>

				<th class="not">Edit</th>
				<th class="not">Delete</th>
				</tr>
				</thead>

				<?php
				$users = getAll("users");
				if($users) foreach ($users as $userss):
					?>
					<tr>
		<td><?php echo $userss['id']?></td>
		<td><?php echo $userss['name']?></td>
		<td><?php echo $userss['email']?></td>
		<td><?php echo $userss['password']?></td>
		<td><?php echo $userss['role']?></td>


						<td><a href="edit-users.php?act=edit&id=<?php echo $userss['id']?>"><i class="glyphicon glyphicon-edit"></i></a></td>
						<td><a href="save.php?act=delete&id=<?php echo $userss['id']?>&cat=users" onclick="return navConfirm(this.href);"><i class="glyphicon glyphicon-trash"></i></a></td>
						</tr>
					<?php endforeach; ?>
					</table>
					<?php include "includes/footer.php";?>
				