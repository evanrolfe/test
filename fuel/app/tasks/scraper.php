<?php

namespace Fuel\Tasks; 
use \DOMDocument;

class Scraper
{
	public static function run(){
		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_URL, "http://www.yachtfractions.co.uk/UK/sail.asp");
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		 $contents = curl_exec ($ch);
		 curl_close ($ch);

		$doc = new DOMDocument();
		@$doc->loadHTML($contents);

		$urls = array();
		$links = $doc->getElementsByTagName("a");

		foreach($links as $link){
			$parsed_url = explode("=",$link->attributes->getNamedItem('href')->nodeValue);
			($link->nodeValue == "More details...") and $urls[] = $parsed_url[1];
		}

		$data = array();
		foreach($urls as $id){
			$data[] = get_data_for_id($id);
		}

		echo sizeof($data)."# Boats";
	}
}


	function get_inner_html( $node ) { 
		$innerHTML= ''; 
		$children = $node->childNodes; 
		foreach ($children as $child) { 
		    $innerHTML .= $child->ownerDocument->saveXML( $child ); 
    	} 

   		return $innerHTML; 
	} 



	function get_data_for_id($id)
	{
		 $ch = curl_init();

		 curl_setopt($ch, CURLOPT_URL, "http://www.yachtfractions.co.uk/UK/detail.asp?ID=".$id);

		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		 $contents = curl_exec ($ch);

		 curl_close ($ch);

		$doc = new DOMDocument();
		@$doc->loadHTML($contents);
		//echo $doc->saveHTML();

		$data = array();

		$hs = $doc->getElementsByTagName("h1");
		$data['name'] = get_inner_html($hs->item(0));

		$lists = $doc->getElementsByTagName("ul");

		$i=0;
		foreach($lists as $ul){
			//echo $i.") ".$ul->nodeValue."<hr>";
	
			switch($i)
			{
				case 0:
					$key = "Sailing Equipment";
				break;

				case 1:
					$key = "Engine, Batteries and Tanks";
				break;

				case 2:
					$key = "Navigation and Safety";
				break;

				case 3:
					$key = "Accomodation";
				break;

				case 4:
					$key = "Dinghy";
				break;

				case 5:
					$key = "Owner's Comments";
				break;

				case 6:
					$key = "Annual Running Costs";
				break;
			}

			$data[$key] = $ul->nodeValue;
			$i++;
		}

		$cells = $doc->getElementsByTagName("td");

		$i=0;

		foreach($cells as $td){
			//echo $i.") ".$td->nodeValue->nodeValue."<hr>";

			switch($i)
			{
				case 2:
					$data['LOA'] = $td->nodeValue->nodeValue;
				break;

				case 5:
					$data['LWL'] = $td->nodeValue->nodeValue;
				break;

				case 8:
					$data['Beam'] = $td->nodeValue->nodeValue;
				break;

				case 11:
					$data['Draft'] = $td->nodeValue->nodeValue;
				break;

				case 14:
					$data['Keel'] = $td->nodeValue->nodeValue;
				break;

				case 17:
					$data['Built'] = $td->nodeValue->nodeValue;
				break;

				case 20:
					$data['Lying'] = $td->nodeValue->nodeValue;
				break;
			}
			$i++;
		}

		return $data;		
	}
