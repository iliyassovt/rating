<? 

/* Configs */
require 'config/url_rules.php';
require 'config/db.php';
require 'functions.php';

require 'actions/CheckAction.php';

$request = '/';
if ( isset($_GET['id']) )  $request = $_GET['id']; 

$view = getView($request, $routes, $check_auth, $is_admin);
if ($view['status'] == 'error') {
	header('HTTP/1.0 404 Not Found');
}

require 'layout/header.php';

	if ( $check_auth == true && $view['status'] != 'error' ) {
		require 'layout/user_menu.php';
	} else {

	}


	if ( file_exists($view['url']) ){
		require $view['url'];
	}

require 'layout/footer.php';