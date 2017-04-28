<?
namespace IPG\Expansion;

Class StatExport
{
    public function GetBasketXML() {
        //$time1 = "01.07.2014 12:33:11"; // d.m.Y H:i:s
        //$time2 = "09.07.2014 12:33:11"; // d.m.Y H:i:s

        $query = new \Bitrix\Main\Entity\Query(BasketstatTable::getEntity());
        $query
            /*
            ->setFilter(
                array(
                    '>DATETIME' => new \Bitrix\Main\Type\DateTime($time1),
                    '<DATETIME' => new \Bitrix\Main\Type\DateTime($time2)
                )
            )
            */
            ->setSelect(array('ID', 'DATETIME', 'USER_ID', 'PRODUCT'))
            ->setOrder('ID');

        $resLog = $query->exec();
        while ($arLog = $resLog->fetch()) {
            $rsUser = \CUser::GetByID($arLog['USER_ID']);
            $arUser = $rsUser->Fetch();
            ?><cart id="<?=$arLog['ID']?>" datetime="<?=$arLog['DATETIME']->toString()?>" window="<?=$arUser['LAST_NAME'] . $arUser['NAME'] ?>">
<?
            foreach(json_decode($arLog['PRODUCT']) as $xmlid) {
                ?>  <item><?=$xmlid?></item>
<?
            }
            ?></cart>
<?
        }
    }

    public function ShowProducts() {
        \Bitrix\Main\Loader::includeModule("iblock");

        $arFilter = Array(
            "IBLOCK_ID"=>5,
            "ACTIVE"=>"Y",
            "ACTIVE_DATE"=>"Y"
        );
        $res = \CIBlockElement::GetList(Array("ID"=>"ASC"), $arFilter, Array("ID", "XML_ID", "SHOW_COUNTER"));
        while($ar_fields = $res->GetNext()) {
            echo "  <item xml-id=\"{$ar_fields["XML_ID"]}\">{$ar_fields["SHOW_COUNTER"]}</item>\n";
        }

    }
}