<?php


class Group extends Component
{
    protected array | null $schema=[];

    protected int | null $cols=1;

    public static function make($name) {return new self($name);}
    public function render($data=[])
    {
        $dataval= array_key_exists($this->name,$data)?$data[$this->name]:"";

        $innerData=[];
        foreach (explode("|",$dataval) as $one){
            if ($one=="") continue;
            $innerData[explode(':',$one)[0]."_grp_".$this->name]=explode(":",$one)[1];
        }

        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $totalcols= floor(16/($this->cols));



        $html='
        <div class="ui segments " style="padding:1rem;width: 100%">
        <div class="ui segment">
            <h2 class="ui header"> '.$this->label.'</h2>
            </div>
            <div class="ui secondary segment">
                <section class="ui grid">
                <div class="row">';
        echo $html;
        foreach ($this->schema as $elem){
            echo '<div class="'.$f->format($totalcols*$elem->getColumnSpan()).' wide column" >';
                $elem->appendName($this->getName());
                $elem->render($innerData);
            echo '</div>';
        }
        $html='</div> 
            </section>
            </div>
           
            </div>
       ';
        echo $html;
    }

    public function schema($schema){
        $this->schema=$schema;
        return $this;
    }
    public function columns($cols=1){
        $this->cols=$cols;
        return $this;
    }

    public function setLabel($lbl) {
        $this->label=$lbl;
        return $this;
    }

    public function sql():string{
        return $this->name." JSON ". ($this->required?"":"NOT")." NULL ";
    }

}