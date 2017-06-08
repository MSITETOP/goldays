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
$templateLibrary = array('popup');
$currencyList = '';
if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}
$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList
);
unset($currencyList, $templateLibrary);

$strMainID = $this->GetEditAreaId($arResult['ID']);
$arItemIDs = array(
	'ID' => $strMainID,
	'PICT' => $strMainID.'_pict',
	'DISCOUNT_PICT_ID' => $strMainID.'_dsc_pict',
	'STICKER_ID' => $strMainID.'_sticker',
	'BIG_SLIDER_ID' => $strMainID.'_big_slider',
	'BIG_IMG_CONT_ID' => $strMainID.'_bigimg_cont',
	'SLIDER_CONT_ID' => $strMainID.'_slider_cont',
	'SLIDER_LIST' => $strMainID.'_slider_list',
	'SLIDER_LEFT' => $strMainID.'_slider_left',
	'SLIDER_RIGHT' => $strMainID.'_slider_right',
	'OLD_PRICE' => $strMainID.'_old_price',
	'PRICE' => $strMainID.'_price',
	'DISCOUNT_PRICE' => $strMainID.'_price_discount',
	'SLIDER_CONT_OF_ID' => $strMainID.'_slider_cont_',
	'SLIDER_LIST_OF_ID' => $strMainID.'_slider_list_',
	'SLIDER_LEFT_OF_ID' => $strMainID.'_slider_left_',
	'SLIDER_RIGHT_OF_ID' => $strMainID.'_slider_right_',
	'QUANTITY' => $strMainID.'_quantity',
	'QUANTITY_DOWN' => $strMainID.'_quant_down',
	'QUANTITY_UP' => $strMainID.'_quant_up',
	'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
	'QUANTITY_LIMIT' => $strMainID.'_quant_limit',
	'BASIS_PRICE' => $strMainID.'_basis_price',
	'BUY_LINK' => $strMainID.'_buy_link',
	'ADD_BASKET_LINK' => $strMainID.'_add_basket_link',
	'BASKET_ACTIONS' => $strMainID.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
	'COMPARE_LINK' => $strMainID.'_compare_link',
	'PROP' => $strMainID.'_prop_',
	'PROP_DIV' => $strMainID.'_skudiv',
	'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
	'OFFER_GROUP' => $strMainID.'_set_group_',
	'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
);
$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
$templateData['JS_OBJ'] = $strObName;

