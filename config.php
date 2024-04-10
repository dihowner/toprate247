<?php
error_reporting(0);
ob_start();

$timeout = 18000; //30minute
if(isset($_SESSION['timeout'])) 
{
    // See if the number of seconds since the last
    // visit is larger than the timeout period.
   $duration = time() - (int)$_SESSION['timeout'];
    if($duration > $timeout) {
        // Destroy the session and restart it.
        session_destroy();
        session_start();
    }
}
 
// Update the timout field with the current time.
$_SESSION['timeout'] = time();



class Config
{
	public $host = "localhost";
    public $db_name = "toprate";
    public $username = "root";
    public $password = "";
    protected $con;
	
	public function __construct()
    {
        try
        {
            $this->con = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $exception)
        {
            $this->con = null;
            echo "Connection error: " . $exception->getMessage();
			die();
        }
        
    }


    //Functions

    /**
     * @return mixed
     */
	
	
    public function query($query)
    {
        $query = $this->con->prepare($query);
        return $query;
    }
	
    public function rows($query)
    {
		$q = $this->con->prepare($query);
        $r = $q->execute();
        $count = $q->rowCount();
        return $count;
    }
	
}

$obj = new Config();
?>