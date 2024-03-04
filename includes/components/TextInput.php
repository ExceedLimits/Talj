<?php


class TextInput extends Component
{
    protected string $type="text";
    public static function make($name) {return new self($name);}
    public function render($data)
   {
       $val=array_key_exists($this->name,$data)?$data[$this->name]:"";
       if ($this->type=="password") $val="";
       $style="";
       if ($this->colSpan!=0) $style.="grid-column:span ".$this->colSpan;
       $html='
        <div class="field column '.($this->isRequired()?"required":"").'" style="'.$style.'">
            <label>'.$this->label.'</label>
            <input id="'.$this->name.'" name="'.$this->name.'" data-required="'.($this->isRequired()?1:0).'" type="'.$this->type.'"  value="'.$val.'" />
            
        </div>
       ';
       echo $html;
   }

   /*'.($this->isRequired()?"required":"").'*/
    public function sql():string{
        return $this->name." TEXT ". ($this->required?"":"NOT")." NULL ";
    }

    public function required($isRequired = true)
    {
        return parent::required($isRequired);
    }

    public function password(){
        $this->type="password";
        return $this;
    }

    public function numeric(){
        $this->type="number";
        return $this;
    }

    public function telephone(){
        $this->type="tel";
        return $this;
    }

    public function isRequired(){return parent::isRequired();}



}