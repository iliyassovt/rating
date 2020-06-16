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
	$query = "DELETE FROM department WHERE `id`=$id";	
	$result = $mysqli->query($query);

} elseif ( isset($_POST['action']) && $_POST['action'] == 'add' ) {
	$department = $_POST['department'];
	$query = "INSERT INTO `department` (`id`, `name`) VALUES (NULL, '$department')";	
	$result = $mysqli->query($query);
} elseif ( isset($_POST['action']) && $_POST['action'] == 'edit' ) {
	$id = $_POST['id'];
	$department = $_POST['department'];
	$query = "UPDATE `department` SET `name` = '$department' WHERE `department`.`id` = $id";	
	$result = $mysqli->query($query);
	//var_dump($_POST);die;
}



?>