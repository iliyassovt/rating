<?php 

require '../config/db.php';
$mysqli = new mysqli($db['host'], $db['username'], $db['password'], $db['database']); 

/* проверка соединения */
if ($mysqli->connect_errno) {
    printf("Соединение не удалось: %s\n", $mysqli->connect_error);
    exit();
}


if ( isset($_POST['id']) && !empty($_POST['id']) ) {

	echo "<option value='-'>-- Қызметкерді таңдаңыз --</option>";
	$id = intval($_POST['id']);
	$query_employee = "SELECT * FROM employee WHERE `department_id`=$id";
	if ($result = $mysqli->query($query_employee)) {

		while ($row = $result->fetch_assoc()) {
	        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
		}
		$result->free(); 
	}
} elseif ( $_POST['id'] == 0 ) {
	echo "<option value='-'>-- Қызметкерді таңдаңыз --</option>";
}






?>
