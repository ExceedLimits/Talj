<?php


class TextInput extends FormComponent
{
    public static function make($name) {return new self($name);}
    public function render()
   {
       $style="";
       if ($this->colSpan!=0) $style.="grid-column:span ".$this->colSpan;
       $html='
        <label class="field" style="'.$style.'">
            <input type="text" />
            <span class="label">'.$this->label.'<span class="fs-base" style="color: #E2013D"> * </span></span>
        </label>
       ';
       echo $html;
   }

}