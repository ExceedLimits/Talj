<?php


class TextInput extends FormComponent
{
    public static function make($name) {return new self($name);}
    public function render($data)
   {
       $val=array_key_exists($this->name,$data)?$data[$this->name]:"";
       $style="";
       if ($this->colSpan!=0) $style.="grid-column:span ".$this->colSpan;
       $html='
        <label class="field" style="'.$style.'">
            <input id="'.$this->name.'" name="'.$this->name.'" type="text" value="'.$val.'" />
            <span class="label">'.$this->label.'<span class="fs-base" style="color: #E2013D"> * </span></span>
        </label>
       ';
       echo $html;
   }

    public function sql():string{
        return $this->name." TEXT ". ($this->required?"":"NOT")." NULL ";
    }

}