<?//var_dump($_SESSION);die; ?>

<form method="POST" action="actions/SigninAction.php" class="ajax-form">
<input name="Signin[from_url]" type="hidden" value="<?= $request; ?>"><br>
Логин <input name="Signin[login]" type="text" required><br>
Пароль <input name="Signin[password]" type="password" required><br>
<input name="submit" type="submit" value="Войти">
</form>