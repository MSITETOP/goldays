<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
global $APPLICATION;
?>

<!--======= CONTENT start =======-->
 		<section id="content" class="clearfix"> 
    <div class="main-content"> 	 
      <div class="scrollable"> 	 
        
		<div class="clearfix">
<?


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
	
	if ($_GET['sort_catalog']=='asc'){
		ksort($arResult['ITEMS'],SORT_NUMERIC);
	
	
	}else{
		krsort($arResult['ITEMS'],SORT_NUMERIC);
	}
		
		
	
}	



foreach ($arResult['ITEMS'] as $key => $arItem)
{
	$arlabel['SKID'] = $arItem["PROPERTIES"]['SKID'];
	$arlabel['HIT'] = $arItem["PROPERTIES"]['HIT'];
	$arlabel['NOV'] = $arItem["PROPERTIES"]['NOV'];
	
	if($arItem["OFFERS"][0])
		$arItem["PROPERTIES"] = $arItem["OFFERS"][0]["PROPERTIES"];
	
	$arItem["PROPERTIES"] = array_merge($arItem["PROPERTIES"], $arlabel);

	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
	$strMainID = $this->GetEditAreaId($arItem['ID']);

	$arItemIDs = array(
		'ID' => $strMainID,
		'PICT' => $strMainID.'_pict',
		'SECOND_PICT' => $strMainID.'_secondpict',
		'MAIN_PROPS' => $strMainID.'_main_props',

		'QUANTITY' => $strMainID.'_quantity',
		'QUANTITY_DOWN' => $strMainID.'_quant_down',
		'QUANTITY_UP' => $strMainID.'_quant_up',
		'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
		'BUY_LINK' => $strMainID.'_buy_link',
		'SUBSCRIBE_LINK' => $strMainID.'_subscribe',

		'PRICE' => $strMainID.'_price',
		'DSC_PERC' => $strMainID.'_dsc_perc',
		'SECOND_DSC_PERC' => $strMainID.'_second_dsc_perc',

		'PROP_DIV' => $strMainID.'_sku_tree',
		'PROP' => $strMainID.'_prop_',
		'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
		'BASKET_PROP_DIV' => $strMainID.'_basket_prop'
	);

	$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
	$strTitle = (
		isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]) && '' != isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"])
		? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]
		: $arItem['NAME']
	);
?>
			<div class="block-card">
			<?
			foreach($arItem["OFFERS"] as $arOffer) {
				if($arItem['MIN_PRICE']['DISCOUNT_VALUE'] == $arOffer['MIN_PRICE']['DISCOUNT_VALUE'])		
					$offerID = $arOffer['ID'];
			} 
			?>
				<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>?offer=<?=$offerID?>">
					

					<img src="<? echo $arItem['PREVIEW_PICTURE']['SRC']; ?>" alt="<? echo $arItem['NAME']; ?>">
					
					
<?
	if (!empty($arItem['MIN_PRICE']))
	{
	
		if ('Y' == $arParams['SHOW_OLD_PRICE'] && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE'])
		{
			?> <div class="old-price"><? echo $arItem['MIN_PRICE']['PRINT_VALUE']; ?></div><?
		}
		?>					
			<?
				if ('Y' == $arParams['SHOW_DISCOUNT_PERCENT'])
				{
				$arItem["DISPLAY_PROPERTIES"]['SKID'] = Y;
			?>
				<div class="discount" id="<? echo $arItemIDs['DSC_PERC']; ?>" ><strong><? echo $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']; ?>%</strong> скидка</div>
			<?
				}
								
					
		if ('N' == $arParams['PRODUCT_DISPLAY_MODE'] && isset($arItem['OFFERS']) && !empty($arItem['OFFERS']))
		{?>
			<div class="new-price">от <strong><? echo $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE']; ?> </strong></div>
		<?}

	}
?>	
				 <?if ($arItem["PROPERTIES"]['SKID']["VALUE"]){?> 
				   <div class="label discount"></div>
				 <?}?>      
				 <?if ($arItem["PROPERTIES"]['HIT']["VALUE"]){?> 
				  <div class="label hit"></div>
				 <?}?>  

				 <?if ($arItem["PROPERTIES"]['NOV']["VALUE"]){?> 
				  <div class="label new"></div>
				 <?}?>
					
			<div class="name"><? echo $arItem["PROPERTIES"]["VID"]["VALUE"];?></div>
			<div class="description"><? echo $arItem["PROPERTIES"]["VSTAVKA"]["VALUE"];?></br><? echo $arItem["PROPERTIES"]["MATERIAL"]["VALUE"];?> <? echo $arItem["PROPERTIES"]["PROBA"]["VALUE"];?></div>
			

	
				</a>		
			</div>

<?	
}
?>

				</div>
			</div>
			</div>
			<a id="showtips" href="javascript:void(0);" class="button button-white inline left section_button">
			    <img src="<?=SITE_TEMPLATE_PATH?>/images/icons/icon-round-black-advice.png" alt="">
			    <div class="med">Советы по выбору изделия</div>
			</a>
   		</section> 
<!--/.content -->
<!--====== CONTENT end =======-->
<!--/.container -->
<!--======= CONTAINER end =======-->

 	</div>

</div>