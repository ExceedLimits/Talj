<?php


class Phone extends Resource
{
    public static string | null $singleLabel="Phone";

    public static string | null $pluralLabel="Phones";

    public static string | null $icon= "phone";

    public static int | null $order =1;



    public static function form()
    {
        return Form::make()->schema(
            [
                TextInput::make("phname")->label("Phone Name")->required()->columnSpan(2),
                TextInput::make("mac")->label("MAC Address")->required(),
                TextInput::make("ip")->label("IP Address")->required(),
                TextInput::make("ppp")->label("ppp")->required(),
                Select::make("op")->multiple()->label("IP Options")->options(["0"=>"on","y"=>"off"])->required(),
                Select::make("users")->label("Users")->relationship("User","username")->required()
            ]
        )->columns(3);
    }

    protected static function table()
    {
        return Table::make()->schema([
            //TextColumn::make("id")->label("ID")->columnSpan(1)->searchable(),
            TextColumn::make("phname")->label("Phone Name")->columnSpan(8)->searchable(),
            TextColumn::make("ip")->label("IP Address")->columnSpan(6)->searchable(),
            TextColumn::make("mac")->label("MAC Address")->columnSpan(2)->searchable(),
        ])->resultPerPage(1);
    }


    public static function migrate(): void
    {
        parent::migrate();
    }




}