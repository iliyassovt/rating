<?php 

require 'config/db.php';
$mysqli = new mysqli($db['host'], $db['username'], $db['password'], $db['database']); 

/* проверка соединения */
if ($mysqli->connect_errno) {
    printf("Соединение не удалось: %s\n", $mysqli->connect_error);
    exit();
}

$query_department = "SELECT * FROM department";
$result_marks = $mysqli->query($query_department); 
			
?>
		
<? if ($result_marks) : ?>
	<table class="result_table" style="width: 70%; margin: 0 auto;">
		<thead>
			<tr>
				<td style="width: 3%;">ID</td>
				<td style="width: 90%; text-align: left;">Бөлім атауы</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			<? while ($row = $result_marks->fetch_assoc()) : ?>
				<tr>
					<td><?=$row['id']?></td>
					<td style="text-align: left;"><?=$row['name']?></td>
					<td>
						<a data-id="<?=$row['id']?>" href="#" class="del_department">Өшіру</a>
						<a data-id="<?=$row['id']?>" data-name="<?=$row['name']?>" href="#" class="edit_department">Өзгерту</a>
					</td>
				</tr>
			<? endwhile; ?>

		</tbody>
	</table>
<? $result_marks->free(); endif; ?>

<form action="/actions/DepartmentAction.php" class="department_form" style="margin: 20px 0;">
	<input type="hidden" class="id" value="-1" style="margin: 5px 0;"><br>
	<input type="text" class="department" style="margin: 5px 0;"><br>
	<input type="submit" class="submit" value="Қосу" style="margin: 20px 0;">
</form>
