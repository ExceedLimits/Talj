<?php
class Form
{
    protected int | null $cols=1;

    protected array | null $schema =array();

    public static function make() {return new self();}
    public function render($sender,$data=[])
    {

        $op=(count($data)==0?"Add":"Update"). " ".$sender;

        $actionURL= Router::resource($sender)->operation("save")->arg(count($data)==0?"new":$data['id'])->url();

        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $totalcols= 16/($this->cols);


        $html='
        <form class="ui form responsive" style="padding:1rem" method="post" action="'. $actionURL .'">
            <h1 class="ui dividing header"> '.$op.'</h1><div class="ui error message"></div>
            
            <div class="">
                <section class="ui grid">
                <div class="row">';
        echo $html;
                    foreach ($this->schema as $elem){
                        echo '<div class="'.$f->format($totalcols*$elem->getColumnSpan()).' wide column" style="padding:0.5rem">';
                        if ($elem instanceof Heading)
                            $elem->render();
                        else
                            $elem->render($data);
                        echo '</div>';
                    }
        $html='</div> 
            </section>
            </div>
            <div class="ui divider"></div>
            <button type="submit" class="red ui button" style="margin-right: 0.5rem"> '.$op.'</button>
            <a href="javascript:history.go(-1)" class="button ui" style="">Cancel</a>
            
            </form>
       ';
        echo $html;

    }


    public function columns($cols=1) {

        $this->cols=($cols);
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