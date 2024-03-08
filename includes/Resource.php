<?php


class Resource
{
    protected static string | null $singleLabel="Entity";

    protected static string | null $pluralLabel="Entities";

    protected static string | null $icon= "list";

    protected static int | null $order =1;

    protected static bool | null $dashboarded=true;

    public static string $migrations="migrations";



    public static function getIcon(){return get_called_class()::$icon;}
    public static function getSingleLabel(){return get_called_class()::$singleLabel;}
    public static function getPluralLabel(){return get_called_class()::$pluralLabel;}
    public static function getOrder(){return get_called_class()::$order;}

    public static function getDashboarded(){return get_called_class()::$dashboarded;}

    protected static function form()
    {
        return Form::make();
    }

    protected static function table()
    {
        return Table::make();
    }

    public static function canList():bool
    {
        return true;
    }

    public static function canAdd():bool
    {
        return true;
    }

    public static function canEdit():bool
    {
        return true;
    }

    public static function canDelete():bool
    {
        return true;
    }



    public static function render(Router $router)
    {
            $sender = ucfirst($router->getResource());
            $operation = $router->getOperation();
            $arg = $router->getArg();
            $term = $router->getparams()["term"] ?? "";


            if (!in_array($sender,getAllClasses(RESOURCES)))
            {
                include "layout/404.php";
                return;
            }


            //phone/show/all
            if ($operation == "show") {
                $sender::table()->render($sender, $arg, $term);
                return;
            }

            //phone/delete/1
            if ($operation == "delete") {
                //$controller->delete($arg);
                DB()->table($sender)->delete($arg);
                $router->operation()->arg()->goto();
            }

            if ($operation == "save") {

                foreach ($_POST as $key => $p) {
                    if (is_array($_POST[$key])) {
                        $_POST[$key] = implode(",", array_values($_POST[$key]));
                    }

                    if (strpos($key, "_grp_") > -1) {
                        $namebits = explode("_grp_", $key);
                        if (!array_key_exists($namebits[1], $_POST)) {
                            $_POST[$namebits[1]] = "";
                        }
                        $_POST[$namebits[1]] .= $namebits[0] . ":" . $p . "|";
                        unset($_POST[$key]);
                    }
                }


                if (isset($_POST['password'])) {
                    $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                }

                if ($arg == "new")
                    DB()->table($sender)->data($_POST)->insert();
                else
                    DB()->table($sender)->data($_POST)->update($arg);

                $sender::afterSave($id = $arg, $data = $_POST);
                $router->operation()->arg()->goto();
            }

            if ($operation=="add"){
                $sender::form()->render($sender, "new");
                return;
            }

            if ($operation=="edit"){
                $sender::form()->render($sender, $arg);
                return;
            }

            include "layout/404.php";
    }

    public static function getTablePageSize(){
        $sender= get_called_class();
        return  $sender::table()->getPageSize();
    }


    protected static function afterSave($id,$data){}

    protected static function afterCreation(){}

    public static function migrate():void{
        if (DB()->table(Resource::$migrations)->found()){DB()->Create(Resource::$migrations,["tbl TEXT NOT NULL","query TEXT NOT NULL"]);}

        foreach (getAllClasses(RESOURCES) as $sender) {
            $fields=array();
            foreach ($sender::form()->getSchema() as $field) if ($field->sql()!="") $fields[]=$field->sql();

            $last_migration= DB()->table(self::$migrations)->where("tbl",$sender)->orderBy()->single('query');
            $current_migration=DB()->structure($sender,$fields);
            //pretty($last_migration['query']==$current_migration);
            //structure changed
            if ($last_migration!=$current_migration)
            {
                pretty("migration done");
                DB()->Drop($sender);
                DB()->Create($sender,$fields);
                DB()->table(self::$migrations)->data(['tbl'=>$sender,'query'=>$current_migration])->insert();
                $sender::afterCreation();
            }
        }
    }



















}