<?php 

$mysqli = new mysqli($db['host'], $db['username'], $db['password'], $db['database']); 

/* проверка соединения */
if ($mysqli->connect_errno) {
    printf("Соединение не удалось: %s\n", $mysqli->connect_error);
    exit();
} 

$query_department = "SELECT * FROM department";
$query_employee = "SELECT * FROM employee";
$query_marks = "SELECT t.id, t.rating, t.comment, t.create_time, d.name as department_name, e.name as employee_name FROM `marks` as t LEFT JOIN `department` as d ON t.department_id = d.id LEFT JOIN `employee` as e ON t.employee_id = e.id";

$result_department = $mysqli->query($query_department);
$result_employee = $mysqli->query($query_employee);
//


//var_dump($data);die;

?>

<div class="block_30">
	<form class="result_form ajax-forms" action="" method="POST">


		<select name="department" id="rating_department">
			
			<? if ($result_department) : ?>
				<? while ($row = $result_department->fetch_assoc()) : ?>
			        <option value="<?=$row['id']?>"><?=$row['name']?></option>
			    <? endwhile; ?>
			    
			<? $result_department->free(); endif; ?>
			
			<option value="all" selected="">Барлық бөлімдер</option>
		</select>

		<select name="employee" id="rating_employee">
			
			<? if ($result_employee) : ?>
				<? while ($row = $result_employee->fetch_assoc()) : ?>
			        <option value="<?=$row['id']?>"><?=$row['name']?></option>
			    <? endwhile; ?>
			    
			<? $result_employee->free(); endif; ?>

			<option value="all" selected="">Барлық қызметкерлер</option>
		</select>

		<button class="submit_btn">Таңдау</button>

	</form>
</div>

<div class="block_70">

	<? if ( isset($_POST) && !empty($_POST) ) : ?>

		<? 
			if ( (isset($_POST['department']) && $_POST['department'] != 'all')  || (isset($_POST['employee']) && $_POST['employee'] != 'all') ) $query_marks .= " WHERE";
			if ( isset($_POST['department']) && $_POST['department'] != 'all' ) $query_marks .= " t.department_id = " . $_POST['department'];
			if ( isset($_POST['department']) && $_POST['department'] != 'all' && isset($_POST['employee']) && $_POST['employee'] != 'all' )  $query_marks .= " AND";
			if ( isset($_POST['employee']) && $_POST['employee'] != 'all' ) $query_marks .= " t.employee_id = " . $_POST['employee'];
			$query_marks .= " ORDER BY t.id DESC";
			//var_dump($query_marks);die;
			$result_marks = $mysqli->query($query_marks); 
		?>
		
		<? if ($result_marks) : ?>
			<table class="result_table">
				<thead>
					<tr>
						<td style="width: 5%;">ID</td>
						<td style="width: 20%;">Бөлім аты</td>
						<td style="width: 20%;">Қызметкер</td>
						<td style="width: 5%;">Бағасы</td>
						<td style="width: 25%;">Шағым</td>
						<td>Уақыты</td>
					</tr>
				</thead>
				<tbody>
					<? $total =0 ; $qty = 0; while ($row = $result_marks->fetch_assoc()) : ?>
						<tr>
							<td><?=$row['id']?></td>
							<td><?=$row['department_name']?></td>
							<td><?=$row['employee_name']?></td>
							<td><?=$row['rating']?></td>
							<td><?=$row['comment']?></td>
							<td><?=$row['create_time']?></td>
							<? 
								$total += $row['rating'];
								$qty++;
							?>
						</tr>
					<? endwhile; $average = round( $total / $qty, 2 ) ?>
					<tr>
						<td colspan="3">Орташа бағасы</td>
						<td><?= $average ?></td>
						<td colspan="2"></td>
					</tr>
				</tbody>
			</table>
		<? $result_marks->free(); endif; ?>

	<? endif; ?>
</div>