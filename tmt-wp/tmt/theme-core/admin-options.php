<?php 

$options = array (
  array(	"type" => "open"),
  array(	"name" => "Основные настройки",
		    "type" => "heading"),
array(	"name" => "Телефонный код",
            "id" => $shortname."_header_phone_cod",           
            "type" => "text"), 	
array(	"name" => "Телефон",
            "id" => $shortname."_header_phone", 
            "type" => "text"), 				
array(	"name" => "Дополнительные скрипты",
			"desc" => "",
            "id" => $shortname."_fscripts",
			     "std" => "",            
            "type" => "textarea"), 			
array(	"type" => "close")						
);
?>