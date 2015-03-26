<?php
class login
{

	public $table='users';
	public $database='datos';
	public $password='';
	public $username='root';
	public $servername='localhost';



	public function __construct()
	{
		session_start();
		$_SESSION["user"]=$_REQUEST["user"];
		$_SESSION["password"]=$_REQUEST["password"];
		$_SESSION["hgddX34355fD"]=False;
	}

	public function __destruct()
	{
		/*
		session_unset(); 
		session_destroy(); 
		*/
	}

	public  function acceso()
	{
		
		$user=$_SESSION["user"];
		//echo "Usuario :".$user."<br>";
		$password=$_SESSION["password"];
		//echo "Password :".$password."<br>";
	
		if($this->verificar($user,$password))
		{
			$timestamp=time();
			//echo "Tiempo :".$timestamp."   -    ".date('d/m/Y H:i:s',$timestamp)."<br>";
			$this->grabar_session($timestamp,$user);
			$_SESSION["hgddX34355fD"]=True;
			header('Location: mediciones.php');
		}
		else
		{
			header('Location: index.php');
			//echo "No se pudo verificar"."<br>";
		}
			
	
	}

	private function verificar($user,$password="")
	{
		
		$result=$this->querydb($user);
		//echo "md5_password : ".$result[0]["password"]."<br>";
		$hashed_password = crypt($result[0]["password"]); //Desde DB
		//echo "hashed_password : ".$hashed_password."<br>";

		if ($this->hash_equals_($hashed_password, crypt(md5($password), $hashed_password))) {
			   	return True;
			}
			else{
				return False;
			}
	}

	private function hash_equals_($str1, $str2) 
	{
			if(strlen($str1) != strlen($str2)) {
				return false;
			} else {
				$res = $str1 ^ $str2;
				$ret = 0;
				for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
					return !$ret;
			    	}
	}

	private function querydb($user)
	{
		$consult='SELECT userId, name, lastname, password, email, lastConnection, authority  FROM ';
		try {
			$dsn = 'mysql:dbname='.$this->database.';host='.$this->servername.';charset=utf8';
			$pdo = new PDO($dsn, $this->username, $this->password );
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

			$sql=$consult.$this->table.' WHERE userId = '."'".$user."'";
			$this->sQuery = $pdo->prepare($sql);
			$pdo->beginTransaction();
        	$this->sQuery->execute();
        	$pdo->lastInsertId();
        	$pdo->commit();
			$result =$this->sQuery->fetchAll(PDO::FETCH_ASSOC);

			return $result;
			} catch (PDOException $e) {
    			print "Error_Select"."<br>" ;
    			
			}
	
	}

	private function grabar_session($timestamp,$user)
	{
		try {
			$dsn = 'mysql:dbname='.$this->database.';host='.$this->servername.';charset=utf8';
			$pdo = new PDO($dsn, $this->username, $this->password );
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

			$sql='UPDATE '.$this->table.' SET lastConnection ='.$timestamp.' WHERE userId ='."'".$user."'";
			//echo $sql."<br>";
			
			$this->sQuery = $pdo->prepare($sql);
			$pdo->beginTransaction();
        	$this->sQuery->execute();
        	$pdo->lastInsertId();
        	$pdo->commit();

			} catch (PDOException $e) {
    			print "Error_grabar"."<br>" ;
    			
			}
	

	}

}


	$gb = new login;
	echo $gb->acceso();
?>
