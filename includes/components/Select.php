<?php


class Select extends FormComponent
{
    protected array | null $opts;
    protected string | null $selected;
    public static function make($name) {return new self($name);}
    public function render()
    {
        $style="";
        if ($this->colSpan!=0) $style.="grid-column:span ".$this->colSpan;
        $options="";
        foreach ($this->opts as $key=>$value){
            $options.="<option ".(($key===$this->selected)?'selected':'')." value='".$key."'>".$value."</option>";
        }
        $html='
        <label class="field" style="'.$style.'">
            <select>
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

}