<?php
class Database{
    private $connection;
    public function __construct(){
        $this->connection = mysqli_connect("localhost","root","","survey");
    }
    public function is_connected(){
        return $this->connection;
    }
    public function check(){
        echo "Working DB handlerrr";
    }
    public function resetDatabase(){
        $sql = "
        drop table student;
        drop table admin;
        drop table faculty;
        ";
        mysqli_multi_query($this->connection,$sql);
        echo "tables deleted";
    }
    public function query($query_string){
        $result = mysqli_query($this->connection, $query_string);
        if(gettype($result)=="boolean"){
            if($result) return 1;
            else return 0;
        }
        else{
            $array = [];
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    array_push($array,$row);
                }
                return $array;
            }
            else{
                return false;
            }
        }
        
    }

    public function exist_db($dbname){
        $query_string = "SHOW DATABASES LIKE `".$dbname."`";
        $result = mysqli_query($this->connection, $query_string);
        if($result) return true;
        else return false;
    }
    public function exist_table($tablename){
        $query_string = "SHOW TABLES LIKE '".$tablename."'";
        $result = mysqli_query($this->connection, $query_string);
        if($result && mysqli_num_rows($result)>0) return true;
        else return false;
        
    }
}

$db=new Database;

?>