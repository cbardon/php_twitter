<h1>Thank you to join us !</h1>

<a href="/statuses">Back to the main page</a>

<?php if(isset($_SESSION['wrongUser'])) : ?>
	<p>This user already exist !</p>
<?php endif; ?>

<?php if(isset($_SESSION['badPassword'])) : ?>
	<p>Passwords doesn't match !</p>
<?php endif; ?>

<form action="/signin" method="POST">
	<p>Login : <input type="text" name="username" /></p>
	<p>Password : <input type="password" name="password" /></p>
	<p>Confirm password : <input type="password" name="confirmPassword" /></p>
	<input type="submit" value="enregistrer">
</form>
