<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();/** @var array $arParams */
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
GLOBAL $NAM;
?>


	<?foreach($arResult["ITEMS"] as $arElement):?>
	<?
	$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
	?>
	
<?
	if ($NAM < 2) {
	
?>
			<div class="block-item">
				<a href="<?=$arElement["DETAIL_PAGE_URL"]?>">
					<?if ($arElement["PROPERTIES"]["SKID"]["VALUE"]){?> 
						<div class="label discount"></div>
					<?}?> 	
					<?if ($arElement["PROPERTIES"]["HIT"]["VALUE"]){?> 
						<div class="label hit"></div>
					<?}?>  

					<?if ($arElement["PROPERTIES"]['NOV']["VALUE"]){?> 
						<div class="label new"></div>
					<?}?> 
					
					<img src="<? echo $arElement['DETAIL_PICTURE']['SRC']?>" alt="">
					
					<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
						<?if($arPrice = $arElement["PRICES"][$code]):?>
							<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
								<div class="item-price">от <strong><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></strong></div>
							<?else:?>
								<div class="item-price">от <strong><?=$arPrice["PRINT_VALUE"]?></strong></div>
							<?endif?>
						<?else:?>
							&nbsp;
						<?endif;?>
					<?endforeach;?>
					
					<div class="item-name"><?=$arElement["NAME"]?></div>
				</a>

			</div>
	
	
<?
$NAM = $NAM + 1;
}
	?><?
?>
	<?endforeach;?>

<div class="all-complement open-complements"><span id="pok_f">Показать все <? echo count($arResult["ITEMS"]);?> <br>подходящих изделий</span></div>






<aside class="pop-up clearfix" id="window-complements">
<?$arIBlockElement = GetIBlockElement($arParams["THIS_ELEMENT_ID"]);?>
	    	<div class="column">
        	<div class="pop-title">Основное изделие</div>
            <div class="item-main">
            	<div class="image"><img src="<?=CFile::GetPath($arIBlockElement["DETAIL_PICTURE"])?>" alt=""></div>
                <div class="name"><?=$arIBlockElement["NAME"]?></div>
				<div class="description"><? echo $arElement["PROPERTIES"]["VSTAVKA"]["VALUE"];?></br><? echo $arElement["PROPERTIES"]["MATERIAL"]["VALUE"];?> <? echo $arElement["PROPERTIES"]["PROBA"]["VALUE"];?></div>
                

            </div>
        </div>
    	<div class="column">
        	<div class="pop-title">
            	<div class="button button-white inlinem close" id="mod_form">
                    <img src="/bitrix/templates/GOLDAYS/images/icons/icon-round-black-cancel.png" alt="">Отмена
                </div>
                Сочетающиеся товары
            </div>
            <div class="scrollable">
            	<div class="clearfix">
				
				
				<?foreach($arResult["ITEMS"] as $arElement):?>
				<?
				$arlabel['SKID'] = $arElement["PROPERTIES"]['SKID'];
				$arlabel['HIT'] = $arElement["PROPERTIES"]['HIT'];
				$arlabel['NOV'] = $arElement["PROPERTIES"]['NOV'];
				
				if($arElement["OFFERS"][0])
					$arElement["PROPERTIES"] = $arElement["OFFERS"][0]["PROPERTIES"];
				
				$arElement["PROPERTIES"] = array_merge($arElement["PROPERTIES"], $arlabel);
	
				$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
				?>
	
	               	<div class="block-card">
					
                       	<a href="<?=$arElement["DETAIL_PAGE_URL"]?>">
		                    <img src="<? echo $arElement['DETAIL_PICTURE']['SRC']?>" alt="">
	                    

						<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
							<?if($arPrice = $arElement["PRICES"][$code]):?>
								<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
								
									<div class="old-price"><?=$arPrice["PRINT_VALUE"]?></div>
									<div class="discount"><strong><?=$arPrice['DISCOUNT_DIFF_PERCENT'];?>%</strong>скидка</div>
									<div class="new-price">от <strong><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></strong></div>
									
								<?else:?>
									<div class="new-price">от <strong><?=$arPrice["PRINT_VALUE"]?></strong></div>
								<?endif?>
							<?else:?>
								&nbsp;
							<?endif;?>
						<?endforeach;?>							

				
								<?if ($arElement["PROPERTIES"]["SKID"]["VALUE"]){?> 
									<div class="label discount"></div>
								<?}?> 	

							
								<?if ($arElement["PROPERTIES"]["HIT"]["VALUE"]){?> 
									<div class="label hit"></div>
								<?}?>  

								<?if ($arElement["PROPERTIES"]['NOV']["VALUE"]){?> 
									<div class="label new"></div>
								<?}?> 

					
								
		                    <div class="name"><? echo $arElement["PROPERTIES"]["VID"]["VALUE"];?></div>
							
							
							<div class="description"><? echo $arElement["PROPERTIES"]["VSTAVKA"]["VALUE"];?></br><? echo $arElement["PROPERTIES"]["MATERIAL"]["VALUE"];?> <? echo $arElement["PROPERTIES"]["PROBA"]["VALUE"];?></div>
                        
						</a>
                    </div>
					
				<?endforeach;?>


                </div>
                
            </div>
        </div>
    </aside>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<p><?=$arResult["NAV_STRING"]?></p>
<?endif?>

