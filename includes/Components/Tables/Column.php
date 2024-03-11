<?php


class Column extends Component
{
    protected string | null $name="";

    protected string | null $label="";

    protected bool | null $searchable=false;

    public function label($lbl) {
        $this->label=$lbl;
        return $this;
    }

    public function renderHeader() {
        echo '<th class=" '.$this->colSpan.' wide">'.$this->label.'</th>';
    }



    protected function xss_clean($string){
        return ($string)?htmlspecialchars($string, ENT_QUOTES, 'UTF-8'):"";
    }


    /*public function columnSpan($span=1) {
        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $this->colSpan= $f->format($span);
        return $this;
    }*/

    public function searchable($isSearchable=true)
    {
        $this->searchable=$isSearchable;
        return $this;
    }

    public  function isSearchable(){return $this->searchable;}






}