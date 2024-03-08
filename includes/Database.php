<?php
class Database{

    private $SHOW_QUERY=false;
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

    public function update($id): void
    {
        try{
            $values= array_values($this->data);
            $updated=array();
            foreach ($this->data as $key=>$value)
                $updated[]="(".$key."='".$value."')";
            $this->executeStatement( "UPDATE ".$this->table. " SET ".implode(',',$updated). " WHERE id=".$id)->close();

        }catch(Exception $e){
            pretty($e->getMessage());
        }


    }

    public function insert():int{

        try{
            $keys= array_keys($this->data);
            $values= array_values($this->data);
            //$placeholders= array_fill(0,sizeof($values),"?");
            //die(var_dump("INSERT INTO"." ".$this->table." (".implode(',',$keys).") VALUES ('".implode("','",$values)."')"));
            $stmt = $this->executeStatement( "INSERT INTO"." ".$this->table." (".implode(',',$keys).") VALUES ('".implode("','",$values)."')");
            $stmt->close();

            return $this->connection->insert_id;

        }catch(Exception $e){
            pretty($e->getMessage());
            return 0;
        }
    }

    public function delete($id):void{
        try{
            $stmt = $this->executeStatement("DELETE FROM ".$this->table." WHERE id=".$id);
            $stmt->close();
        }catch(Exception $e){
            pretty($e->getMessage());
        }
    }

    public function table($table=""):Database{
        $this->table=$table;
        return $this;
    }

    public function found():bool
    {
        try{
            $this->executeStatement("SELECT count(*) from ".$this->table);
            return true;
        }catch (Exception $exception){
            return false;
        }
    }

    public function where($key,$value,$compare="=",$joiner=""):Database
    {
        if ($this->where==[]) $joiner="";
        $condition=" ".$joiner." (".$key." ".$compare." '".$value."')";
        if (strtoupper($compare)=="LIKE"){
            $condition= " ".$joiner." (".$key." ".$compare." '%".$value."%')";
        }
        if (strtoupper($compare)=="IN"){
            $condition= " ".$joiner." (".$key." ".$compare." (".$value."))";
        }
        $this->where[]= $condition;
        return $this;
    }

    public function andWhere($key,$value,$compare="="):Database{
        return $this->where($key,$value,$compare,"AND");
    }

    public function orWhere($key,$value,$compare="="):Database{
        return $this->where($key,$value,$compare,"OR");
    }





    public function orderBy($orderBy="created_at", $orderByType="DESC"):Database{
        $this->orderBy=$orderBy;
        $this->orderByType=$orderByType;
        return $this;
    }

    public function limit($limit=1,$offset=0):Database
    {
        $this->limit=$limit;
        $this->offset=$offset;
        return $this;
    }

    public function count($col="id"): int{
        return $this->select(["count(".$col.") as c"])[0]["c"];
    }

    public function first($cols=[]): array{
        $data=$this->select($cols);
        return $data==[]?[]:$data[0];
    }

    public function single($col): string{
        return $this->first([$col])[$col];
    }

    public function select($cols=[]): array
    {
        $columns=($cols==[])?"*":implode(',',$cols);
        $query="SELECT ".$columns." FROM ".$this->table;
        try{
            $query.=($this->where==[])?"":" WHERE ".trim(implode(' ',$this->where));
            $query.=($this->orderBy=="")?"":" ORDER BY ".$this->orderBy;
            $query.=($this->orderBy=="")?"":" ".$this->orderByType;
            $query.=($this->limit==null)?"":" LIMIT ".$this->limit;
            $query.=($this->offset==null)?"":",".$this->offset;

            $stmt = $this->executeStatement($query);
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $result;

        }catch(Exception $e){
            pretty("SQL:".$query." Error:".$e->getMessage());
            return [];
        }

    }

    // execute statement
    private function executeStatement($query = ""){

        try{

            if ($this->SHOW_QUERY) pretty($query);

            $stmt = $this->connection->prepare($query);

            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }

            /*if( $params ){
                $stmt->bind_param("",$params);
            }*/

            $stmt->execute();

            return $stmt;

        }catch(Exception $e){
            pretty("SQL:".$query." Error:".$e->getMessage());
            return "";
        }

    }

}