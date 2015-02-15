<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>{% block title %}{% endblock %}</title>
    <link rel="stylesheet" href="/css/foundation.css">
</head>
<h1>Status N <?= $id ?></h1>

<a href="/statuses">Back to the main page</a>

<?php
	if (isset($com[0])) {
		$affichage = $com[0]['auteur'] . " : " . $com[0]['commentaire'] . "(" . $com[0]['dateC'] . ")";
	} else {
		$affichage = "Ce commentaire n'existe plus !";
	}
 ?>
 <?php if (isset($com[0])) : ?>
	 <div>
		<p>@<?= $com[0]['auteur'] ?> the <?= $com[0]['dateC'] ?></p>
		<p><?= $com[0]['commentaire'] ?></p>
		<?php if (isset($_SESSION['userName'])) : ?>
			<?php if ($com[0]['auteur'] == $_SESSION['userName']) : ?>
				<form action="/statuses/<?= $id ?>" method="POST">
					<input type="hidden" name="_method" value="DELETE">
					<input type="submit" value="Delete it...">
				</form>
			<?php endif; ?>
		<?php endif; ?>
	</div>
<?php endif; ?>
<?php if (!isset($com[0])) : ?>
	<div>This tweet doesn't exist</div>
<?php endif; ?>
