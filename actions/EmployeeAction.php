<?php 

require '../config/db.php';
$mysqli = new mysqli($db['host'], $db['username'], $db['password'], $db['database']); 

/* проверка соединения */
if ($mysqli->connect_errno) {
    printf("Соединение не удалось: %s\n", $mysqli->connect_error);
    exit();
}

if ( isset($_POST['action']) && $_POST['action'] == 'delete' ) {

	$id = intval($_POST['id']);
	$query = "DELETE FROM employee WHERE `id`=$id";	
	$result = $mysqli->query($query);

} elseif ( isset($_POST['action']) && $_POST['action'] == 'add' ) {
	$department_id = $_POST['department_id'];
	$employee = $_POST['employee'];
	$query = "INSERT INTO `employee` (`id`, `name`, `department_id`) VALUES (NULL, '$employee', '$department_id')";
	$result = $mysqli->query($query);
} elseif ( isset($_POST['action']) && $_POST['action'] == 'edit' ) {
	$id = $_POST['id'];
	$department_id = $_POST['department_id'];
	$employee = $_POST['employee'];
	$query = "UPDATE `employee` SET `name` = '$employee', `department_id` = '$department_id' WHERE `employee`.`id` = $id";	
	$result = $mysqli->query($query);
}



?>