<?php

function check_login($db_conn)
{

    //if session value exists
	if(isset($_SESSION['manID']))
	{

		$id = $_SESSION['manID'];

		$query = "select * from Manager where manID = '$id' limit 1";
        $query_nrow = "SELECT COUNT(*) FROM Manager";

		$result = executePlainSQL($query);
        $result2 = executePlainSQL($query_nrow);


		if($result && ($result2) > 0){

			$user_data = oci_fetch_assoc($result);
			return $user_data;
		}
	}

	//redirect to login
	header("Location: login.php");
	die;

}

?>