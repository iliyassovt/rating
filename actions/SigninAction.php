<?
// Страница авторизации

// Функция для генерации случайной строки
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}

/* Configs */
require '../config/db.php';

// Соединямся с БД
$link=mysqli_connect($db['host'], $db['username'], $db['password'], $db['database']);

if(isset($_POST['Signin']))
{
    $model = $_POST['Signin'];

    // Вытаскиваем из БД запись, у которой логин равняеться введенному
    $query = mysqli_query($link,"SELECT user_id, user_password FROM users WHERE user_login='".mysqli_real_escape_string($link,$model['login'])."' LIMIT 1");
    $data = mysqli_fetch_assoc($query);

    // Сравниваем пароли
    if($data['user_password'] === md5(md5($model['password'])))
    {
        // Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));

        if(!empty($model['not_attach_ip']))
        {
            // Если пользователя выбрал привязку к IP
            // Переводим IP в строку
            $insip = ", user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."')";
        }

        // Записываем в БД новый хеш авторизации и IP
        mysqli_query($link, "UPDATE users SET user_hash='".$hash."' ".$insip." WHERE user_id='".$data['user_id']."'");

        // Ставим куки
        setcookie("id", $data['user_id'], time()+60*60, "/");
        setcookie("hash", $hash, time()+60*60, "/", null, null, true); // httponly !!!


        $return = array(
            'error' => 0,
            'message' => 'without_notice',
        );
        if ( $model['from_url'] == 'login' ) {
            $return['redirect'] = '/';
        } else {
            $return['reload'] = true;
        }
    }
    else
    {
        $return = array(
            'error' => 1,
            'message' => 'Сіз енгізген логин/құпиясөз комбинациясы жоқ',
        );
    }
}

echo json_encode($return);

?>