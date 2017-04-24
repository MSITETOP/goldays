<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @var string $strElementEdit */
/** @var string $strElementDelete */
/** @var array $arElementDeleteParams */
/** @var array $arSkuTemplate */
/** @var array $templateData */
global $APPLICATION;
?>
<!--======= CONTENT start =======-->
<section id="content">
<div class="slider-wrapper">
<div class="slider-highlight"></div>
<div class="left-gradient"></div>
<div class="right-gradient"></div>
<div class="slider-content">
<a href="/catalog/?set_filter=y&arrFilter_438_1416650876=Y" class="button button-yellow inline">
<span><span>
<img src="<?=SITE_TEMPLATE_PATH?>/images/icons/icon-round-black-alert.png" alt="">Акции
</span></span>
</a>
<a href="/catalog/?set_filter=y&arrFilter_436_274208589=Y" class="button button-yellow inline">
<span><span>
<img src="<?=SITE_TEMPLATE_PATH?>/images/icons/icon-round-black-pedestal.png" alt="">Хиты продаж
</span></span>
</a>
<div class="prev"></div>
<div class="next"></div>
<div class="slider">
<ul class="clearfix">
<?
foreach ($arResult['ITEMS'] as $key => $arItem)
{
	$arItem["PROPERTIES"] = $arItem["OFFERS"][0]["PROPERTIES"];
	$arItem["DISPLAY_PROPERTIES"] = $arItem["OFFERS"][0]["DISPLAY_PROPERTIES"];

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

	<li>
	<div class="block-card">
	<?
	foreach($arItem["OFFERS"] as $arOffer) {
		if($arItem['MIN_PRICE']['DISCOUNT_VALUE'] == $arOffer['MIN_PRICE']['DISCOUNT_VALUE'])		
			$offerID = $arOffer['ID'];
	} 
	?>
	<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>?offer=<?=$offerID?>">

	<div class="label hit"></div>
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
		
		if ('N' != $arParams['PRODUCT_DISPLAY_MODE'] && isset($arItem['OFFERS']) && !empty($arItem['OFFERS']))
		{?>
			<div class="new-price">от <strong><? echo $arItem['MIN_PRICE']['PRINT_VALUE']; ?></strong></div>
			<?}
	}
	
	?>
	<?if ($arItem["DISPLAY_PROPERTIES"]['SKID']){?> 
		<div class="label discount"></div>
		<?}?> 					
	<?if ($arItem["DISPLAY_PROPERTIES"]['HIT']){?> 
		<div class="label hit"></div>
		<?}?>  

	<?if ($arItem["DISPLAY_PROPERTIES"]['NOV']){?> 
		<div class="label new"></div>
		<?}?> 

	
	
	<div class="name"><? echo $arItem["PROPERTIES"]["VID"]["VALUE"];?></div>
	<div class="description"><? echo $arItem["PROPERTIES"]["VSTAVKA"]["VALUE"];?></br><? echo $arItem["PROPERTIES"]["MATERIAL"]["VALUE"];?> <? echo $arItem["PROPERTIES"]["PROBA"]["VALUE"];?></div>
	

	
	</a>		
	</div>
	</li>
	<?
}
?>
</ul>
</div>
</div>
</div>
</section><!--/.content -->
<!--====== CONTENT end =======-->