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
		if (!empty($_POST['user']) && !empty($_POST['password'])) {
		$this->user=$_POST["user"];
		$this->pass=$_POST["password"];
		$this->login=False;
		}
		else
		{
			header('Location: index.php');
		}			


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
	
		if($this->verificar($this->user,$this->pass) )
		{
			$timestamp=time();
			//echo "Tiempo :".$timestamp."   -    ".date('d/m/Y H:i:s',$timestamp)."<br>";
			$this->grabar_session($timestamp,$user);
			session_start();
			$_SESSION["user"]=$this->user;
			$_SESSION["password"]=$this->pass;
			$_SESSION["hgddX34355fD"]=True;

			header('Location: mediciones.php');
		}
		else
		{
			//echo $this->password."  ".$this->user;
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

			$sql=$consult.$this->table.' WHERE userId =:user';
			$this->sQuery = $pdo->prepare($sql);
			$this->sQuery->bindParam(':user', $user, PDO::PARAM_STR,12);
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

			$sql='UPDATE '.$this->table.' SET lastConnection =:timestamp WHERE userId =":user"';
			$this->sQuery = $pdo->prepare($sql);
			$this->sQuery->bindParam(':timestamp', $timestamp, PDO::PARAM_STR,12);
			$this->sQuery->bindParam(':user', $user, PDO::PARAM_STR,12);
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
