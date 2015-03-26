<?php
class obtener {


	public $table='lista';
	public $database='datos';
	public $password='';
	public $username='root';
	public $servername='localhost';


	private function querydb()
	{
		try {
			$dsn = 'mysql:dbname='.$this->database.';host='.$this->servername.';charset=utf8';
			$pdo = new PDO($dsn, $this->username, $this->password );
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

			$sql='SELECT time,value FROM '.$this->table;

			$this->sQuery = $pdo->prepare($sql);
			$pdo->beginTransaction();
        	$this->sQuery->execute();
        	$pdo->lastInsertId();
        	$pdo->commit();
			$result =$this->sQuery->fetchAll(PDO::FETCH_ASSOC);
			//$result = $pdo->query($sql);
			return $result;
			} catch (PDOException $e) {
    			print "Error" ;
    			
			}
	
	}
	
	public function mostrar()
	{
		$result=$this->querydb();

   		$tamano=sizeof($result);
   		//session_start();
		//$html=$_SESSION["user"]."<br>";

   		$html= '<table border="1" style="width:50%">';
   		$html.= '<tr><td>Tiempo</td><td>Valores</td></tr>';
   		for ($i=$tamano-16; $i <$tamano ; $i++) { 
   			$html.= '<tr>';
   			$html.= '<td>'.date('d/m/Y H:i:s',$result[$i]['time']).'</td>';
   			$html.= '<td>'.$result[$i]['value'].'</td>';
   			$html.= '</tr>';
   		}
   		$html.= '</table>';
		
		return $html;

	}

	}

/*
$gb=new obtener;
	echo $gb->mostrar();

*/
?>
