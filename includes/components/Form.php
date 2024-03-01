<?php
class Form
{
    protected int | null $cols=1;

    protected array | null $schema =array();

    public static function make() {return new self();}
    public function render($sender,$data=[])
    {

        $op=(count($data)==0?"Add":"Update"). " ".$sender;

        $actionURL= APP_URL."/".$sender."/save/".(count($data)==0?"new":$data['id']);

        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $cols= $f->format($this->cols);


        $html='
        <form class="ui form" style="padding:1rem" method="post" action="'. $actionURL .'">
            <h1 class="ui dividing header"> '.$op.'</h1>
            <div class="ui container">
                <section class="ui '.$cols.' column grid">';
        echo $html;
                    foreach ($this->schema as $elem){
                        $elem->render($data);
                    }
        $html=' </section>
            </div>
            <div class="ui divider"></div>
            <button type="submit" class="red ui button" style="margin-right: 0.5rem"> '.$op.'</button>
            <button class="button ui" style="">Cancel</button>
            </form>
       ';
        echo $html;
    }


    public function columns($cols=1) {
        $this->cols=$cols;
        return $this;
    }

    public function schema($fields=[]) {
        $this->schema=$fields;
        return $this;
    }

    public function getSchema() {
        return $this->schema;
    }

}