$strTitle = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"] != ''
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	: $arResult['NAME']
);
$strAlt = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"] != ''
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	: $arResult['NAME']
);
?>
	<?if ( $arResult["DISPLAY_PROPERTIES"]["SOPUTSTVUYUSHCHIETOVARY"]["VALUE"] == 0 ){?>
	<div id="container" class="product">
	<?} else {?>
	<div id="container" class="product2">
	<?}?>
	<div class="left-gradient"></div>
	<div class="right-gradient"></div>
	<!--======= HEADER start =======-->
	<header class="header">
		<a href="javascript:history.back()" onMouseOver="window.status='Назад';return true" class="button button-white inline"><img src="<?=SITE_TEMPLATE_PATH?>/images/icons/icon-round-black-left.png" alt="">Назад</a>
		<div id="small_basket">
			<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "smal_basket2", Array(
				"PATH_TO_BASKET" => "/basket/index.php",	// Страница корзины
				"PATH_TO_ORDER" => "/personal/order.php",	// Страница оформления заказа
				"SHOW_DELAY" => "N",	// Показывать отложенные товары
				"SHOW_NOTAVAIL" => "N",	// Показывать товары, недоступные для покупки
				"SHOW_SUBSCRIBE" => "N",	// Показывать товары, на которые подписан покупатель
				),
				false
			);?>
		</div>
		<div class="slogan1">Информация о товаре</div>
		<a href="/basket/clear.php?action=clear" class="button button-white inline new_bt white_bt new_bt">Новый сеанс</a>
	</header>
	
	<section id="content" class="clearfix">
		<div class="message_delay"></div>
		<div class="bx_item_detail <? echo $templateData['TEMPLATE_CLASS']; ?>" id="<? echo $arItemIDs['ID']; ?>">
		<?
		reset($arResult['MORE_PHOTO']);
		$arFirstPhoto = current($arResult['MORE_PHOTO']);
		?>
			<div class="bx_item_container">
				<div class="bx_lt">
					<div class="gradient-left"></div>
					<div class="gradient-right"></div>
		<div class="bx_item_slider" id="<? echo $arItemIDs['BIG_SLIDER_ID']; ?>">
			<?if(count($arResult['MORE_PHOTO'])>1){?>
			<div id="sliderkit-go-next" class="sliderkit-go-next"></div>
			<div id="sliderkit-go-prev" class="sliderkit-go-prev"></div>
			<?}?>
			<div class="bx_bigimages" id="<? echo $arItemIDs['BIG_IMG_CONT_ID']; ?>">
			<div class="bx_bigimages_imgcontainer">
			<span class="bx_bigimages_aligner"><img id="<? echo $arItemIDs['PICT']; ?>" src="<? echo $arFirstPhoto['SRC']; ?>" alt="<? echo $strAlt; ?>" title="<? echo $strTitle; ?>"></span>
		<?
		if ($arResult['LABEL'])
		{
		?>
			<div class="bx_stick average left top" id="<? echo $arItemIDs['STICKER_ID'] ?>" title="<? echo $arResult['LABEL_VALUE']; ?>"><? echo $arResult['LABEL_VALUE']; ?></div>
		<?
		}
		?>
			</div>
			</div>
		<?
		if ($arResult['SHOW_SLIDER'])
		{
			if (!isset($arResult['OFFERS']) || empty($arResult['OFFERS']))
			{
				if (5 < $arResult['MORE_PHOTO_COUNT'])
				{
					$strClass = 'bx_slider_conteiner full';
					$strOneWidth = (100/$arResult['MORE_PHOTO_COUNT']).'%';
					$strWidth = (20*$arResult['MORE_PHOTO_COUNT']).'%';
					$strSlideStyle = '';
				}
				else
				{
					$strClass = 'bx_slider_conteiner';
					$strOneWidth = '20%';
					$strWidth = '100%';
					$strSlideStyle = 'display: none;';
				}
		?>
			<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_ID']; ?>">
			<div class="bx_slider_scroller_container">
			<div class="bx_slide">
			<ul class="imgSliderIPG" style="width: <? echo $strWidth; ?>;" id="<? echo $arItemIDs['SLIDER_LIST']; ?>">
		<?
				foreach ($arResult['MORE_PHOTO'] as &$arOnePhoto)
				{
		?>
			<li data-value="<? echo $arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"><span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $arOnePhoto['SRC']; ?>');"></span></span></li>
		<?
				}
				unset($arOnePhoto);
		?>
			</ul>
			</div>
			<div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
			<div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
			</div>
			</div>
		<?
			}
			else
			{
				foreach ($arResult['OFFERS'] as $key => $arOneOffer)
				{
					if (!isset($arOneOffer['MORE_PHOTO_COUNT']) || 0 >= $arOneOffer['MORE_PHOTO_COUNT'])
						continue;
					$strVisible = ($key == $arResult['OFFERS_SELECTED'] ? '' : 'none');
					if (5 < $arOneOffer['MORE_PHOTO_COUNT'])
					{
						$strClass = 'bx_slider_conteiner full';
						$strOneWidth = (100/$arOneOffer['MORE_PHOTO_COUNT']).'%';
						$strWidth = (20*$arOneOffer['MORE_PHOTO_COUNT']).'%';
						$strSlideStyle = '';
					}
					else
					{
						$strClass = 'bx_slider_conteiner';
						$strOneWidth = '20%';
						$strWidth = '100%';
						$strSlideStyle = 'display: none;';
					}
		?>
			<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_OF_ID'].$arOneOffer['ID']; ?>" style="display: <? echo $strVisible; ?>;">
			<div class="bx_slider_scroller_container">
			<div class="bx_slide">
			<ul class="imgSliderIPG" style="width: <? echo $strWidth; ?>;" id="<? echo $arItemIDs['SLIDER_LIST_OF_ID'].$arOneOffer['ID']; ?>">
		<?
					foreach ($arOneOffer['MORE_PHOTO'] as &$arOnePhoto)
					{
		?>
			<li data-value="<? echo $arOneOffer['ID'].'_'.$arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>"><span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $arOnePhoto['SRC']; ?>');"></span></span></li>
		<?
					}
					unset($arOnePhoto);
		?>
			</ul>
			</div>
			<div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT_OF_ID'].$arOneOffer['ID'] ?>" style="<? echo $strSlideStyle; ?>" data-value="<? echo $arOneOffer['ID']; ?>"></div>
			<div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT_OF_ID'].$arOneOffer['ID'] ?>" style="<? echo $strSlideStyle; ?>" data-value="<? echo $arOneOffer['ID']; ?>"></div>
			</div>
			</div>
		<?
				}
			}
		}
		?>
		</div>
				</div>
				<div class="bx_rt">
					<div class="card-item-line">
					<table><tbody><tr>
						<td>
							<div class="item-name"><?=$arResult["NAME"]?></div>
						</td>
						<td>
							<div class="item_price">
								<?
								$minPrice = (isset($arResult['RATIO_PRICE']) ? $arResult['RATIO_PRICE'] : $arResult['MIN_PRICE']);
								$boolDiscountShow = (0 < $minPrice['DISCOUNT_DIFF']);
								?>
								<div class="item-old-price item_old_price" id="<? echo $arItemIDs['OLD_PRICE']; ?>" style="display: <? echo($boolDiscountShow ? '' : 'none'); ?>"><? echo($boolDiscountShow ? $minPrice['PRINT_VALUE'] : ''); ?></div>
								<div class="item-discount "><strong id="<?=$arItemIDs["DISCOUNT_PRICE"]?>"><?=$arResult["DISCOUNT_DIFF_PERCENT"]?>%</strong> скидка</div>
								<div class="item_current_price" id="<? echo $arItemIDs['PRICE']; ?>"><? echo $minPrice['PRINT_DISCOUNT_VALUE']; ?></div>
								<div class="item-for-weight"></div>
							</div>
						</td>
					</tr></tbody></table>
					</div>


		<?
		unset($minPrice);

		if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']) && !empty($arResult['OFFERS_PROP']))
		{
			$arSkuProps = array();
		?>
		<div class="item_info_section card-item-line" id="<? echo $arItemIDs['PROP_DIV']; ?>">
		<?
			foreach ($arResult['SKU_PROPS'] as &$arProp)
			{
				if (!isset($arResult['OFFERS_PROP'][$arProp['CODE']]))
					continue;
					
				if($arProp['CODE'] == "VES")
					$arProp['SHOW_MODE'] = "HIDDEN";	
					
				$arSkuProps[] = array(
					'ID' => $arProp['ID'],
					'SHOW_MODE' => $arProp['SHOW_MODE'],
					'VALUES_COUNT' => $arProp['VALUES_COUNT']
				);
				
				if ('TEXT' == $arProp['SHOW_MODE'])
				{
					if (5 < $arProp['VALUES_COUNT'])
					{
						$strClass = 'bx_item_detail_size full';
						$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
						$strWidth = (20*$arProp['VALUES_COUNT']).'%';
						$strSlideStyle = '';
					}
					else
					{
						$strClass = 'bx_item_detail_size';
						$strOneWidth = '20%';
						$strWidth = '100%';
						$strSlideStyle = 'display: none;';
					}
		?>
			<div class="ipg_prop_item">
				<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?>:</span>
				<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_cont">
					<div class="bx_size_scroller_container"><div class="bx_size">
						<ul id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;margin-left:0%;">
			<?
						foreach ($arProp['VALUES'] as $arOneValue)
						{
							$arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
			?>
			<li data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID']; ?>" data-onevalue="<? echo $arOneValue['ID']; ?>" style="width: <? echo $strOneWidth; ?>; display: none;">
			<i title="<? echo $arOneValue['NAME']; ?>"></i><span class="cnt" title="<? echo $arOneValue['NAME']; ?>"><? echo $arOneValue['NAME']; ?></span></li>
			<?
						}
			?>
						</ul>
						</div>
						<div class="bx_slide_left" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>"></div>
						<div class="bx_slide_right" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>"></div>
					</div>
				</div>
			</div>
		<?
				}
				elseif ('PICT' == $arProp['SHOW_MODE'])
				{
					if (5 < $arProp['VALUES_COUNT'])
					{
						$strClass = 'bx_item_detail_scu full';
						$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
						$strWidth = (20*$arProp['VALUES_COUNT']).'%';
						$strSlideStyle = '';
					}
					else
					{
						$strClass = 'bx_item_detail_scu';
						$strOneWidth = '20%';
						$strWidth = '100%';
						$strSlideStyle = 'display: none;';
					}
		?>
			<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_cont">
				<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>
				<div class="bx_scu_scroller_container"><div class="bx_scu">
					<ul id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;margin-left:0%;">
		<?
					foreach ($arProp['VALUES'] as $arOneValue)
					{
						$arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
		?>
		<li data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID'] ?>" data-onevalue="<? echo $arOneValue['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>; display: none;" >
		<i title="<? echo $arOneValue['NAME']; ?>"></i>
		<span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $arOneValue['PICT']['SRC']; ?>');" title="<? echo $arOneValue['NAME']; ?>"></span></span></li>
		<?
					}
		?>
					</ul>
					</div>
					<div class="bx_slide_left" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>"></div>
					<div class="bx_slide_right" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>"></div>
				</div>
			</div>
		<?
				} 
				elseif ('HIDDEN' == $arProp['SHOW_MODE'])
				{
					if (5 < $arProp['VALUES_COUNT'])
					{
						$strClass = 'bx_item_detail_size full';
						$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
						$strWidth = (20*$arProp['VALUES_COUNT']).'%';
						$strSlideStyle = '';
					}
					else
					{
						$strClass = 'bx_item_detail_size';
						$strOneWidth = '20%';
						$strWidth = '100%';
						$strSlideStyle = 'display: none;';
					}
		?>
			<div class="ipg_prop_item" style="display: none;">
				<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?>:</span>
				<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_cont">
					<div class="bx_size_scroller_container"><div class="bx_size">
						<ul id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;margin-left:0%;">
			<?
						foreach ($arProp['VALUES'] as $arOneValue)
						{
							$arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
			?>
			<li data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID']; ?>" data-onevalue="<? echo $arOneValue['ID']; ?>" style="width: <? echo $strOneWidth; ?>; display: none;">
			<i title="<? echo $arOneValue['NAME']; ?>"></i><span class="cnt" title="<? echo $arOneValue['NAME']; ?>"><? echo $arOneValue['NAME']; ?></span></li>
			<?
						}
			?>
						</ul>
						</div>
						<div class="bx_slide_left" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>"></div>
						<div class="bx_slide_right" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>"></div>
					</div>
				</div>
			</div>
		<?					
				}
			}
			unset($arProp);
		?>
		
		<div class="ipg_prop_show"></div>
		</div>
		<?
		}
		?>
		<div class="item_info_section card-item-line">
		<?
		if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
		{
			$canBuy = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['CAN_BUY'];
		}
		else
		{
			$canBuy = $arResult['CAN_BUY'];
		}
		$buyBtnMessage = ($arParams['MESS_BTN_BUY'] != '' ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCE_CATALOG_BUY'));
		$addToBasketBtnMessage = ($arParams['MESS_BTN_ADD_TO_BASKET'] != '' ? $arParams['MESS_BTN_ADD_TO_BASKET'] : GetMessage('CT_BCE_CATALOG_ADD'));
		$notAvailableMessage = ($arParams['MESS_NOT_AVAILABLE'] != '' ? $arParams['MESS_NOT_AVAILABLE'] : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE'));
		$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
		$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);

		$showSubscribeBtn = false;
		$compareBtnMessage = ($arParams['MESS_BTN_COMPARE'] != '' ? $arParams['MESS_BTN_COMPARE'] : GetMessage('CT_BCE_CATALOG_COMPARE'));

		if ($arParams['USE_PRODUCT_QUANTITY'] == 'Y')
		{
			if ($arParams['SHOW_BASIS_PRICE'] == 'Y')
			{
				$basisPriceInfo = array(
					'#PRICE#' => $arResult['MIN_BASIS_PRICE']['PRINT_DISCOUNT_VALUE'],
					'#MEASURE#' => (isset($arResult['CATALOG_MEASURE_NAME']) ? $arResult['CATALOG_MEASURE_NAME'] : '')
				);
		?>
				<p id="<? echo $arItemIDs['BASIS_PRICE']; ?>" class="item_section_name_gray"><? echo GetMessage('CT_BCE_CATALOG_MESS_BASIS_PRICE', $basisPriceInfo); ?></p>
		<?
			}
		?>
			<span class="item_section_name_gray"><? echo GetMessage('CATALOG_QUANTITY'); ?></span>
			<div class="item_buttons vam">
				<span class="item_buttons_counter_block">
					<a href="javascript:void(0)" class="bx_bt_button_type_2 bx_small bx_fwb" id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>">-</a>
					<input id="<? echo $arItemIDs['QUANTITY']; ?>" type="text" class="tac transparent_input" value="<? echo (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])
							? 1
							: $arResult['CATALOG_MEASURE_RATIO']
						); ?>">
					<a href="javascript:void(0)" class="bx_bt_button_type_2 bx_small bx_fwb" id="<? echo $arItemIDs['QUANTITY_UP']; ?>">+</a>
					<span class="bx_cnt_desc" id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"><? echo (isset($arResult['CATALOG_MEASURE_NAME']) ? $arResult['CATALOG_MEASURE_NAME'] : ''); ?></span>
				</span>
				<span class="item_buttons_counter_block" id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" style="display: <? echo ($canBuy ? '' : 'none'); ?>;">
					<a href="javascript:void(0);" class="bx_big bx_bt_button bx_cart" id="<? echo $arItemIDs['BUY_LINK']; ?>"><span></span><? echo $buyBtnMessage; ?></a>
					<a href="javascript:void(0);" class="bx_big bx_bt_button bx_cart" id="<? echo $arItemIDs['ADD_BASKET_LINK']; ?>"><span></span><? echo $addToBasketBtnMessage; ?></a>

				</span>
				<span id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_notavailable" style="display: <? echo (!$canBuy ? '' : 'none'); ?>;"><? echo $notAvailableMessage; ?></span>
		<?
			if ($arParams['DISPLAY_COMPARE'] || $showSubscribeBtn)
			{
		?>
				<span class="item_buttons_counter_block">
		<?
				if ($arParams['DISPLAY_COMPARE'])
				{
		?>
					<a href="javascript:void(0);" class="bx_big bx_bt_button_type_2 bx_cart" id="<? echo $arItemIDs['COMPARE_LINK']; ?>"><? echo $compareBtnMessage; ?></a>
		<?
				}
				if ($showSubscribeBtn)
				{

				}
		?>
				</span>
		<?
			}
		?>
			</div>
		<?
			if ('Y' == $arParams['SHOW_MAX_QUANTITY'])
			{
				if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
				{
		?>
			<p id="<? echo $arItemIDs['QUANTITY_LIMIT']; ?>" style="display: none;"><? echo GetMessage('OSTATOK'); ?>: <span></span></p>
		<?
				}
				else
				{
					if ('Y' == $arResult['CATALOG_QUANTITY_TRACE'] && 'N' == $arResult['CATALOG_CAN_BUY_ZERO'])
					{
		?>
			<p id="<? echo $arItemIDs['QUANTITY_LIMIT']; ?>"><? echo GetMessage('OSTATOK'); ?>: <span><? echo $arResult['CATALOG_QUANTITY']; ?></span></p>
		<?
					}
				}
			}
		}
		else
		{
		?>
			<div class="item_buttons vam">
				<span class="item_buttons_counter_block" id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" style="display: <? echo ($canBuy ? '' : 'none'); ?>;">
					<a href="javascript:void(0);"  onclick="ipg_add_cart($(this));" class="button button-black inline bx_big bx_bt_button bx_cart not_basket"><img src="<?=$templateFolder?>/images/icon-round-white-in-cart.png" alt=""><div class="big">Отложить изделие</div><div class="small">для примерки</div></a>
					<a href="javascript:void(0);" style="display: none;" class="button button-black inline bx_big bx_bt_button bx_cart in_basket"><img src="<?=$templateFolder?>/images/icon-round-white-in-cart.png" alt="">Изделие в корзине</a>
					<a href="javascript:void(0);" onclick="ipg_now_order();" id="ipg_now_order" class="button button-black inline button button-black inline"><img src="<?=$templateFolder?>/images/icon-round-white-try.png" alt="">Примерить сразу</a>
				</span>
				<span id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_notavailable" style="display: <? echo (!$canBuy ? '' : 'none'); ?>;"><? echo $notAvailableMessage; ?></span>
		<?
			if ($arParams['DISPLAY_COMPARE'] || $showSubscribeBtn)
			{
				?>
				<span class="item_buttons_counter_block">
			<?
			if ($arParams['DISPLAY_COMPARE'])
			{
				?>
				<a href="javascript:void(0);" class="bx_big bx_bt_button_type_2 bx_cart" id="<? echo $arItemIDs['COMPARE_LINK']; ?>"><? echo $compareBtnMessage; ?></a>
			<?
			}
			if ($showSubscribeBtn)
			{

			}
		?>
				</span>
		<?
			}
		?>
			</div>
		<?
		}
		unset($showAddBtn, $showBuyBtn);
		?>
		</div>
					<div class="clb"></div>
				</div>

				
