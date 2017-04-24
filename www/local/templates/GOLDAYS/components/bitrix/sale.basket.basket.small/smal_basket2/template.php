<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if ($arResult["READY"]=="Y" || $arResult["DELAY"]=="Y" || $arResult["NOTAVAIL"]=="Y" || $arResult["SUBSCRIBE"]=="Y"):?>
	<div class="basket_r">
    	<div class="basket_bt"></div>
    	<div class="basket_region">
    		<?foreach($arResult["ITEMS"] as $arItem):?>
    			<?if(!empty($arResult["PICTURE"][$arItem["PRODUCT_ID"]])):?>
        			<div class="basket_item"><img src="<?=$arResult["PICTURE"][$arItem["PRODUCT_ID"]]?>" alt="<?=$arItem["NAME"];?>" title="<?=$arItem["NAME"];?>"></div>
        		<?endif;?>
        	<?endforeach;?>        	
    	</div>
    	<div class="basket_count_r">
        	<div class="basket_count"><?=count($arResult["ITEMS"]);?></div>
        	<div class="basket_txt">отложенных <?=$arResult["END_WORD"];?></div>
        	
    	</div>
	</div>
<?endif;?>


