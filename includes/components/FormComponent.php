<?php


class FormComponent
{
    protected string | null $name="";

    protected string | null $label="";

    protected bool | null $required=false;

    protected int | null $colSpan=0;

    public function __construct($name)
    {
        $this->name=$name;
        return $this;
    }



    public static function make($name) {return new self($name);}

    public function __destruct()
    {

    }
    public function label($lbl) {
        $this->label=$lbl;
        return $this;
    }

    public function columnSpan($span) {
        $this->colSpan=$span;
        return $this;
    }

    public function required($isRequired=true)
    {
        $this->required=$isRequired;
        return $this;
    }

    



}