<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->IncludeLangFile('template.php');
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/GOLDAYS/components/bitrix/sale.basket.basket/mini/template.php"); ?>	



		<?if ($arParams['SHOW_NUM_PRODUCTS'] == 'Y'):?>
		<?if ($arResult['NUM_PRODUCTS'] > 0):?>
			
			<a href="<?=$arParams['PATH_TO_BASKET']?>" class="button button-white inline" id="tov"><?echo "Отложенные изделия ("?><?echo $sum_tov; echo ")";?>
				<img src="/bitrix/templates/GOLDAYS/images/icons/icon-round-black-cart.png" alt="">
			</a>
		<?else:?>
			
			<a href="<?=$arParams['PATH_TO_BASKET']?>" class="button button-white inline" id="tov"><?echo "Отложенные изделия (0)"?>
				<img src="/bitrix/templates/GOLDAYS/images/icons/icon-round-black-cart.png" alt="">
			</a>
		

		<?endif?>
	
	


		<?endif?>
		
