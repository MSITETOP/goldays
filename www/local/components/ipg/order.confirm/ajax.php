<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
IncludeModuleLangFile(__FILE__);

if (!CModule::IncludeModule("ipg.expansion"))
    ShowErrAndDie('ipg.expansion module is not installed');

$arResult = array();

if (is_array($_REQUEST['list'])) {
    $oSS = new IPG\Expansion\SoapSync;

    $arList = array();
    // Получаем XML_ID если не были переданы
    foreach($_REQUEST['list'] as $arItem) {
        if (strlen($arItem['xmlid']) > 0) {
            $arList[] = $arItem;

        } else if ($arItem['id'] > 0 && CModule::IncludeModule("iblock")) {
            if ($arElement = CIBlockElement::GetByID($arItem['id'])->Fetch()) {
                $arItem['xmlid'] = $arElement['XML_ID'];
                $arList[] = $arItem;
            }
        }
    }

    if ($_REQUEST['action'] == 'status') {
        if (count($arList) > 0) {
            foreach($arList as &$arItem)
                $arItem = $arItem['xmlid'];
            $arResult = $oSS->GetProductStatus($arList);
        }

    } elseif ($_REQUEST['action'] == 'order') {
        $arCount = array();
        $arID = array();
        $arPrice = array();
        $iSum = 0;

        foreach($arList as $arItem) {
            $arPrice[] = $arItem['price'] = floatval($arItem['price']);
            $iSum += $arItem['price'];
            $arCount[] = 1;
            $arID[] = $arItem['xmlid'];
        }

        $arParam = array(
            'Price' => floatval($_REQUEST['basket']['price']),
            'Discount' => floatval($_REQUEST['basket']['discount']),
            'UserId' => $GLOBALS['USER']->GetFullName(),
            'Description' => '',
            'Product' => Array(
                'Id' => $arID,
                'Count' => $arCount,
                'Price' => $arPrice
            )
        );

        $arResult = $oSS->NewOrder($arParam);
        $bRes = true;
        foreach($arResult as $res) {
            $bRes = $bRes && $bRes;
        }
        $arResult = $bRes;

        if ($arResult && CModule::IncludeModule("sale")) {
            CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
        }
        //echo "<pre>"; print_r($arResult); echo "</pre>";
        //die();
    }
}

echo json_encode($arResult);
