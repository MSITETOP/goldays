<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
$file_xml = file_get_contents('php://input');
if (file_exists($file_xml)) {
    $xml = new SimpleXMLElement($file_xml);
    $xml = json_decode(json_encode($xml),TRUE);
    foreach($xml["Товар"] as $item){
        $arXMLID[] = $item["Ид"];
        $arList[$item["Ид"]] = $item["Количество"];
    }
    if($arXMLID && CModule::IncludeModule("iblock") && CModule::IncludeModule("sale") && CModule::IncludeModule("catalog")) {     
        $res = CIBlockElement::GetList(Array(), array("=XML_ID"=>$arXMLID), false, false, array("ID","XML_ID","NAME"));
        while($arFields = $res->GetNext()){
            $r = array("QUANTITY"=>$arList[$arFields["XML_ID"]], "QUANTITY_RESERVED" => "0");
            CCatalogProduct::Update($arFields["ID"],$r);
        }
    }
    echo "success";
} else {
    exit('Не удалось открыть файл kkm.xml');
}
?>
