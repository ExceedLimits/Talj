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
                TextInput::make("disname")->label("Display Name")->required()->columnSpan(2),
                TextInput::make("mac")->label("MAC Address")->required(),
                TextInput::make("ip")->label("IP Address")->required(),
                TextInput::make("reg")->label("Registrar")->required(),
                TextInput::make("account")->label("Account")->required(),
                TextInput::make("acpassword")->label("Password")->required()->password(),



                Select::make("profile")->label("Profile")->relationship("Profile","p_name")->columnSpan(2)->required()
            ]
        )->columns(2);
    }

    protected static function table()
    {
        return Table::make()->schema([
            //TextColumn::make("id")->label("ID")->columnSpan(1)->searchable(),
            TextColumn::make("phname")->label("Phone Name")->columnSpan(3)->searchable(),
            TextColumn::make("ip")->label("IP Address")->columnSpan(6)->searchable(),
            TextColumn::make("mac")->label("MAC Address")->columnSpan(2)->searchable(),
            SelectColumn::make("profile")->label("Profile")->relationship("Profile","p_name")->columnSpan(5)
        ])->resultPerPage(10);
    }

    protected static function afterSave($id,$data)
    {
        parent::afterSave($id,$data);

        if ($id!="new") $phone= DB()->get("Phone",$id); else $phone=$data;
        $profile= DB()->get("Profile",$phone['profile']);

        if (!is_dir("snomD865")) {mkdir("snomD865");}

        $data= file_get_contents("".$profile["p_name"].".xml");

        $replacements=array();


        $replacements["USER_NAME"]=$phone['account'];
        $replacements["PW"]=$phone['acpassword'];
        $replacements["REGISTERAR"]=$phone['reg'];
        $replacements["PHONE_NAME"]=$phone['phname'];

        $data=str_replace(array_keys($replacements),array_values($replacements),$data);



        file_put_contents("snomD865/".$phone["mac"].".xml",$data);

    }


    public static function migrate(): void
    {
        parent::migrate();
    }




}