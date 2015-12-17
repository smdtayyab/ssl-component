<?php
include "ssl.php";
$SSL =  new BGD\SSL;

//URL's that needs to be on SSL.
/*
	Eg for : https://www.example.com/cart, need to provide "/cart" 
	or for reference please provide url format as available while printing $_SESSION['REQUEST_URI'].
*/
$force_ssl = array('');
//URL's that needs can be neutral will server both on  SSL.
$neutral_pages =  array('');
$SSL->initialize($force_ssl,$neutral_pages);


?>	