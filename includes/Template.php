<?php

class Template
{
    protected string $HTML="";

    protected array $vars=[];

    protected array $classes=[];

    protected array $styles=[];

    public function __construct($html)
    {
        $this->HTML=$html;
        return $this;
    }

    public static function make($html):Template {return new self($html);}



    public function with($vars){$this->vars=$vars;return $this;}

    public function classes($classes){$this->classes=$classes;return $this;}

    public function styles($styles){$this->styles=$styles;return $this;}


    public function render()
    {
        preg_match_all("/{{(.*?)}}/", $this->HTML, $matches);

        $REPLACE=array();

        foreach ($matches[0] as $match){
            $v=trim(trim(trim($match,"{}"),"{}"),"$");
            if ($match=="{{CLASSES}}") {$REPLACE[$match]=trim(implode(" ",$this->classes));continue;}
            if ($match=="{{STYLES}}") {$REPLACE[$match]=trim(implode(";",$this->styles));continue;}
            $REPLACE[$match]=($this->vars[$v]);
        }

        return str_replace(array_keys($REPLACE),array_values($REPLACE),$this->HTML);

    }

}