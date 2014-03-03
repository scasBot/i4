<?php

/**********
* Allow CORS access requests
* http://www.w3.org/TR/cors/
***********/
function cors() {
	header("Access-Control-Allow-Origin: *");
}

/*****
* Global API error handler
******/
function error($msg = NULL) {
	if ($msg) {
		echo "Error: " . $msg; 
	} else {
		echo "0"; 
	}	
	die(); 
}

/*****
* Format JSON well, JSON_PRETTY_PRINT only exists post php 5.4
*****/
// http://stackoverflow.com/questions/6672656/how-can-i-beautify-json-programmatically
function pretty_json($json, $ret= "\n", $ind="\t") {
    $beauty_json = '';
    $quote_state = FALSE;
    $level = 0; 

    $json_length = strlen($json);
    for ($i = 0; $i < $json_length; $i++) {                               
        $pre = '';
        $suf = '';
        switch ($json[$i]){
            case '"':                               
                $quote_state = !$quote_state;                                                           
                break;
            case '[':                                                           
                $level++;               
                break;
            case ']':
                $level--;                   
                $pre = $ret;
                $pre .= str_repeat($ind, $level);       
                break;
            case '{':
                if ($i - 1 >= 0 && $json[$i - 1] != ',') {
                    $pre = $ret;
                    $pre .= str_repeat($ind, $level);                       
                }   
                $level++;   
                $suf = $ret;                                                                                                                        
                $suf .= str_repeat($ind, $level);                                                                                                   
                break;
            case ':':
                $suf = ' ';
                break;
            case ',':
                if (!$quote_state) {  
                    $suf = $ret;                                                                                                
                    $suf .= str_repeat($ind, $level);
                }
                break;
            case '}':
                $level--;   
            case ']':
                $pre = $ret;
                $pre .= str_repeat($ind, $level);
                break;
        }
        $beauty_json .= $pre.$json[$i].$suf;
    }
    return $beauty_json;
}   

/******
* To require shared resources with the main website
******/
function require_from_main($str) {
	require("../../includes/" . $str); 
}

?>