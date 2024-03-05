<?php

class Controller
{
    protected $sender="Resource";
    public function __construct($sender)
    {
        $this->sender=($sender);
    }

    protected function getWhere($term,$filters=[]){
        $wh=array();
        foreach ($filters as $f) {$wh[]="(".$f->getName()." LIKE '%".$term."%')";}
        return " WHERE " .implode(' OR ',$wh);
    }

    public function getTotalCount($term="",$filters=[]){
        return DB()->query("select count(*) as c from ".$this->sender.$this->getWhere($term,$filters))->fetchArray()['c'];
    }

    public function getPage($page,$term="",$filters=[]){
        $pagesize=$this->sender::getTablePageSize();
        $calc_page = ($page - 1) * $pagesize;
        return DB()->query("select * from ".$this->sender.$this->getWhere($term,$filters)." LIMIT ".$calc_page.",".$pagesize)->fetchAll();
    }

    public function delete($id)
    {
        DB()->delete($this->sender,$id);
    }

    public function updateIfFound($data,$arg){
        if ($arg=="new")
            DB()->insert($this->sender,$data);
        else
            DB()->update($this->sender,$data,$arg);
    }

    public function getByID($id):array{
        return DB()->get($this->sender,$id);
    }

    public function isEmpty(){
        return DB()->count($this->sender)=="0";
    }

}