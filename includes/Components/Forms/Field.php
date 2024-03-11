<?php


class Field extends Component
{
    protected string | null $label="";

    protected bool | null $required=false;

    public static function make($name) {return new self($name);}


    public function appendName($name)
    {
        $this->name.="_grp_".$name;
        return $this;
    }

    public function label($lbl) {
        $this->label=$lbl;
        return $this;
    }

    public function getLabel() {
        return $this->label;
    }

    public function required($isRequired=true)
    {
        $this->required=$isRequired;
        return $this;
    }

    public  function isRequired(){return $this->required;}

    public function sql():string{
        return $this->name." TEXT ". ($this->required?"NOT":"")." NULL ";
    }
}