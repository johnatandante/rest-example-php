<?php
	require_once("SimpleRest.php");
	require_once("Mobile.php"    );
			
	class MobileRestHandler extends SimpleRest 
	{
		function getAll() 
		{	
			$mobile  = new Mobile();
			$rawData = $mobile->getAll();

			if(empty($rawData)) {
				$statusCode = 404;
				$rawData = array('error' => 'No mobiles found!');		
			} else {
				$statusCode = 200;
			}

			$requestContentType = $_SERVER['HTTP_ACCEPT'];
			$this->setHttpHeaders($requestContentType, $statusCode);

			if(strpos($requestContentType,'application/json') !== false) {
				$response = $this->encodeJson($rawData);
				echo $response;
			} else if(strpos($requestContentType,'text/html') !== false) {
				$response = $this->encodeHtml($rawData);
				echo $response;
			} else if(strpos($requestContentType,'application/xml') !== false) {
				$response = $this->encodeXml($rawData);
				echo $response;
			}
		}
		
		//------------------------------------------------------------------------------------------
		
		public function getItem($id) 
		{
			$mobile  = new Mobile();
			$rawData = $mobile->getItem($id);

			if (empty($rawData)) {
				http_response_code(404);
				return;
			}

			$statusCode = 200;
			$requestContentType = $_SERVER['HTTP_ACCEPT'];
			$this ->setHttpHeaders($requestContentType, $statusCode);
					
			if(strpos($requestContentType,'application/json') !== false){
				$response = $this->encodeJson($rawData);
				echo $response;
			} else if(strpos($requestContentType,'text/html') !== false){
				$response = $this->encodeHtml($rawData);
				echo $response;
			} else if(strpos($requestContentType,'application/xml') !== false){
				$response = $this->encodeXml($rawData);
				echo $response;
			}
		}
		
		//------------------------------------------------------------------------------------------
		
		public function create($value) 
		{
			if (empty($value)) {
				http_response_code(400);
				return;
			} 

			$mobile  = new Mobile();
			if ($mobile->create($value))
				 http_response_code(201);
			else http_response_code(500);
		}
		
		//------------------------------------------------------------------------------------------
		
		public function update($id, $value) 
		{
			if (!is_numeric($id)) {
				http_response_code(400);
				return;
			} 
			
			if (empty($value)) {
				http_response_code(400);
				return;
			} 

			$mobile  = new Mobile();
			if ($mobile->update($id, $value))	
				 http_response_code(201);
			else http_response_code(404);
		}
		
		//------------------------------------------------------------------------------------------
		
		public function delete($id) 
		{
			if (!is_numeric($id)) {
				http_response_code(400);
				return;
			} 

			$mobile  = new Mobile();
			if ($mobile->delete($id))	
				 http_response_code(201);
			else http_response_code(400);
		}

		//==========================================================================================
				
		public function encodeJson($responseData) 
		{
			$jsonResponse = json_encode($responseData);
			return $jsonResponse;		
		}

		public function encodeHtml($responseData) 
		{		
			$htmlResponse = "<table border='1'>";
			foreach($responseData as $key=>$value) {
					$htmlResponse .= "<tr><td>". $key. "</td><td>". $value. "</td></tr>";
			}
			$htmlResponse .= "</table>";
			return $htmlResponse;		
		}
		
		public function encodeXml($responseData) 
		{
			// creating object of SimpleXMLElement
			$xml = new SimpleXMLElement('<?xml version="1.0"?><mobile></mobile>');
			foreach($responseData as $key=>$value) {
				$xml->addChild($key, $value);
			}
			return $xml->asXML();
		}		
	}
?>