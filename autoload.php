<?php

/* register autoloader here */
function my_autoload ($className) {
	$cheminCache = __DIR__ . DIRECTORY_SEPARATOR ."cache.php";
	if (is_file($cheminCache)){
		$mapping = require($cheminCache);
		if (in_array($className, $mapping) === FALSE) {
			$supUnd = str_replace('_', '/', $className);
			$supBackSlash =  str_replace('\\', '/', $supUnd);
			$aDossier = array("app", "src", "tests", "web");
			$newClass = null;
			if (is_file(__DIR__ . DIRECTORY_SEPARATOR . $supBackSlash . '.php')) {
				$newClass = __DIR__ . DIRECTORY_SEPARATOR . $supBackSlash . '.php';
			} else {
				foreach($aDossier as $unDossier) {
					if (is_file(__DIR__ . DIRECTORY_SEPARATOR . $unDossier . DIRECTORY_SEPARATOR . $supBackSlash . '.php')) {
						$newClass = __DIR__ . DIRECTORY_SEPARATOR . $unDossier . DIRECTORY_SEPARATOR . $supBackSlash . '.php';
					}	
				}
			}
			if ($newClass != null) {
				$mapping[$className] = $newClass;
				$str = var_export($mapping, true);
				file_put_contents($cheminCache, sprintf("<?php \n return %s;", $str));
				require_once $mapping[$className];
			}
		} else {
			$supUnd = str_replace('_', '/', $className);
			$supBackSlash =  str_replace('\\', '/', $supUnd);
			$mapping[$className] = __DIR__ . DIRECTORY_SEPARATOR .$supBackSlash.'.php';
		require_once $mapping[$className];
		}
	} else {
		file_put_contents($cheminCache, sprintf("<?php \n return [];"));
		my_autoload($className);
	}
}

spl_autoload_register("my_autoload");

