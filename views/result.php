<?php 

$mysqli = new mysqli($db['host'], $db['username'], $db['password'], $db['database']); 

/* проверка соединения */
if ($mysqli->connect_errno) {
    printf("Соединение не удалось: %s\n", $mysqli->connect_error);
    exit();
} 

$query_department = "SELECT * FROM department";
$result_department = $mysqli->query($query_department);

?>

<div class="block_30">
	<form class="result_form" action="actions/GetresultAction.php" method="POST">


		<select name="department" id="rating_department" class="select_department">
			
			<? if ($result_department) : ?>
				<? while ($row = $result_department->fetch_assoc()) : ?>
			        <option value="<?=$row['id']?>"><?=$row['name']?></option>
			    <? endwhile; ?>
			    
			<? $result_department->free(); endif; ?>
			
			<option value="-" selected="">Барлық бөлімдер</option>
		</select>

		<select name="employee" id="rating_employee" class="select_employee">
			<option value="-" selected="">Барлық қызметкерлер</option>
		</select>

		<input type="text" name="from_time" class="js_date alldate from_time time">
		<input type="text" name="to_time" class="js_date alldate to_time time">

		<button class="submit_btn">Таңдау</button>

	</form>
</div>

<div class="block_70">

	<span class="result_block"></span>

</div>