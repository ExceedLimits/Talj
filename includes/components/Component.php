<?php


class Component
{
    protected string | null $name="";

    protected string | null $label="";

    protected bool | null $required=false;

    protected int | null $colSpan=1;

    public function __construct($name)
    {
        $this->name=$name;
        return $this;
    }



    public static function make($name) {return new self($name);}

    public function getName()
    {
        return $this->name;
    }

    public function appendName($name)
    {
        $this->name.="_grp_".$name;
        return $this;
    }

    public function __destruct()
    {

    }
    public function label($lbl) {
        $this->label=$lbl;
        return $this;
    }

    public function getLabel() {
        return $this->label;
    }

    public function columnSpan($span=1) {
        //$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $this->colSpan= ($span);
        return $this;
    }

    public function getColumnSpan() {
        //$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return ($this->colSpan);
    }

    public function required($isRequired=true)
    {
        $this->required=$isRequired;
        return $this;
    }

    public  function isRequired(){return $this->required;}

    



}