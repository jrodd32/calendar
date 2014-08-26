<?php

/**
 *	Class that takes in a URL and parses it into a JSON object
 */
class XmlToJson {
	public function Parse ($url) {
		
		// Get the file contents from the URL 
		// Note: file_get_contents needs to be allowed on server
		$fileContents= file_get_contents($url);

		$fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);

		$fileContents = trim(str_replace('"', "'", $fileContents));

		$simpleXml = simplexml_load_string($fileContents);

		$json = json_encode($simpleXml);

		return $json;

	}
}
?>

	
	