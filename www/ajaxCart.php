<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("GOLDAYS Ювелирные украшения по разумной цене!");
?> 
			<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "smal_basket2", Array(
				"PATH_TO_BASKET" => "/basket/index.php",	// Страница корзины
				"PATH_TO_ORDER" => "/personal/order.php",	// Страница оформления заказа
				"SHOW_DELAY" => "N",	// Показывать отложенные товары
				"SHOW_NOTAVAIL" => "N",	// Показывать товары, недоступные для покупки
				"SHOW_SUBSCRIBE" => "N",	// Показывать товары, на которые подписан покупатель
				),
				false
			);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>