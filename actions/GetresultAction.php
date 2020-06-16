<?php 

require '../config/db.php';
$mysqli = new mysqli($db['host'], $db['username'], $db['password'], $db['database']); 

/* проверка соединения */
if ($mysqli->connect_errno) {
    printf("Соединение не удалось: %s\n", $mysqli->connect_error);
    exit();
}

$query_marks = "SELECT t.id, t.rating, t.comment, t.create_time, d.name as department_name, e.name as employee_name FROM `marks` as t LEFT JOIN `department` as d ON t.department_id = d.id LEFT JOIN `employee` as e ON t.employee_id = e.id";
?>

<? if ( isset($_POST) ) : ?>

		<? 
			if ( (isset($_POST['department']) && $_POST['department'] != '-')  || (isset($_POST['employee']) && $_POST['employee'] != '-') ) $query_marks .= " WHERE";
			if ( isset($_POST['department']) && $_POST['department'] != '-' ) $query_marks .= " t.department_id = " . $_POST['department'];
			if ( isset($_POST['department']) && $_POST['department'] != '-' && isset($_POST['employee']) && $_POST['employee'] != '-' )  $query_marks .= " AND";
			if ( isset($_POST['employee']) && $_POST['employee'] != '-' && $_POST['employee'] != '' ) $query_marks .= " t.employee_id = " . $_POST['employee'];
			$query_marks .= " ORDER BY t.id DESC";
			//var_dump($query_marks);die;
			$result_marks = $mysqli->query($query_marks); 

		?>
		
		<? if ($result_marks) : ?>
			<table class="result_table">
				<thead>
					<tr>
						<td style="width: 3%;">ID</td>
						<td style="width: 20%;">Бөлім атауы</td>
						<td style="width: 25%;">Қызметкер</td>
						<td style="width: 3%;">Бағасы</td>
						<td style="width: 30%;">Шағым/Тілек</td>
						<td>Уақыты</td>
					</tr>
				</thead>
				<tbody>
					<? $total = 0 ; $qty = 0; while ($row = $result_marks->fetch_assoc()) : ?>
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
					<? endwhile; $average = ($qty != 0) ? round( $total / $qty, 2 ) : '-'; ?>
					<? if ( $average != '-' ) : ?>
						<tr>
							<td colspan="3">Орташа бағасы</td>
							<td><?= $average ?></td>
							<td colspan="2"></td>
						</tr>
					<? else : ?>
						<tr>
							<td colspan="6" style="padding: 40px;">Әзірше дауыс берілген жоқ</td>
						</tr>
					<? endif; ?>
				</tbody>
			</table>
		<? $result_marks->free(); endif; ?>

	<? endif; ?>