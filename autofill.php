<?php
define('DB_SERVER', 'localhost');
define('DB_USER', 'itasca11_user');
define('DB_PASSWORD', '6X4n1xs_x0?6');
define('DB_NAME', 'itasca11_portal');
if (isset($_GET['term'])){
	$return_arr = array();

	try {
	    $conn = new PDO("mysql:host=".DB_SERVER.";port=8889;dbname=".DB_NAME, DB_USER, DB_PASSWORD);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    
	    $stmt = $conn->prepare('SELECT name_f, name_l FROM interpreters WHERE name_l LIKE :term OR name_f LIKE :term');
	    $stmt->execute(array('term' => '%'.$_GET['term'].'%'));
	    
	    while($row = $stmt->fetch()) {
	        $return_arr[] =  $row['name_f'] . ' ' . $row['name_l'];
	    }

	} catch(PDOException $e) {
	    echo 'ERROR: ' . $e->getMessage();
	}


  //   Toss back results as json encoded array. 
    echo json_encode($return_arr);
}
?>
