<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
			<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "", Array(
				"PATH_TO_BASKET" => "/basket/index.php",	// Страница корзины
				"PATH_TO_ORDER" => "/personal/order.php",	// Страница оформления заказа
				"SHOW_DELAY" => "N",	// Показывать отложенные товары
				"SHOW_NOTAVAIL" => "N",	// Показывать товары, недоступные для покупки
				"SHOW_SUBSCRIBE" => "N",	// Показывать товары, на которые подписан покупатель
				),
				false
			);?>