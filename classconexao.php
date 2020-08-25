<?php
class Conexao{

	public $conec;
	public $conecDB;
	
	public $hostBD;
	public $userBD;
	public $senhaBD;
	public $databaseBD;

	function __construct() {
	
		require("config.php");
	} //contrutor

	function conectar() {											//conectar ao servidor
        
	

		$this->conec = mysqli_connect($this->hostBD, $this->userBD, $this->senhaBD, $this->databaseBD);

		if(!$this->conec){
			die (msql_error());
		}
               
		return $this->conec;
	}

	function conferir_db() {										// rotarna true se conctar ao database
		return mysqli_select_db($this->databaseBD) or die('Não pude selecionar o banco de dados');
	//return $this->$conecDB ;
	}	

	function conectado()
	{
		// if($this->conectar() and $this->conferir_db())
		if($this->conectar())
		{
			return $this->conec;	
		}

		else
		{
			return 0;	
		}
	}

	function fechar() {										
	//	mysql_close($this->conec);
	}
}
?>