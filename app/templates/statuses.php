<html lang="en">
<head>
    <meta charset="utf-8"/>
     <link rel="stylesheet" href="/css/foundation.css">
</head>
<body>
<nav class="top-bar" data-topbar role="navigation">
  <ul class="title-area">
    <li class="name">
      <h1><a href="#">Shortener-URL</a></h1>
    </li>
     <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
    <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
  </ul>

</nav>
<h1>All Status</h1>

<?php if (!isset($_SESSION['userName'])) : ?>
	<a href="/signin">Create an account</a>
	<a href="/login">Log In</a>
<?php endif; ?>
<?php if (isset($_SESSION['userName'])) : ?>
	<p>Connected : <?= $_SESSION['userName'] ?> <a href="/logout">Log Out</a></p>
<?php endif ?>
<br />
<br />
<?php if (isset($_SESSION['outOfMemory'])) : ?>
	<p>Your tweet is too long sorry !</p>
<?php endif ?>
<form action="/statuses" method="POST">
    <label for="message">Message:</label>
    <textarea name="message"></textarea>

    <input type="submit" value="Tweet!">
</form>

<?php foreach($comm as $unCom) : ?>
	<div>
		<p>@<?= $unCom['auteur'] ?> the <?= $unCom['dateC']?></p>
		<p><?= $unCom['commentaire'] ?></p>
		<?php if (isset($_SESSION['userName'])) : ?>
			<?php if ($unCom['auteur'] == $_SESSION['userName']) : ?>
				<form action="/statuses/<?= $unCom['id'] ?>" method="POST">
					<input type="hidden" name="_method" value="DELETE">
					<input class="button" type="submit" value="Delete it...">
				</form>
			<?php endif; ?>
		<?php endif; ?>
	</div>
<?php endforeach; ?>

</body>
</html>
