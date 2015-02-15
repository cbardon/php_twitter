<?php

require __DIR__ . '/../vendor/autoload.php';

use Model\InMemoryFinder;
use Model\JsonFinder;
use Model\DatabaseAccess;
use Model\StatusDBFinder;
use Model\StatusDBDataMapper;
use Model\UserDBFinder;
use Model\UserDBDataMapper;
use Model\Status;
use Model\User;
use Http\Request;

session_start();

$dsn = "mysql:host=localhost;dbname=uframework";
$user = "uframework";
$password = "passw0rd";

$connection = new DatabaseAccess('localhost', 'uframework', 'uframework', 'passw0rd');

// Config
$debug = true;

$app = new \App(new View\TemplateEngine(
    __DIR__ . '/templates/'
), $debug);

/**
 * Index
 */
$app->get('/', function () use ($app) {
    $app->redirect('/statuses');
});

//~ /**
 //~ * Wall of statuses
 //~ */
//~ $app->get('/statuses', function () use ($app) {
	//~ $memory = new InMemoryFinder();	
	//~ $commentaire = $memory->findAll();
    //~ return $app->render('statuses.php', array("comm" => $commentaire));
//~ });
//~ 
//~ /**
 //~ * One status by ID
 //~ */
//~ $app->get('/statuses/(\d+)', function ($id) use ($app) {
	//~ $memory = new InMemoryFinder();	
	//~ $commentaire = $memory->findOneById($id);
    //~ return $app->render('status.php', array("com" => $commentaire, "id" => $id));
//~ });
//~ 
//~ /**
 //~ * One status by ID
 //~ */
//~ $app->get('/statuses/(\d+)', function (Request $request, $id) use ($app) {
	//~ $memory = new JsonFinder(__DIR__ . "/../data/statuses.json");	
	//~ $commentaire = $memory->findOneById($id);
    //~ return $app->render('status.php', array("com" => $commentaire, "id" => $id));
//~ });
//~ 
//~ /**
 //~ * Wall of statuses
 //~ */
//~ $app->get('/statuses', function () use ($app) {
	//~ $memory = new JsonFinder(__DIR__ . "/../data/statuses.json");	
	//~ $commentaire = $memory->findAll();
    //~ return $app->render('statuses.php', array("comm" => $commentaire));
//~ });
//~ 
//~ $app->post('/statuses', function (Request $request) use ($app) {
	//~ $author = $request->getParameter('username');
	//~ $commentaire = $request->getParameter('message');
    //~ $memory = new JsonFinder(__DIR__ . "/../data/statuses.json");	
    //~ $memory->addStatus($author, $commentaire);
    //~ $app->redirect('/statuses');
//~ });
//~ 
//~ $app->delete('/statuses/(\d+)', function (Request $request, $id) use ($app) {
	//~ $memory = new JsonFinder(__DIR__ . "/../data/statuses.json");
	//~ $memory->removeStatus($id);
	//~ $app->redirect('/statuses');
//~ });

/**
 * Wall of statuses
 */
$app->get('/statuses', function (Request $request) use ($app, $connection) {
	$memory = new StatusDBFinder($connection);	
	$commentaire = $memory->findAll($request);
	
	$userFinder = new UserDBFinder($connection);
	$i = 0;
	foreach ($commentaire as $unCommentaire) {
		$user = $userFinder->findOneById($unCommentaire['auteur']);
		if (count($user) === 0) {
			$commentaire[$i]['auteur'] = 'John Doe';
		} else {
			$commentaire[$i]['auteur'] = $user[0]['name'];
		}
		$i++;
	}
	
    return $app->render('statuses.php', array("comm" => $commentaire));
});

/**
 * One status by ID
 */