<?if ( $arResult["DISPLAY_PROPERTIES"]["SOPUTSTVUYUSHCHIETOVARY"]["VALUE"] != 0 )
    {?>
	<div class="card-complement-wrapper">
	<div class="card-complement">
	<div class="complement-title">
	<div><img src="<?=SITE_TEMPLATE_PATH?>/images/icons/icon-round-black-alert.png" alt="">Подходят вместе:</div>
	</div>

	<?
	global $arrFilter; 
	
	foreach($arResult["DISPLAY_PROPERTIES"]["SOPUTSTVUYUSHCHIETOVARY"]["VALUE"] as $xml_id)
		$arXML[] = str_replace("#00000000-0000-0000-0000-000000000000", "", $xml_id);
	$arrFilter = Array(
		"XML_ID" => $arXML
	);?> 
	 <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.link.list",
	"dop_tovar",
	Array(
	"AJAX_MODE" => "N",
	"IBLOCK_TYPE" => "catalog",
	"IBLOCK_ID" => "5",
	"LINK_PROPERTY_SID" => "",
	"ELEMENT_ID" => $_REQUEST["PARENT_ELEMENT_ID"],
	"ELEMENT_SORT_FIELD" => "sort",
	"ELEMENT_SORT_ORDER" => "asc",
	"ELEMENT_SORT_FIELD2" => "id",
	"ELEMENT_SORT_ORDER2" => "desc",
	"FILTER_NAME" => "arrFilter",
	"SECTION_URL" => "",
	"DETAIL_URL" => "/catalog/#SECTION_ID#/#ELEMENT_ID#/",
	"BASKET_URL" => "/basket/index.php",
	"ACTION_VARIABLE" => "action",
	"PRODUCT_ID_VARIABLE" => "id",
	"SECTION_ID_VARIABLE" => "SECTION_ID",
	"SET_TITLE" => "Y",
	"PAGE_ELEMENT_COUNT" => "30",
	"PROPERTY_CODE" => array(0=>"VID",1=>"VSTAVKA",2=>"MATERIAL",3=>"NOV",4=>"PROBA",5=>"SKID",6=>"HIT",),
	"PRICE_CODE" => array(0=>"Типовые правила продаж",),
	"USE_PRICE_COUNT" => "N",
	"SHOW_PRICE_COUNT" => "1",
	"PRICE_VAT_INCLUDE" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "300",
	"CACHE_FILTER" => "N",
	"CACHE_GROUPS" => "Y",
	"PAGER_TEMPLATE" => ".default",
	"DISPLAY_TOP_PAGER" => "N",
	"DISPLAY_BOTTOM_PAGER" => "N",
	"PAGER_TITLE" => "Товары",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	"PAGER_SHOW_ALL" => "N",
	"HIDE_NOT_AVAILABLE" => "N",
	"CONVERT_CURRENCY" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N",
	"THIS_ELEMENT_ID" => $arParams["ELEMENT_ID"],
	"THIS_SECTION_ID" => $arParams["SECTION_ID"],
	)
	);?>
	</div>
	</div>
	<?}?>					
				
				
				
				
				<div style="clear: both;"></div>
			</div>
			<div class="clb"></div>
		</div><?
		if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
		{
			foreach ($arResult['JS_OFFERS'] as &$arOneJS)
			{
				if ($arOneJS['PRICE']['DISCOUNT_VALUE'] != $arOneJS['PRICE']['VALUE'])
				{
					$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'];
					$arOneJS['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'];
				}
				$strProps = '';
				if ($arResult['SHOW_OFFERS_PROPS'])
				{
					if (!empty($arOneJS['DISPLAY_PROPERTIES']))
					{
						foreach ($arOneJS['DISPLAY_PROPERTIES'] as $arOneProp)
						{
							$strProps .= '<dt>'.$arOneProp['NAME'].'</dt><dd>'.(
								is_array($arOneProp['VALUE'])
								? implode(' / ', $arOneProp['VALUE'])
								: $arOneProp['VALUE']
							).'</dd>';
						}
					}
				}
				$arOneJS['DISPLAY_PROPERTIES'] = $strProps;
			}
			if (isset($arOneJS))
				unset($arOneJS);
			$arJSParams = array(
				'CONFIG' => array(
					'USE_CATALOG' => $arResult['CATALOG'],
					'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
					'SHOW_PRICE' => true,
					'SHOW_DISCOUNT_PERCENT' => ($arParams['SHOW_DISCOUNT_PERCENT'] == 'Y'),
					'SHOW_OLD_PRICE' => ($arParams['SHOW_OLD_PRICE'] == 'Y'),
					'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
					'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
					'OFFER_GROUP' => $arResult['OFFER_GROUP'],
					'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
					'SHOW_BASIS_PRICE' => ($arParams['SHOW_BASIS_PRICE'] == 'Y'),
					'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
					'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y')
				),
				'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
				'VISUAL' => array(
					'ID' => $arItemIDs['ID'],
				),
				'DEFAULT_PICTURE' => array(
					'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
					'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
				),
				'PRODUCT' => array(
					'ID' => $arResult['ID'],
					'NAME' => $arResult['~NAME']
				),
				'BASKET' => array(
					'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
					'BASKET_URL' => $arParams['BASKET_URL'],
					'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
					'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
					'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
				),
				'OFFERS' => $arResult['JS_OFFERS'],
				'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
				'TREE_PROPS' => $arSkuProps
			);
			if ($arParams['DISPLAY_COMPARE'])
			{
				$arJSParams['COMPARE'] = array(
					'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
					'COMPARE_PATH' => $arParams['COMPARE_PATH']
				);
			}
		}
		else
		{
			$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
			if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties)
			{
		?>
		<div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
		<?
				if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
				{
					foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)
					{
		?>
			<input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
		<?
						if (isset($arResult['PRODUCT_PROPERTIES'][$propID]))
							unset($arResult['PRODUCT_PROPERTIES'][$propID]);
					}
				}
				$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
				if (!$emptyProductProperties)
				{
		?>
			<table>
		<?
					foreach ($arResult['PRODUCT_PROPERTIES'] as $propID => $propInfo)
					{
		?>
			<tr><td><? echo $arResult['PROPERTIES'][$propID]['NAME']; ?></td>
			<td>
		<?
						if(
							'L' == $arResult['PROPERTIES'][$propID]['PROPERTY_TYPE']
							&& 'C' == $arResult['PROPERTIES'][$propID]['LIST_TYPE']
						)
						{
							foreach($propInfo['VALUES'] as $valueID => $value)
							{
								?><label><input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?></label><br><?
							}
						}
						else
						{
							?><select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
							foreach($propInfo['VALUES'] as $valueID => $value)
							{
								?><option value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>><? echo $value; ?></option><?
							}
							?></select><?
						}
		?>
			</td></tr>
		<?
					}
		?>
			</table>
		<?
				}
		?>
		</div>
		<?
			}
			if ($arResult['MIN_PRICE']['DISCOUNT_VALUE'] != $arResult['MIN_PRICE']['VALUE'])
			{
				$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'];
				$arResult['MIN_BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arResult['MIN_BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'];
			}
			$arJSParams = array(
				'CONFIG' => array(
					'USE_CATALOG' => $arResult['CATALOG'],
					'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
					'SHOW_PRICE' => (isset($arResult['MIN_PRICE']) && !empty($arResult['MIN_PRICE']) && is_array($arResult['MIN_PRICE'])),
					'SHOW_DISCOUNT_PERCENT' => ($arParams['SHOW_DISCOUNT_PERCENT'] == 'Y'),
					'SHOW_OLD_PRICE' => ($arParams['SHOW_OLD_PRICE'] == 'Y'),
					'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
					'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
					'SHOW_BASIS_PRICE' => ($arParams['SHOW_BASIS_PRICE'] == 'Y'),
					'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
					'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y')
				),
				'VISUAL' => array(
					'ID' => $arItemIDs['ID'],
				),
				'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
				'PRODUCT' => array(
					'ID' => $arResult['ID'],
					'PICT' => $arFirstPhoto,
					'NAME' => $arResult['~NAME'],
					'SUBSCRIPTION' => true,
					'PRICE' => $arResult['MIN_PRICE'],
					'PROPERTIES' => $arResult['PROPERTIES'],
					'BASIS_PRICE' => $arResult['MIN_BASIS_PRICE'],
					'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
					'SLIDER' => $arResult['MORE_PHOTO'],
					'CAN_BUY' => $arResult['CAN_BUY'],
					'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
					'QUANTITY_FLOAT' => is_double($arResult['CATALOG_MEASURE_RATIO']),
					'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
					'STEP_QUANTITY' => $arResult['CATALOG_MEASURE_RATIO'],
				),
				'BASKET' => array(
					'ADD_PROPS' => ($arParams['ADD_PROPERTIES_TO_BASKET'] == 'Y'),
					'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
					'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
					'EMPTY_PROPS' => $emptyProductProperties,
					'BASKET_URL' => $arParams['BASKET_URL'],
					'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
					'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
				)
			);
			if ($arParams['DISPLAY_COMPARE'])
			{
				$arJSParams['COMPARE'] = array(
					'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
					'COMPARE_PATH' => $arParams['COMPARE_PATH']
				);
			}
			unset($emptyProductProperties);
		}
		?>	
	</section>
