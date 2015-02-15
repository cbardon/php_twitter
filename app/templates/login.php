<h1>Log In and tweet !</h1>

<a href="/statuses">Back to the main page</a>

<?php if(isset($_SESSION['wrongUser'])) : ?>
	<p>The user name and password doesn't match !</p>
<?php endif; ?>

<form action="/login" method="POST">
	<p>Login : <input type="text" name="username" /></p>
	<p>Password : <input type="password" name="password" /></p>
	<input type="submit" value="Se connecter">
</form>
