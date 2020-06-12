<?php 
$mysqli = new mysqli($db['host'], $db['username'], $db['password'], $db['database']); 

/* проверка соединения */
if ($mysqli->connect_errno) {
    printf("Соединение не удалось: %s\n", $mysqli->connect_error);
    exit();
}
$query_department = "SELECT * FROM department";
$query_employee = "SELECT * FROM employee";

?>




<h2>Қызметкерлерге баға беру</h2>

<form class="rating_form ajax-form" action="actions/AjaxRequests.php" method="POST">


	<select name="department_id" id="rating_department">
		
		<? if ($result = $mysqli->query($query_department)) : ?>
			<? while ($row = $result->fetch_assoc()) : ?>
		        <option value="<?=$row['id']?>"><?=$row['name']?></option>
		    <? endwhile; ?>
		    
		<? $result->free(); endif; ?>
		
		<option value="-" selected="">Бөлімді таңдаңыз</option>
	</select>

	<select name="employee_id" id="rating_employee">
		
		<? if ($result = $mysqli->query($query_employee)) : ?>
			<? while ($row = $result->fetch_assoc()) : ?>
		        <option value="<?=$row['id']?>"><?=$row['name']?></option>
		    <? endwhile; ?>
		    
		<? $result->free(); endif; ?>

		<option value="-" selected="">Қызметкерді таңдаңыз</option>
	</select>


	<ul class="c-rating">
	  <input type="hidden" class="rating_val" name="rating" value="0">
	</ul>
	<textarea name="comment" id="" cols="30" rows="10" placeholder="Тілектеріңіз немесе шағымдарыңыз бар болса"></textarea>
	<button class="submit_btn">Бағалау</button>

</form>


<? $mysqli->close(); ?>