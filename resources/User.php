<?php


class User extends Resource
{
    public static string | null $singleLabel="User";

    public static string | null $pluralLabel="Users";

    public static string | null $icon= "user";

    public static int | null $order =5;



    public static function form()
    {
        return Form::make()->schema(
            [
                TextInput::make("username")->label("User Name")->required()->columnSpan(2),
                TextInput::make("password")->label("password")->password()->required(),

            ]
        )->columns(2);
    }

    protected static function table()
    {
        return Table::make()->schema([
            //TextColumn::make("id")->label("ID")->columnSpan(1)->searchable(),
            TextColumn::make("username")->label("User Name")->columnSpan(12)->searchable(),

        ])->resultPerPage(1);
    }


    public static function migrate(): void
    {

        parent::migrate();
        $sender= get_called_class();
        $controller= new Controller($sender);

        if ($controller->isEmpty()){
            $controller->updateIfFound(["username"=>"admin","password"=>password_hash("admin",PASSWORD_DEFAULT)],"new");
        }
    }




}