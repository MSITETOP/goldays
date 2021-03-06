<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket", 
	"basket_popup", 
	array(
		"COLUMNS_LIST" => array(
			0 => "WEIGHT",
			1 => "DELETE",
			2 => "PRICE",
			3 => "QUANTITY",
			4 => "SUM",
			5 => "PROPERTY_VID",
			6 => "PROPERTY_MATERIAL",
			7 => "PROPERTY_PROBA",
			8 => "PROPERTY_VSTAVKA",
			9 => "PROPERTY_VES",
			10 => "PROPERTY_RAZMER",
		),
		"PATH_TO_ORDER" => "/personal/order.php",
		"HIDE_COUPON" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"USE_PREPAYMENT" => "N",
		"QUANTITY_FLOAT" => "N",
		"SET_TITLE" => "Y",
		"ACTION_VARIABLE" => "action",
		"OFFERS_PROPS" => array(
			0 => "CML2_ARTICLE",
			1 => "CML2_BASE_UNIT",
			2 => "VES",
			3 => "VES_VSTAVKI_SPRAVOCHNIK_QUOT_KHARAKTERISTIKI_NOMEN",
			4 => "VES_IZDELIYA",
			5 => "KLASS",
			6 => "CML2_MANUFACTURER",
			7 => "RAZMER",
			8 => "CML2_TRAITS",
			9 => "CML2_TAXES",
			10 => "KHAR_KA_BRILLIANTA",
			11 => "CML2_ATTRIBUTES",
			12 => "CML2_BAR_CODE",
			13 => "VID",
			14 => "MATERIAL",
			15 => "VSTAVKA",
			16 => "PROBA",
			17 => "PODVID",
		),
		"COMPONENT_TEMPLATE" => "basket_popup"
	),
	false
);?> 
        <?$APPLICATION->IncludeComponent(
            "ipg:order.confirm",
            "",
            Array(
            )
        );?> 