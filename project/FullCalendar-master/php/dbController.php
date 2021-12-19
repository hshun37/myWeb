<?php
class DBController
{
    private $host = 'localhost';
    private $database = 'calendar';
    private $userid = 'test';
    private $password = '1234';
    protected $db;

    public function __construct()
    {
        $this->db = $this->connectDB();
    }

    public function __destruct()
    {
        mysqli_close($this->db);
    }

    private function connectDB()
    {
        try {
            $dbconn = mysqli_connect($this->host, $this->userid, $this->password, $this->database);
            mysqli_set_charset($dbconn, "utf8"); // DB설정이 잘못되어 euc-kr 로 되어 있으면 문제가 됨
            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            } else {
                return $dbconn;
            }
        } catch (Exception $e) {
            printf("Connect failed: %s\n", mysqli_connect_error());
        }
    }   
    public function sql_exec($querystr)
    {
        try {
            $result = mysqli_query($this->db, $querystr);

            if (!$result) {
                printf("Connect failed: %s\n", mysqli_error($this->db));
                return false;
            }

            // mysqli_free_result($result);
        } catch (Exception $e) {
            printf("db failed: %s\n", $e);
        }
        return true;
    }
    public function sql_select($querystr)
    {
        try
        {
            $result = mysqli_query($this->db, $querystr);

            $test=mysqli_num_rows($result);

            if (mysqli_num_rows($result) < 1) {              
                return;
            }

            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_free_result($result);

        } catch (Exception $e) {
            printf("db failed: %s\n", $e);
        }
        return $rows;
    }
}
