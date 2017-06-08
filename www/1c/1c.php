<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Текст, отправляемый в том случае,
    если пользователь нажал кнопку Cancel';
    exit;
} else {
    $arAuthResult = $USER->Login($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'], "N", "Y");

    $file_xml = file_get_contents('php://input');
    $xml = new SimpleXMLElement($file_xml);
    $xml = json_decode(json_encode($xml),TRUE);

    if($xml["Товар"]["Ид"])
	$xml["Товар"] = array($xml["Товар"]);

    file_put_contents($_SERVER["DOCUMENT_ROOT"]."/1c.log", "==============\n".print_r($xml, true)."\n==============\n", FILE_APPEND);
    foreach($xml["Товар"] as $item){
        $arXMLID[] = $item["Ид"];
        $arList[$item["Ид"]] = $item["Количество"];
    }

    if($arAuthResult==1 && $arXMLID && CModule::IncludeModule("iblock") && CModule::IncludeModule("sale") && CModule::IncludeModule("catalog")) {     
        $res = CIBlockElement::GetList(Array(), array("=XML_ID"=>$arXMLID), false, false, array("ID","XML_ID","NAME"));
        while($arFields = $res->GetNext()){
            $r = array("QUANTITY"=>$arList[$arFields["XML_ID"]], "QUANTITY_RESERVED" => "0");
            CCatalogProduct::Update($arFields["ID"],$r);
        }
	echo "success";
    } else {
        file_put_contents($_SERVER["DOCUMENT_ROOT"]."/1c.log", "==============\n".print_r($arAuthResult, true)."\n==============\n", FILE_APPEND);
	echo "fail";
    }  
}
?>
