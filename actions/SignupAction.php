<?

$return = array(
    'error' => 1,
    'message' => 'Қате. Мәліметтердің форматы дұрыс емес',
);

/* Configs */
require '../config/db.php';

// Соединямся с БД
$link=mysqli_connect($db['host'], $db['username'], $db['password'], $db['database']);

if(isset($_POST['Signup']))
{
    $model = $_POST['Signup'];
    $error = false;

    // проверям логин
    if(!preg_match("/^[a-zA-Z0-9]+$/",$model['login']))
    {
        $return = array(
            'error' => 1,
            'message' => 'Логин тек латын символдары мен цифрлардан тұруы мүмкін',
        );
        $error = true;
    }

    if(mb_strlen($model['login']) < 3 or strlen($model['login']) > 30)
    {
        $return = array(
            'error' => 1,
            'message' => 'Логин 3 символдан ұзынырақ және 30 символдан аспауы керек',
        );
        $error = true;
    }

    // проверяем, не сущестует ли пользователя с таким именем
    $query = mysqli_query($link, "SELECT user_id FROM users WHERE user_login='".mysqli_real_escape_string($link, $model['login'])."'");
    if(mysqli_num_rows($query) > 0)
    {
        $return = array(
            'error' => 1,
            'message' => 'Сіз енгізген логин біздің жүйеде тіркелген',
        );
        $error = true;
    }

    // Если нет ошибок, то добавляем в БД нового пользователя
    if(!$error)
    {

        $login = $model['login'];

        // Убераем лишние пробелы и делаем двойное хеширование
        $password = md5(md5(trim($_POST['Signup']['password'])));
        mysqli_query($link,"INSERT INTO users SET user_login='".$login."', user_password='".$password."'");
        $return = array(
            'error' => 0,
            'message' => 'Сіз тіркелдіңіз',
        );
    }

}

echo json_encode($return);

?>