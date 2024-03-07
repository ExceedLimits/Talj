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
        return $wh;
    }

    public function getTotalCount($term="",$filters=[]){
        $q= DB()->table($this->sender);
        foreach ($filters as $f) {$q=$q->whereLike($f->getName(),$term);}
        return //DB()->table($this->sender)->wh->query("select count(*) as c from ".$this->sender.$this->getWhere($term,$filters))->fetchArray()['c'];
    }

    public function getPage($page,$term="",$filters=[]){
        $pagesize=$this->sender::getTablePageSize();
        $calc_page = ($page - 1) * $pagesize;
        return DB()->query("select * from ".$this->sender.$this->getWhere($term,$filters)." LIMIT ".$calc_page.",".$pagesize)->fetchAll();
    }

    public function delete($id)
    {
        DB()->table($this->sender)->delete($id);
    }

    public function updateIfFound($data,$arg){
        if ($arg=="new")
            DB()->table($this->sender)->data($data)->insert();
        else
            DB()->table($this->sender)->data($data)->update($arg);
    }

    public function getByID($id):array{
        return DB()->table($this->sender)->where('id',$id)->select();
    }

    public function isEmpty(){
        return DB()->table($this->sender)->select("count(*) as c")[0]["c"]=="0";
    }

}