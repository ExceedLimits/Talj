<?php


class Column
{
    protected string | null $name="";

    protected string | null $label="";

    protected string | null $colSpan="one";

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

    public function renderHeader() {
        echo '<th class=" '.$this->colSpan.' wide">'.$this->label.'</th>';
    }

    public function getName()
    {
        return $this->name;
    }

    protected function xss_clean($string){
        return ($string)?htmlspecialchars($string, ENT_QUOTES, 'UTF-8'):"";
    }


    public function columnSpan($span=1) {
        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $this->colSpan= $f->format($span);
        return $this;
    }







}