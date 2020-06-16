<?php 

require '../config/db.php';
$mysqli = new mysqli($db['host'], $db['username'], $db['password'], $db['database']); 

/* проверка соединения */
if ($mysqli->connect_errno) {
    printf("Соединение не удалось: %s\n", $mysqli->connect_error);
    exit();
}

$query_employee = "SELECT t.id, t.name, d.name as department, d.id as department_id FROM employee as t LEFT JOIN `department` as d ON t.department_id = d.id";
if ( isset($_POST['department']) && $_POST['department'] != '-' ) $query_employee .= " WHERE t.department_id = " . $_POST['department'];
$query_employee .= " ORDER BY t.id ASC";
$result_marks = $mysqli->query($query_employee); 

$query_department = "SELECT * FROM department";
$result_department = $mysqli->query($query_department);

?>

		
<? if ($result_marks) : ?>
	<table class="result_table">
		<thead>
			<tr>
				<td style="width: 3%;">ID</td>
				<td style="width: 25%; text-align: left;">Бөлім</td>
				<td style="width: 70%; text-align: left;">Қызметкер</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			<? while ($row = $result_marks->fetch_assoc()) : ?>
				<tr>
					<td><?=$row['id']?></td>
					<td style="text-align: left;"><?=$row['department']?></td>
					<td style="text-align: left;"><?=$row['name']?></td>
					<td>
						<a data-id="<?=$row['id']?>" href="#" class="del_employee">Өшіру</a>
						<a data-id="<?=$row['id']?>" data-name="<?=$row['name']?>" data-department="<?=$row['department_id']?>" href="#" class="edit_employee">Өзгерту</a>
					</td>
				</tr>
			<? endwhile; ?>
			
		</tbody>
	</table>
<? $result_marks->free(); endif; ?>


<form action="/actions/DepartmentAction.php" class="employee_form_add" style="margin: 20px 0;">
	<input type="hidden" class="id" value="-1" style="margin: 5px 0;"><br>
	<select name="department" id="rating_department2" class="select_department">
			
			<? if ($result_department) : ?>
				<? while ($row = $result_department->fetch_assoc()) : ?>
			        <option value="<?=$row['id']?>"><?=$row['name']?></option>
			    <? endwhile; ?>
			    
			<? $result_department->free(); endif; ?>
			
			<option value="-" selected="">Барлық бөлімдер</option>
		</select>
	<input type="text" class="employee" style="margin: 5px 0;"><br>
	<input type="submit" class="submit" value="Қосу" style="margin: 20px 0;">
</form>
