<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
//print_r($arResult);
$products = array();
$picture = array();

foreach($arResult["ITEMS"] as $arItem){
	$products[] = $arItem["PRODUCT_ID"];
}


if(!empty($products)){
	$arSelect = Array("ID", "NAME", "PROPERTY_CML2_LINK.DETAIL_PICTURE");
	$arFilter = Array("IBLOCK_ID"=>6, "ID"=>$products, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	while($ob = $res->Fetch())
	{
	 	if(!empty($ob["PROPERTY_CML2_LINK_DETAIL_PICTURE"])){
	 		$picture[$ob["ID"]] = CFile::GetPath($ob["PROPERTY_CML2_LINK_DETAIL_PICTURE"]);
	 	}
	}

	$arResult["PICTURE"] = $picture;
}

$arResult["END_WORD"] = declOfNum(count($arResult["ITEMS"]), array('товар', 'товара', 'товаров'));

/** 
 * Функция склонения числительных в русском языке 
 * 
 * @param int      $number  Число которое нужно просклонять 
 * @param array  $titles      Массив слов для склонения 
 * @return string
 **/
function declOfNum($number, $titles)
{
    $cases = array (2, 0, 1, 1, 1, 2);
    return $titles[ ($number%100 > 4 && $number %100 < 20) ? 2 : $cases[min($number%10, 5)] ];
}
?>