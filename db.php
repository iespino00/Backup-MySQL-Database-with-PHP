<?php
 require_once 'models/DBModel.php';
class DB
{
	function getDataBases()
	{
		// Uso sin mysql_list_dbs()
			$enlace = mysql_connect('localhost', 'root', 'password');
			$resultado = mysql_query("SHOW DATABASES");

			 $array = array();
			  $ind = 0;
			while ($fila = mysql_fetch_assoc($resultado)) 
			{
				  $dbModel = new DBModel();
				  $dbModel->Database = $fila['Database'];
			   // print_r($fila['Database']. "\n</br>");

				   $array[$ind] = $dbModel;
                   $ind++;
			}
			return $array;
	}
}


?>