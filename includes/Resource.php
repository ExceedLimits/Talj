<?php


class Resource
{
    protected static string | null $singleLabel="Entity";

    protected static string | null $pluralLabel="Entities";

    protected static string | null $icon= "fa fa-list";

    protected static int | null $order =1;

    protected static int | null $formColumns =1;

    protected static array | null $schema =array();

    protected static function form()
    {
        return[];
    }

    protected static function render()
    {
        $sender= get_called_class();
        echo '<div style="margin-left:25%;padding:1rem;height:1000px;">';
        if (true)//add new
        {
            echo '<h4>Add New '.$sender::$singleLabel.'</h4>';
            echo '<section class="grid" style="--columns: '.$sender::$formColumns.';">';
            foreach ($sender::form() as $elem){
                $elem->render();
            }
            echo '</section>';
            echo '<button class="button" style="margin-right: 0.5rem">Add '.$sender::$singleLabel.'</button>';
            echo '<button class="button -secondary" style="">Cancel</button>';
        }
        echo "</div>";
    }









}