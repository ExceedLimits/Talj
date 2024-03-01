<?php

class Controller
{
    protected $sender="Resource";
    public function __construct($sender)
    {
        $this->sender=$sender;
    }

    public function getTotalCount(){
        return DB()->query("select count(*) as c from ".$this->sender)->fetchArray()['c'];
    }

    public function getPage($page){
        $pagesize=$this->sender::getTablePageSize();
        $calc_page = ($page - 1) * $pagesize;
        return DB()->query("select * from ".$this->sender." LIMIT ".$calc_page.",".$pagesize)->fetchAll();
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