$app->get('/statuses/(\d+)', function (Request $request, $id) use ($app, $connection) {
	$memory = new StatusDBFinder($connection);	
	$commentaire = $memory->findOneById($id);
	
	if (count($commentaire) === 1) {
		$userFinder = new UserDBFinder($connection);
		$user = $userFinder->findOneById($commentaire[0]['auteur']);
		if (count($user) === 0) {
			$commentaire[0]['auteur'] = 'John Doe';
		} else {
			$commentaire[0]['auteur'] = $user[0]['name'];
		}
	}
	
    return $app->render('status.php', array("com" => $commentaire, "id" => $id));
});

/**
 * Make for add a status
 */
$app->post('/statuses', function (Request $request) use ($app, $connection) {
	if (isset($_SESSION['userId'])) {
		$author = $_SESSION['userId'];
	} else {
		$author = 0;
	}
	$commentaire = $request->getParameter('message');
	
	if (strlen($commentaire) <= 140) {
		if (isset($_SESSION['outOfMemory'])) {
			unset($_SESSION['outOfMemory']);
		}
		
		$memory = new StatusDBDataMapper($connection);
		$objStatus = new Status($author, $commentaire, date('Y-m-d H:i:s'));
		
		$memory->persist($objStatus);
		$app->redirect('/statuses');
	} else {
		$_SESSION['outOfMemory'] = true;
		$app->redirect('/statuses');
	}
});

/**
 * Delete the status by is ID (poor guy)
 */
$app->delete('/statuses/(\d+)', function (Request $request, $id) use ($app, $connection) {
	$memory = new StatusDBDataMapper($connection);
	$memory->remove($id);
	$app->redirect('/statuses');
});

/**
 * Make to add a users
 */
$app->post('/signin', function (Request $request) use ($app, $connection) {
	$user = $request->getParameter('username');
	$password = $request->getParameter('password');
	$confirmPassword = $request->getParameter('confirmPassword');
	
	if ($password === $confirmPassword) {
		$userFinder = new UserDBFinder($connection);
		$isUser = $userFinder->findOneByIsName($user);
		
		unsetSession();
		
		if (count($isUser) === 0) {
			$memory = new UserDBDataMapper($connection);
			$objUser = new User($user, $password);
			$memory->persist($objUser);
			
			$user2 = $userFinder->findOneByIsName($user);
			$_SESSION['userId'] = $user2[0]['id'];
			$_SESSION['userName'] = $user;
			$app->redirect('/statuses');
		} else {
			$_SESSION['wrongUser'] = true;
			$app->redirect('/signin');
		}
	} else {
		$_SESSION['badPassword'] = true;
		$app->redirect('/signin');
	}
});

/**
 * Go to create user page
 */
$app->get('/signin', function () use ($app) {
	return $app->render('createUser.php');
});

/**
 * Go to the log in page
 */
$app->get('/login', function () use ($app) {
	return $app->render('login.php');
});

/**
 * Verify if the user is good
 */
$app->post('/login', function (Request $request) use ($app, $connection) {
	$user = $request->getParameter('username');
	$password = $request->getParameter('password');
	
	$objUser = new User($user, $password);
	$userFinder = new UserDBFinder($connection);
	
	$ifGoodUser = $userFinder->findIfGoodUser($objUser);
	
	unsetSession();
	
	if (count($ifGoodUser) === 1) {
		$user2 = $userFinder->findOneByIsName($user);
		$_SESSION['userId'] = $user2[0]['id'];
		$_SESSION['userName'] = $user;
		$app->redirect('/statuses');
	} else {
		$_SESSION['wrongUser'] = true;
		$app->redirect('/login');
	}
});

/**
 * Log out
 */
$app->get('/logout', function () use ($app) {
	unsetSession();
	$app->redirect('/statuses');
});

/**
 * Use to unset the session about the user
 */
function unsetSession() {
	unset($_SESSION['userId']);
	unset($_SESSION['userName']);
	unset($_SESSION['wrongUser']);
	unset($_SESSION['badPassword']);
	unset($_SESSION['outOfMemory']);
}


return $app;
