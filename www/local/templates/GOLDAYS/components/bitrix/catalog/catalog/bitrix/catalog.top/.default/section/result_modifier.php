<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

print_r($arResult);
if($_GET['pole_sort']=='CAT_BASE_PRICE'){
	foreach ($arResult['ITEMS'] as $key => $arItem)
	{
		$nov_key=$arItem['MIN_PRICE']['DISCOUNT_VALUE'];
		if($nov_key==''){
			$nov_key=$arItem['VALUE'];
		}
		$nov_key=round($nov_key);
		$arResult_2['ITEMS'][$nov_key]=$arItem;
	}	

	$arResult['ITEMS']=$arResult_2['ITEMS']; 
	
	if ($_GET['sort_catalog']=='desc'){
		ksort($arResult['ITEMS'],SORT_NUMERIC);
		
		
	}
}	

?>