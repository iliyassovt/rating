<? 

function getView($request, $routes, $check_auth, $is_admin) {

	$view = [];
	$defaultView = generateViewUrl($request);

	/* если запрос есть в таблице роутинга url_rules.php */
	if ( isset($routes[$request])) {

		/* если есть файл вьюхи */
		if ( file_exists($routes[$request]['url']) ) {
			
			/* если к файлу вьюхи доступ только админам */
			if ($routes[$request]['access'] == 'admin') {

				if (!$check_auth) {
					$view = ['url' => generateViewUrl('login'), 'status' => 'success'];
				} elseif ($is_admin) {
					$view = ['url' => $routes[$request]['url'], 'status' => 'success'];
				} else {
					$view = ['url' => generateViewUrl('rights'), 'status' => 'success'];
				}		

			} else {

				$view = ['url' => $routes[$request]['url'], 'status' => 'success'];
			}

		} else {

		    $view =  ['url' => $routes['error']['url'], 'status' => 'error'];

		}

	}
	/* если запроса нет в таблице роутинга url_rules.php берем сформированный урл */
	elseif ( file_exists( $defaultView ) ) {
		$view = ['url' => $defaultView, 'status' => 'success'];
	}
	else {
		$view = ['url' => $routes['error']['url'], 'status' => 'error'];
	}

	return $view;

}

function generateViewUrl($request) {
	return 'views/'.$request.'.php';
}