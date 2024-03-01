<?php
class Table
{

    protected array | null $schema =array();

    public static function make() {return new self();}
    public function render($sender,$data=[],$headers=[])
    {
        if ($data==[]) {echo "<div class='ui container'><h4>No Rows to show..</h4></div>"; return;}

        if ($headers==[]) $headers= array_keys($data[0]);

        echo '<table class="ui celled padded red table">';
            echo '<thead>';
                echo '<tr>';
                    foreach ($headers as $header){echo '<th>'; echo $header; echo '</th>';}
                echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
                echo '<tr>';
                    foreach ($data as $cell){echo '<td>'; echo $cell; echo '</td>';}
                echo '</tr>';
            echo '</tbody>';
        echo '</table>';


    }






    public function schema($fields=[]) {
        $this->schema=$fields;
        return $this;
    }

}