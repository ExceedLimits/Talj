<?php


class Phonebook extends Resource
{
    public static string | null $singleLabel="Phonebook";

    public static string | null $pluralLabel="Phonebooks";

    public static string | null $icon= "book";

    public static int | null $order =4;



    public static function form()
    {
        return Form::make()->schema(
            [
                TextInput::make("f_name")->label("Phonebook Name")->required(),
            ]
        )->columns(1);
    }

    protected static function table()
    {
        return Table::make()->schema([
            //TextColumn::make("id")->label("ID")->columnSpan(1)->searchable(),
            TextColumn::make("f_name")->label("Phone Name")->columnSpan(16)->searchable(),
        ])->resultPerPage(1);
    }


    public static function migrate(): void
    {
        parent::migrate();
    }




}