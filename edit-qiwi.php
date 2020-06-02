<?php
				include "includes/header.php";
				$data=[];

				$act = $_GET['act'];
				if($act == "edit"){
					$id = $_GET['id'];
					$qiwi = getById("qiwi", $id);
				}
				?>

				<form method="post" action="save.php" enctype='multipart/form-data'>
					<fieldset>
						<legend class="hidden-first">Добавить кошелек</legend>
						<input name="cat" type="hidden" value="qiwi">
						<input name="id" type="hidden" value="<?=$id?>">
						<input name="act" type="hidden" value="<?=$act?>">
				
							<label>Телефон (без +)</label>
							<input class="form-control" type="text" name="phone" value="<?=$qiwi['phone']?>" /><br>
							
							<label>Token</label>
							<input class="form-control" type="text" name="token" value="<?=$qiwi['token']?>" /><br>
							
<!--							<label>Trans type</label>-->
<!--							<input class="form-control" type="text" name="trans_type" value="--><?//=$qiwi['trans_type']?><!--" /><br>-->
<!--							<br>-->
                        <label>Тип транзакций</label>
                        <select class="form-control" name="trans_type">
                            <option selected value="QIWI_CARD">По картам</option>
                            <option value="OUT">По кошельку</option>
                            <option value="ALL">По кошельку и картам</option>
                        </select>
                        <br>
					<input type="submit" value=" Save " class="btn btn-success">
					</form>
					<?php include "includes/footer.php";?>
				