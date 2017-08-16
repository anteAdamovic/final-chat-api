<?php
	$origin = getallheaders()['Origin'];
	
	// For development
	if( strcmp($origin, 'http://localhost:4200') == 0 )
		header('Access-Control-Allow-Origin: http://localhost:4200');
		
	elseif( strcmp($origin, 'http://localhost:8100') == 0 )
		header('Access-Control-Allow-Origin: http://localhost:8100');
	
?>