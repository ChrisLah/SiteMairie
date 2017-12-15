<?php
	require_once "./lib/File.php";
	if (isset($_GET['controller']) && isset($_GET['action']))
	{
		$controller = 'Controller'.ucfirst($_GET['controller']);
		
		$filename = 'controller/'.$controller.'.php';
		if(file_exists($filename))
		{
			require_once File::build_path(array('controller',$controller.'.php'));
			$action = $_GET['action'];
			if(method_exists($controller,$action))
			{
				$controller::$action();
			}
			else
			{
				require_once File::build_path(array('controller','ControllerAccueil.php'));
				ControllerAccueil::afficher();
			}
		}
		else
		{
			require_once File::build_path(array('controller','ControllerAccueil.php'));
			ControllerAccueil::afficher();
		}
	}
	else
	{
		require_once File::build_path(array('controller','ControllerAccueil.php'));
		ControllerAccueil::afficher();
	}
