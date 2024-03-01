<?php


class TextInput extends Component
{
    public static function make($name) {return new self($name);}
    public function render($data)
   {
       $val=array_key_exists($this->name,$data)?$data[$this->name]:"";
       $style="";
       if ($this->colSpan!=0) $style.="grid-column:span ".$this->colSpan;
       $html='
        <div class="field column" style="'.$style.'">
            <label>'.$this->label.'<span class="fs-base" style="color: #E2013D"> * </span></label>
            <input id="'.$this->name.'" name="'.$this->name.'" type="text" value="'.$val.'" />
            
        </div>
       ';
       echo $html;
   }

    public function sql():string{
        return $this->name." TEXT ". ($this->required?"":"NOT")." NULL ";
    }

}