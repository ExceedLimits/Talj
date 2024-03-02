<?php

class Controller
{
    protected $sender="Resource";
    public function __construct($sender)
    {
        $this->sender=$sender;
    }

    public function getTotalCount($term="",$filters=[]){
        $wh=" where (1=1)";
        foreach ($filters as $f) {$wh.=" OR (".$f." LIKE '%".$term."%') ";}
        return DB()->query("select count(*) as c from ".$this->sender.$wh)->fetchArray()['c'];
    }

    public function getPage($page,$term="",$filters=[]){
        $pagesize=$this->sender::getTablePageSize();
        $calc_page = ($page - 1) * $pagesize;
        $wh=" where (1=1)";
        foreach ($filters as $f) {$wh.=" OR (".$f->getName()." LIKE '%".$term."%') ";}
        return DB()->query("select * from ".$this->sender.$wh." LIMIT ".$calc_page.",".$pagesize)->fetchAll();
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

    public function getByID($sender,$id):array{
        return DB()->get($sender,$id);
    }

}