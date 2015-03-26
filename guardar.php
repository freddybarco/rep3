<?php
class guardar {

	private $sQuery;
	private $url='http://engels.soy/concurso2015i/api.php?val=kW';
	private $proxy='10.164.1.27';
	private $port='8080';
	private $userpassw='SESA372104:Avanzados1';
	public $table='lista';
	public	$database='datos';
	public $password='';
	public $username='root';
	public $servername='localhost';


	public function __construct()
		{                                
			
			$this->estado=$this->almacenar();
			
		}

	public function __destruct()
		{
			$this->estado = NULL;
			$this->pdo = NULL;
		}



	private function almacenar()
		{	
			$c=0;
			$a=array();
			$a[0]='';
			$m=0;
			while($m<15) { 
				sleep(0.25);
				$obj=json_decode($this->curlFile($this->url,$this->proxy,$this->port,$this->userpassw));
				$c=$c+1;
				$a[$c]=$obj->{'value'};
		
				if($a[$c-1]!=$a[$c])
				{	$m=$m+1;

				$this->insertar($obj->{'time'},$obj->{'value'});
				}

			}
			return 'recuperado';
		}
		

		private function insertar($tiempo,$valor)
		{
			try {
				$dsn = 'mysql:dbname='.$this->database.';host='.$this->servername.';charset=utf8';
				$pdo = new PDO($dsn, $this->username, $this->password );
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			
				$sql='INSERT INTO '.$this->table.' (time, value)
				VALUES ('.$tiempo.', '.$valor.')';

				$this->sQuery = $pdo->prepare($sql);
				$pdo->beginTransaction();
        		$this->sQuery->execute();
        		$return = $pdo->lastInsertId();
        		$pdo->commit();

				//$pdo->query($sql);
				} catch (PDOException $e) {
	    			print "¡Error!: " ;
	    			
				}
			
		}

		private function curlFile($url,$proxy_ip,$proxy_port,$loginpassw)
		{


	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_PROXYPORT, $proxy_port);
	    curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
	    curl_setopt($ch, CURLOPT_PROXY, $proxy_ip);
	    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $loginpassw);
	    $data = curl_exec($ch);
	    curl_close($ch);

	    return $data;
		}

}

	$gb = new guardar;
	echo $gb->estado;



?>
