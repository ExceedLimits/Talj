<?php


class Select extends FormComponent
{
    protected array | null $opts;
    protected string | null $selected;
    public static function make($name) {return new self($name);}
    public function render($data=[])
    {
        $this->selected=array_key_exists($this->name,$data)?$data[$this->name]:"";
        $style="";
        if ($this->colSpan!=0) $style.="grid-column:span ".$this->colSpan;
        $options="";
        foreach ($this->opts as $key=>$value){
            $options.="<option ".(($key===$this->selected)?'selected':'')." value='".$key."'>".$value."</option>";
        }
        $html='
        <label class="field" style="'.$style.'">
            <select id="'.$this->name.'" name="'.$this->name.'">
            '.$options.'
            </select>
            <span class="label">'.$this->label.'</span>
        </label>
       ';
        echo $html;
    }

    public function options($ops){
        $this->opts=$ops;
        return $this;
    }


    public function selected($key){
        $this->selected=$key;
        return $this;
    }

    public function sql():string{
        return $this->name." TEXT ". ($this->required?"":"NOT")." NULL ";
    }

}