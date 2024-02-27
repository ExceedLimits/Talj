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

    public static function render($uri)
    {
        $sender= ($uri[2])??'';
        $operation= $uri[3]??'';
        $arg= $uri[4]??'';
        //phone/show/all
        if ($operation=="show"){

            self::renderTable(self::show($sender));
        }

        if ($arg=="new"){
            //phone/add/new
            if ($operation=="add"){
                self::renderForm($sender,$arg);
            }
            //phone/save/new
            if($operation=="save"){
                self::add($sender,$_POST);
            }
        }else{
            //phone/edit/1
            if ($operation=="edit"){
                self::renderForm($sender,$arg,self::get($sender,$arg));
            }
            //phone/save/1
            if($operation=="save"){
                self::update($sender,$_POST,$arg);
            }
        }

        //phone/delete/1
        if ($operation=="delete"){
            self::delete($sender,$arg);
        }
    }

    private static function renderForm($sender,$arg,$data=[]){
       // var_dump(APP_URL."/".);
        $op=$data==[]?"add":"update";
        echo "<form method='post' action='".APP_URL."/".$sender."/save/".$arg."'>";
        echo '<div style="margin-left:25%;padding:1rem;height:1000px;">';
        echo '<h4>Add New '.$sender::$singleLabel.'</h4>';
        echo '<section class="grid" style="--columns: '.$sender::$formColumns.';">';
        foreach ($sender::form() as $elem){
            $elem->render($data);
        }
        echo '</section>';
        echo '<button type="submit" class="button" style="margin-right: 0.5rem"> '.ucfirst($op)." ".$sender::$singleLabel.'</button>';
        echo '<button class="button -secondary" style="">Cancel</button>';
        echo "</div>";
        echo "</form>";
    }

    private static function renderTable($data=[]){
        echo '<div style="margin-left:25%;padding:1rem;height:1000px;">';
            if ($data==[]) {echo '<h4>No Rows to show..</h4></div>'; return;}
            echo '<div class="table100 ver2 m-b-110">';
                echo '<div class="table100-head">';
                    echo'<table style="margin-bottom: 0!important;">';
                        echo'<thead>';
                            echo'<tr class="row100 head">';
                                foreach (array_keys($data[0]) as $key){
                                echo '<th class="cell100">'.$key.'</th>';
                                }
                            echo'</tr>';
                        echo'</thead>';
                    echo'</table>';
                echo '</div>';
                echo '<div class="table100-body js-pscroll">';
                    echo'<table>';
                        echo'<tbody>';
                            foreach ($data as $row){
                            echo'<tr class="row100 body">';
                                foreach ($row as $val)
                                echo '<td class="cell100">'.$val.'</td>';
                            echo'</tr>';
                            }
                        echo'</tbody>';
                    echo'</table>';
                echo '</div>';
            echo '</div>';
        echo '</div>';

    }

    protected static function migrate():void{
        $sender= get_called_class();
        $fields=array();
        foreach ($sender::form() as $field) $fields[]=$field->sql();
        //die("fff");
        $last_migration= DB()->getLastMigration($sender);
        $current_migration=DB()->structure($sender,$fields);
        //structure changed
        if ($last_migration!=$current_migration)
        {
            DB()->drop($sender);
            DB()->create($sender,$fields);
            DB()->addMigration($sender,$current_migration);
        }

    }

    protected static function add($resource,$data){
        DB()->insert($resource,$data);
    }

    protected static function get($resource,$id):array{
        return DB()->get($resource,$id);
    }

    protected static function delete($resource,$id){
        DB()->delete($resource,$id);
    }

    protected static function update($resource,$data,$id){
        DB()->update($resource,$data,$id);
    }

    protected static function show($resource){
        return DB()->query("select * from ".$resource)->fetchAll();
    }









}