</div>
<?if($arResult['IS_MIN_PRICE']===false){?>
    <div class="min_price_is_reserved">Товар с наименьшей ценой сейчас находится на примерке</div>
 <?}?>
<?
$basketItems = array();
$dbBasketItems = CSaleBasket::GetList(
        array("ID" => "ASC"),
        array("FUSER_ID" => CSaleBasket::GetBasketUserID(),"LID" => SITE_ID,"ORDER_ID" => "NULL"),
        false,
        false,
        array()
);
while($BasketItem = $dbBasketItems->Fetch())	
	$basketItems[$BasketItem["PRODUCT_ID"]] = $BasketItem["ID"];
?>
<script type="text/javascript">
var basketIPG = <?=json_encode($basketItems)?>; 
var offersCatalog = <?=json_encode($arResult['OFFERS'])?>;
var picture = <?=json_encode($arResult['DETAIL_PICTURE'])?>;
var offerID = <?=intval($_REQUEST["offer"])?>;
var <? echo $strObName; ?> = new JCCatalogElement(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
BX.message({
	ECONOMY_INFO_MESSAGE: '<? echo GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO'); ?>',
	BASIS_PRICE_MESSAGE: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_BASIS_PRICE') ?>',
	TITLE_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR') ?>',
	TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS') ?>',
	BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
	BTN_SEND_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS'); ?>',
	BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT') ?>',
	BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE'); ?>',
	BTN_MESSAGE_CLOSE_POPUP: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP'); ?>',
	TITLE_SUCCESSFUL: '<? echo GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK'); ?>',
	COMPARE_MESSAGE_OK: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK') ?>',
	COMPARE_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR') ?>',
	COMPARE_TITLE: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE') ?>',
	BTN_MESSAGE_COMPARE_REDIRECT: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT') ?>',
	SITE_ID: '<? echo SITE_ID; ?>'
});
</script>