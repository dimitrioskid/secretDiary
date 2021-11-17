<?php 
class DB {
	//class members
	private $servername ="localhost";
	private $db_username ="root";
	private $db_password = "";
	private $db_name = "diary";
	private $conn;

	public function __construct(){
		try {
		    $this->conn = new PDO("mysql:host=".$this->servername."; dbname=".$this->db_name."", $this->db_username, $this->db_password);
		    // set the PDO error mode to exception
		    $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$statement  = $this->conn->prepare("SET NAMES 'utf8'");
			$statement->execute();
			ini_set('default_charset', 'utf-8');
		    echo "Connected successfully";
		    }
		catch(PDOException $e)
		    {
		    echo "Connection failed: " . $e->getMessage();
		    }

    } //end constructor
	
	
	
}//end class DB
?>