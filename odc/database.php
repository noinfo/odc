<?
/**
* USAGE: odc_mysql_safe( string $query [, array $params ] )
* $query - SQL query WITHOUT any user-entered parameters. Replace parameters with "?"
*     e.g. $query = "SELECT date from history WHERE login = ?"
* $params - array of parameters
*
* Example:
*    odc_mysql_safe( "SELECT secret FROM db WHERE login = ?", array($login) );    # one parameter
*    odc_mysql_safe( "SELECT secret FROM db WHERE login = ? AND password = ?", array($login, $password) );    # multiple parameters
* That will result safe query to MySQL with escaped $login and $password.
**/
function odc_mysql_safe($connection, $query,$params=false) {
	
	if(emtpy($connection) || empty($query)){
		return NULL;
	}
	
    if ($params) {
        foreach ($params as $v){ 
        	$v = mysql_real_escape_string($v, $connection); 
        }    # Escaping parameters
        # str_replace - replacing ? -> %s. %s is ugly in raw sql query
        # vsprintf - replacing all %s to parameters
        $sql_query = vsprintf( str_replace("?","'%s'",$query), $params );   
    }
    return ($sql_query);
} 

require_once("odc_config.php");

function odc_my_query($sql,$params=false)
{

	if ($sql)
	{
	 $verbindung = odc_db_connect(); 
	 if ($verbindung)
	    {
		// Escapen von Parametern
		if ($params) {
			foreach ($params as $v){ 
				$v = mysql_real_escape_string($v, $verbindung); 
			}
			$sql = vsprintf( str_replace("?","'%s'",$sql), $params ); 
		}

	      // Abfrage hier:
		$ergebnis = mysql_query($sql, $verbindung);

		if (!$ergebnis)
		{
		      echo mysql_errno() . ": " . mysql_error() ."<br>\n";
		}

		// Beenden der Verbindung

		mysql_close();

		// und das Ergebnis an den User geben...
		return $ergebnis;

	     }
	     else
	       echo mysql_errno() . ": " . mysql_error() ;
	}
return "Database error";
}


function odc_my_insert($sql,$params=false)
{

	if ($sql)
	{
	 $verbindung = odc_db_connect();
	 if ($verbindung)
	    {
		// Escapen von Parametern
		if ($params) {
			foreach ($params as $v){ 
				$v = mysql_real_escape_string($v, $verbindung); 
			}
			$sql = vsprintf( str_replace("?","'%s'",$sql), $params ); 
		}

	      // Abfrage hier:
		$ergebnis = mysql_query($sql, $verbindung);

		if (!$ergebnis)
		{
		      echo mysql_errno() . ": " . mysql_error() ."<br>\n";
		}

//    $rueckgabe = mysql_insert_id();

     $rueckgabe = sprintf("%04d",mysql_insert_id());

		// Beenden der Verbindung
		mysql_close();

		// und das Ergebnis an den User geben...
		return $rueckgabe;

	     }
	}
return "Database error";
}

?>