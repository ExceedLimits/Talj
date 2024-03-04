<?php


class Profile extends Resource
{
    public static string | null $singleLabel="Profile";

    public static string | null $pluralLabel="Profiles";

    public static string | null $icon= "list";

    public static int | null $order =2;

    private static $actions=[
        "Nothing"=>"",
        "Line"=>"line",
        "Settings"=>"keyevent F_SETTINGS",
        "Call Forwarding"=>"redirect",
        "Do Not Disturb"=>"keyevent F_DND",
        "List Missed Calls"=>"keyevent F_MISSED_LIST",
        "List Dialed Calls"=>"keyevent F_DIALED_LIST",
        "Voice Mail"=>"keyevent F_RETRIEVE",
        "Next Page"=>"keyevent F_LABEL_PAGE_NEXT",
        "Call History"=>"keyevent F_CALL_LIST",
        "Speed Dial"=>"speed",
        "Directory"=>"keyevent F_ADR_BOOK",
        "Busy Lamp Field Offline"=>"blf",
        "Private Hold"=>"keyevent F_REDIAL",
        "ReDial"=>"keyevent F_REDIAL",
        "Transfer"=>"transfer",
        "Conference"=>"conference",
        "Extension"=>"dest",
        "Park"=>"orbit",
        "Hold"=>"keyevent F_HOLD",
        "Info Message"=>"keyevent F_STATUS",
        "Missed Calls"=>"keyevent F_MISSED_LIST",
        "Accepted Calls"=>"keyevent F_ACCEPTED_LIST",
        "Dialed Calls"=>"keyevent F_DIALED_LIST",
        "Instant Redial"=>"keyevent F_INSTANT_REDIAL",
        "XML"=>"xml",
        "Server Directory"=>"keyevent F_SERVER_AB",
        "Automate Call Distribution"=>"BW-ACD",
        "Action Url"=>"url https",
        "Multicast"=>"multicast",
    ];

    private static $hard_keys=[
        "retrieve",
        "conf",
        "directory",
        "transfer",
        "redial",
        "hold"
    ];

    private static $langs=[
        "Deutsch"=>"Deutsch","English"=>"English","Español"=>"Español"
    ];

    private static $icons=[
        "Deutsch"=>"de","English"=>"en","Español"=>"es"
    ];

    public static function form()
    {
        $fields=array();
        $hk=array();
        $fields[]=TextInput::make("p_name")->label("Profile Name")->required();
        $fields[]=Select::make("language")->label("Language")->required()->options(self::$langs);
        $fields[]=Select::make("pb")->label("Phonebooks")->required()->multiple()->columnSpan(2)->relationship("Phonebook","f_name");

        foreach (self::$hard_keys as $hkey){
            $hk[]=Select::make("dkey_".$hkey)->label(ucfirst($hkey))->options(array_flip(self::$actions));
            $hk[]=TextInput::make("dkey_".$hkey."_extra")->label(ucfirst($hkey)." Extra Info.");
        }
        $fields[]=Group::make("hk")->label("Functions - Hard Keys")->schema($hk)->columns(2)->columnSpan(2);
        return Form::make()->schema($fields)->columns(2);
    }

    protected static function table()
    {
        return Table::make()->schema([
            TextColumn::make("p_name")->label("Profile Name")->columnSpan(6)->searchable(),
            SelectColumn::make("language")->label("Language")->columnSpan(8)->options(self::$langs),
            SelectColumn::make("pb")->label("Phonebooks")->columnSpan(3)->relationship("Phonebook","f_name")
        ])->resultPerPage(10);
    }

    protected static function afterSave($id,$data)
    {

        parent::afterSave($id,$data);
        if ($id!="new") $profile= DB()->get("profile",$id); else $profile=$data;
        self::createXML($profile);


    }

    protected static function createXML($profile){
        $file = 'assets/xml/template.xml';
        $xml = file_get_contents($file);
        $text = str_replace('ST_LANG',$profile['language'],$xml);

        $funcsxml="";

        $innerData=[];
        foreach (explode("|",$profile["hk"]) as $one){
            if ($one=="") continue;
            $innerData[explode(':',$one)[0]."_grp_hk"]=explode(":",$one)[1];
        }

        foreach ($innerData as $key=>$data){
            if (str_ends_with($key,"extra_grp_hk")) continue;
            $k=str_replace("_grp_hk","",$key);
            if (strpos($k,"dkey")>-1) {
                $funcsxml.="<".$k.' perm="">'.trim($data." ".$innerData[$k."_extra_grp_hk"]).'</'.$k.'>';
            }

        }

        $text = str_replace('HARD_KEYS',$funcsxml,$text);

        $tbook= explode('<tbook e="2">',$text);
        $tbookitem= trim(explode('</tbook>',$tbook[1])[0]);

        $tbooks="";
        foreach (DB()->getIn("phonebook",$profile['pb']) as $phonebook){
            foreach(DB()->getIn("contact",$phonebook['id']) as $contact)
                    $tbooks.= str_replace(["TB_NX","TB_NUMX"],[$contact['f_name'],$contact['num']],$tbookitem);
        }
        $text = str_replace($tbookitem,$tbooks,$text);

        file_put_contents($profile['p_name'].".xml", $text);
    }


    public static function migrate(): void
    {
        parent::migrate();
    }




}