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
  $vx_filt=count($_GET['lui']);//нужно ли фильтровать 
  if($vx_filt!=0){$get_filter=$_GET['lui'];}
	$ml=0;
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
?>




<!--======= CONTENT start =======-->
  		<section id="content" class="clearfix"> 
<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.smart.filter",
		"smart.filter2",
		Array(
			"IBLOCK_TYPE" => 'catalog',
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"SECTION_ID" => $arCurSection['ID'],
			"FILTER_NAME" => $arParams["FILTER_NAME"],
			"PRICE_CODE" => $arParams["PRICE_CODE"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"SAVE_IN_SESSION" => "N",
			"XML_EXPORT" => "Y",
			"SECTION_TITLE" => "NAME",
			"SECTION_DESCRIPTION" => "DESCRIPTION",
			'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
			"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"]
		),
		$component,
		array('HIDE_ICONS' => 'Y')
	);?>

   
    <div class="main-content"> 	 
      <div class="scrollable"> 	 
        
		<div class="clearfix">	
<?  
foreach ($arResult['ITEMS'] as $key => $arItem)
{

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
		 // проверяем есть ли фильтр и нужно ли фильтровать
		 if($vx_filt==0){

		 
	$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
	$strTitle = (
		isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]) && '' != isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"])
		? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]
		: $arItem['NAME']
	);
 ?>
			<div class="block-card">
				<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>">
					<img src="<? echo $arItem['DETAIL_PICTURE']['SRC']; ?>" alt="<? echo $arItem['NAME']; ?>">
					
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

		<? // вывод с учетом фильтрации 
		}else{
		 //фильтруем; по массиву 
		 $control_filter=0;
		 //провеки на хит продаж на скидку и на новинку;	 
		
	if($_GET['lui']['nul'] and ($ml==0)){
	?>
	<div class='scrollable'>
	<h1 style='float:left;margin-left:115px;'>Выберите интересующие вас характеристики товара</h1>
	</div>
	
	<?
	$ml++;
	}
			
		 
		 
		$url_geg=$_SERVER['REQUEST_URI'];
		
		/*            ****************************             */
		$findme   = 'lui[436]=Y';
		$pos = strpos($url_geg, $findme);	
		if ($pos === false){$hef='нет';}else{
		foreach ($arItem['PROPERTIES']['HIT'] as $key_p => $arItem_p){
				if($arItem_p=="Да") {	
				$control_filter++;
				break;
				}

		}
		}
		/*            ****************************             */
		$findme   = 'lui[437]=Y';
		$pos = strpos($url_geg, $findme);	
		if ($pos === false){$hef='нет';}else{
		foreach ($arItem['PROPERTIES']['NOV'] as $key_p => $arItem_p){
				if($arItem_p=="Да") {	
				$control_filter++;
				break;
				}

		}
		}
		/*            ****************************             */
		$findme   = 'lui[438]=Y';
		$pos = strpos($url_geg, $findme);	
		if ($pos === false){$hef='нет';}else{
		foreach ($arItem['PROPERTIES']['SKID'] as $key_p => $arItem_p){
				if($arItem_p=="Да") {	
				$control_filter++;
				break;
				}

		}
		}
		
		
		

		foreach ($get_filter as $key_f => $arItem_f){
			foreach ($arItem['PROPERTIES'] as $key_p => $arItem_p){
				$arItem_f=urldecode($arItem_f);
				if($arItem_p['VALUE']==$arItem_f){	
				$control_filter++;
				}
			}
		}
			
	
		//прошло фильтрацию 
		if($control_filter==$vx_filt){
		
		
			
	$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
	$strTitle = (
		isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]) && '' != isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"])
		? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]
		: $arItem['NAME']
	);
 ?>
			<div class="block-card">
				<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>">
					

				<img src="<? echo $arItem['DETAIL_PICTURE']['SRC']; ?>" alt="<? echo $arItem['NAME']; ?>">
					
					
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
		<?
		
		
		
		
		}
		
		}
		?>
			
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
