<?php

function check_login($db_conn)
{

    //if session value exists
	if(isset($_SESSION['manID']))
	{

		$manID = $_SESSION['manID'];

		$query = "select * from Manager where manID = '$manID' limit 1";
        $query_nrow = "SELECT COUNT(*) FROM Manager";

		$result = executePlainSQL($query);

		$checkExistingMan = "SELECT COUNT(*) AS count FROM Manager WHERE manID = '$manID'";
        $numExistingMan = executePlainSQL($checkExistingMan);
        $rowExistingMan = oci_fetch_assoc($numExistingMan);
        $countExistingMan = $rowExistingMan['COUNT'];



		if($result && $countExistingMan > 0){

			$user_data = oci_fetch_assoc($result);
			return $user_data;
		}
	}

	//redirect to login
	header("Location: login.php");
	die;

}

?>