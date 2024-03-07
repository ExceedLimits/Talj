<?php
class Database{

    private $connection = null;

    private $table="";

    private $where=[];

    private $orderBy="created_at";

    private $orderByType="DESC";

    private $limit=null;

    private $offset=null;

    private $data=[];


    // this function is called everytime this class is instantiated
    public function __construct( $dbhost = "localhost", $dbname = "", $username = "root", $password    = ""){

        try{

            $this->connection = new mysqli($dbhost, $username, $password, $dbname);

            if( mysqli_connect_errno() ){
                throw new Exception("Could not connect to database.");
            }

        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }

    }

    public function structure($table,$fields):string{
        $sql="CREATE TABLE IF NOT EXISTS ".$table." (";
        $sql.="id bigint(20) unsigned NOT NULL AUTO_INCREMENT ,";
        $fields[]="created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ";
        $fields[]="updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ";
        $fields[]=" UNIQUE KEY id (id) ";
        $sql.=implode(',',$fields).");";
        return $sql;
    }

    // Create a Database Table
    public function Create($table, $fields=[]){
        return $this->executeStatement($this->structure($table,$fields));
    }

    public function Drop($table):void{
        $this->executeStatement("DROP TABLE IF EXISTS ".$table);
    }

    public function data($data=[]){
        $this->data=$data;
        return $this;
    }

    public function update($id){
        try{
            $values= array_values($this->data);
            $updated=array();
            foreach ($this->data as $key=>$value)
                $updated[]="(".$key."=".$value.")";
            $this->executeStatement( "UPDATE ".$this->table. " SET ".implode(',',$updated). " WHERE id=".$id)->close();

        }catch(Exception $e){
            throw New Exception( $e->getMessage() );
        }


    }

    public function insert(){

        try{
            $keys= array_keys($this->data);
            $values= array_values($this->data);
            //$placeholders= array_fill(0,sizeof($values),"?");
            //var_dump("INSERT INTO"." ".$this->table." (".implode(',',$keys).") VALUES ('".implode("','",$values)."')");
            $stmt = $this->executeStatement( "INSERT INTO"." ".$this->table." (".implode(',',$keys).") VALUES ('".implode("','",$values)."')");
            $stmt->close();

            return $this->connection->insert_id;

        }catch(Exception $e){
            throw New Exception( $e->getMessage() );
        }
    }

    public function delete($id){
        try{
            $stmt = $this->executeStatement("DELETE FROM ".$this->table." WHERE id=".$id);
            $stmt->close();
        }catch(Exception $e){
            throw New Exception( $e->getMessage() );
        }
    }

    public function table($table=""){
        $this->table=$table;
        return $this;
    }

    public function found()
    {
        try{
            $this->executeStatement("SELECT count(*) from ".$this->table);
            return true;
        }catch (Exception $exception){
            return false;
        }
    }

    public function where($key,$value,$condition=" OR ",$compare="=")
    {
        $cond=($this->where==[])?"":$condition;//$this->where[]=" (1=1) ";
        $this->where[]= $cond. " (".$key." ".$compare." '".$value."')";
        return $this;
    }

    public function whereLike($key,$value,$condition=" OR ")
    {
        return $this->where($key,"%".$value."%",$condition,"LIKE");
    }

    public function whereIn($key,$value,$condition=" OR ")
    {
        return $this->where($key,"(".$value.")",$condition,"IN");
    }

    public function orderBy($orderby="created_at",$orderbytype="DESC"){
        $this->orderBy=$orderby;
        $this->orderByType=$orderbytype;
        return $this;
    }

    public function limit($limit=1,$offset=0)
    {
        $this->limit=$limit;
        $this->offset=$offset;
        return $this;
    }

    public function select($cols=[]){
        try{
            $columns=($cols==[])?"*":implode(',',$cols);
            $query="SELECT ".$columns." FROM ".$this->table;
            $query.=($this->where==[])?"":" WHERE ".implode(',',$this->where);
            $query.=($this->orderBy=="")?"":" ORDER BY ".$this->orderBy;
            $query.=($this->orderBy=="")?"":" ".$this->orderByType;
            $query.=($this->limit==null)?"":" LIMIT ".$this->limit;
            $query.=($this->offset==null)?"":",".$this->offset;

            $stmt = $this->executeStatement($query);

            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $result;

        }catch(Exception $e){
            throw New Exception( $e->getMessage() );
        }

    }



    // Insert a row/s in a Database Table
   /* public function Insert($table , $data  = [] ){

        try{
            $keys= array_keys($data);
            $values= array_values($data);
            $placeholders= array_fill(0,sizeof($values),"?");
            $stmt = $this->executeStatement( "INSERT INTO"." ".$table." (".implode(',',$keys).") VALUES (".implode(',',$placeholders).")",$values );
            $stmt->close();

            return $this->connection->insert_id;

        }catch(Exception $e){
            throw New Exception( $e->getMessage() );
        }

        return false;

    }

    // Select a row/s in a Database Table
    public function Select( $query = "" , $params = [] ){

        try{

            $stmt = $this->executeStatement( $query , $params );

            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $result;

        }catch(Exception $e){
            throw New Exception( $e->getMessage() );
        }

        return false;
    }

    public function selectALL( $table = ""){

        try{

            $stmt = $this->executeStatement( "SELECT * from ".$table);

            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $result;

        }catch(Exception $e){
            throw New Exception( $e->getMessage() );
        }

        return false;
    }

    public function selectID( $table = "",$id){

        try{

            $stmt = $this->executeStatement( "SELECT * from ".$table. " WHERE id=".$id);
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return sizeof($result)>0?$result[0]:[];

        }catch(Exception $e){
            throw New Exception( $e->getMessage() );
        }

        return false;
    }

    public function selectIN( $table = "",$field,$arr=[]){

        try{

            $stmt = $this->executeStatement( "SELECT * from ".$table. " WHERE ".$field." IN (".explode(',',$arr).")");
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $result;

        }catch(Exception $e){
            throw New Exception( $e->getMessage() );
        }

        return false;
    }

    // Update a row/s in a Database Table
    public function Update($table , $data=[], $id){
        try{
            $values= array_values($data);
            $updated=array();
            foreach ($data as $key=>$value)
                $updated[]="(".$key."=?)";
            $this->executeStatement( "UPDATE ".$table. " SET ".implode(',',$updated). " WHERE id=".$id , $values )->close();

        }catch(Exception $e){
            throw New Exception( $e->getMessage() );
        }

        return false;
    }

    // Remove a row/s in a Database Table
    public function Remove($table , $id){
        try{

            $this->executeStatement( "DELETE FROM ? WHERE id=?" , [$table,$id] )->close();

        }catch(Exception $e){
            throw New Exception( $e->getMessage() );
        }

        return false;
    }*/

    // execute statement
    private function executeStatement( $query = ""){

        try{

            $stmt = $this->connection->prepare( $query );

            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }

            /*if( $params ){
                $stmt->bind_param("",$params);
            }*/

            $stmt->execute();

            return $stmt;

        }catch(Exception $e){
            throw New Exception( $e->getMessage() );
        }

    }

}