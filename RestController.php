<?php
	require_once("MobileRestHandler.php");

	$method = $_SERVER['REQUEST_METHOD'];

	switch ($method) {
		case 'GET':
			$view = (isset($_GET["view"]) ? $_GET["view"] : "");

			switch($view)
			{
				case "all":
					$mobileRestHandler = new MobileRestHandler();
					$mobileRestHandler->getAll();
					break;
				case "item":
					$mobileRestHandler = new MobileRestHandler();
					$mobileRestHandler->getItem($_GET["id"]);
					break;
				case "cf" :
					//404 - not found;
					break;
				case "" :
					//404 - not found;
					break;
			}
			break;
		case 'POST':
			$value = (isset($_POST["value"]) ? $_POST["value"] : "");

			$mobileRestHandler = new MobileRestHandler();
			$mobileRestHandler->create($value);
			break;
		case 'PUT':
		    parse_str(file_get_contents('php://input'), $_PUT);

			$id    = (isset($_GET["id"   ]) ? $_GET["id"   ] : "");
			$value = (isset($_PUT["value"]) ? $_PUT["value"] : "");

			$mobileRestHandler = new MobileRestHandler();
			$mobileRestHandler->update($id, $value);
			break;
		case 'DELETE':
			$id    = (isset($_GET["id"   ]) ? $_GET["id"   ] : "");
			$mobileRestHandler = new MobileRestHandler();
			$mobileRestHandler->delete($id);
	}
?>
