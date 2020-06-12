<?

$return = array(
    'error' => 1,
    'message' => 'Ошибка. Неверный формат данных',
);

/* Configs */
require '../config/db.php';

$link = mysqli_connect($db['host'], $db['username'], $db['password'],  $db['database'] );
//var_dump($_POST);die;

if ( isset($_POST) && $_POST['rating'] != 0 && $_POST['department_id'] != '-' && $_POST['employee_id'] != '-' ) {
	$model = $_POST;
    
	$sql = 'INSERT INTO 
				marks 
			SET 
				rating = ' . $model["rating"] . ',
				comment = "' . $model["comment"] . '",
				department_id = "' . $model["department_id"] . '",
				employee_id = "' . $model["employee_id"] . '",
				create_time = ' . time()
				;
	$result = mysqli_query($link, $sql);

    $return['error'] = 0;
    $return['message'] =  'Рахмет, сіздің жауабыңыз қабылданды';
    //$return['reload'] =  true;

} else {

    $return['error'] = 1;
    $return['message'] =  'Мәліметтерді дұрыс енгізген жоқсыз';
    if ( $_POST['rating'] == 0 )
    	$return['message'] =  'Cіз баға берген жоқсыз, жұлдызшаны басыңыз';
    if ( $_POST['employee_id'] == '-' )
    	$return['message'] =  'Қызметкерді таңдаңыз';
    if ( $_POST['department_id'] == '-' )
    	$return['message'] =  'Бөлімді таңдаңыз';
    
}

echo json_encode($return);
