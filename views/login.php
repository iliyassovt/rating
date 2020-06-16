
<form method="POST" action="actions/SigninAction.php" class="login_form ajax-form">
	<input name="Signin[from_url]" type="hidden" value="<?= $request; ?>"><br>
	<input name="Signin[login]" class="text" type="text" required placeholder="Логин"><br>
	<input name="Signin[password]" class="text" type="password" required placeholder="Құпиясөз"><br>
	<input name="submit" type="submit" class="submit_btn" value="Кіру">
</form>