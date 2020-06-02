<?php
				include "includes/header.php";
				?>

				<a class="btn btn-primary" href="edit-qiwi.php?act=add"> <i class="glyphicon glyphicon-plus-sign"></i> Добавить кошелек</a>

				<h1>Qiwi</h1>
				<p>Всего записей: <?php echo counting("qiwi", "id");?></p>

				<table id="sorted" class="table table-striped table-bordered">
				<thead>
				<tr>
							<th>ID</th>
			<th>Телефон</th>
			<th>Token</th>
			<th>Тип транзакций</th>

				<th class="not">Edit</th>
				<th class="not">Delete</th>
				</tr>
				</thead>

				<?php
				$qiwi = getAll("qiwi");
				if($qiwi) foreach ($qiwi as $qiwis):
					?>
					<tr>
		<td><?php echo $qiwis['id']?></td>
		<td><?php echo $qiwis['phone']?></td>
		<td><?php echo $qiwis['token']?></td>
		<td><?php echo $qiwis['trans_type']?></td>


						<td><a href="edit-qiwi.php?act=edit&id=<?php echo $qiwis['id']?>"><i class="glyphicon glyphicon-edit"></i></a></td>
						<td><a href="save.php?act=delete&id=<?php echo $qiwis['id']?>&cat=qiwi" onclick="return navConfirm(this.href);"><i class="glyphicon glyphicon-trash"></i></a></td>
						</tr>
					<?php endforeach; ?>
					</table>
					<?php include "includes/footer.php";?>
				