<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?IncludeTemplateLangFile(__FILE__);?>
<?$CurPage = $APPLICATION->GetCurPage();?>
<?if($CurPage != '/help/' ):?>
<?if($CurPage != '/catalog/' ):?>
<?if($CurPage != '/basket/' ):?>
					<?if 
					( 
					(strpos($APPLICATION->GetCurDir(), '/catalog/')!== false) or 
					(strpos($APPLICATION->GetCurDir(), '/basket/')!== false)
					):
					else: ?>
<!--======= FOOTER start =======-->
	<footer id="footer-wrapper">
		<div class="footer clearfix">

            <a id="showtips" href="javascript:void(0);" class="button button-white inline left">
                <img src="<?=SITE_TEMPLATE_PATH?>/images/icons/icon-round-black-advice.png" alt="">
                <div class="med">Советы по выбору изделия</div>
            </a>
            <a href="javascript:void(0);" class="button button-black inline center bt_centr">
                <img src="<?=SITE_TEMPLATE_PATH?>/images/icons/icon-round-white-down.png" alt="">Выберите тип товара
            </a>

            <a href="catalog/?&lui[nul]=N" class="button button-white inline right">
	           	<img src="<?=SITE_TEMPLATE_PATH?>/images/icons/icon-round-black-list.png" alt="">
                <div class="big">Подберите изделие</div>
                <div class="small">по характеристикам</div>
	        </a>
    		
            <nav class="menu-footer clear">
				<ul class="clearfix">
				<?
				if(CModule::IncludeModule("iblock"))
				{
				   $items = GetIBlockSectionList(5, false, Array("sort"=>"asc"), 8);
				   while($arItem = $items->GetNext())
				   {	
				?>
					<li>
						<a href="/catalog/<?=$arItem["ID"]?>/">
						<img src="<?=CFile::GetPath($arItem["PICTURE"])?>" alt=""><?=$arItem["NAME"]?>
						</a>
					</li>
				<?
				   }
				}
				?>
				</ul>
            </nav>
		</div>
    </footer><!--/.footer-wrapper-->


<!--======= FOOTER end =======-->
 <?endif?>

<?endif;?>

<?endif;?>
<?endif;?>
<!--======= SCRIPTS start =======-->

<?/*$APPLICATION->IncludeComponent("bitrix:sale.basket.basket", "mini", Array(
	"OFFERS_PROPS" => array(0=>"CML2_ARTICLE",1=>"CML2_BASE_UNIT",2=>"VES_VSTAVKI_SPRAVOCHNIK_QUOT_KHARAKTERISTIKI_NOMEN",3=>"VES_IZDELIYA",4=>"VID",5=>"VSTAVKA",6=>"KLASS",7=>"MATERIAL",8=>"PODVID",9=>"PROBA",10=>"CML2_MANUFACTURER",11=>"RAZMER",12=>"CML2_TRAITS",13=>"CML2_TAXES",14=>"STIKER",15=>"KHAR_KA_BRILLIANTA",16=>"CML2_ATTRIBUTES",17=>"CML2_BAR_CODE",), // Свойства, влияющие на пересчет корзины
	"PATH_TO_ORDER" => "/personal/order.php",	// Страница оформления заказа
	"HIDE_COUPON" => "Y",	// Спрятать поле ввода купона
	"COLUMNS_LIST" => array(	// Выводимые колонки
		0 => "NAME",
		1 => "DISCOUNT",
		2 => "WEIGHT",
		3 => "DELETE",
		4 => "DELAY",
		5 => "TYPE",
		6 => "PRICE",
		7 => "QUANTITY",
	),
	"PRICE_VAT_SHOW_VALUE" => "N",	// Отображать значение НДС
	"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",	// Рассчитывать скидку для каждой позиции (на все количество товара)
	"USE_PREPAYMENT" => "N",	// Использовать предавторизацию для оформления заказа (PayPal Express Checkout)
	"QUANTITY_FLOAT" => "N",	// Использовать дробное значение количества
	"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
	"ACTION_VARIABLE" => "action",	// Название переменной действия
	),
	false
);*/?>


<div id="tips">
    <span class="close">Закрыть</span>
    <div class="wr"> 
        <span class="ttl">Как правильно выбрать изделие?</span>
        <span class="ttl2">Ознакомьтесь с нашими советами <br />по подбору изделия для разных случаев</span>
        
        <?$APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "sovet",
            Array(
                "DISPLAY_DATE" => "N",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "N",
                "DISPLAY_PREVIEW_TEXT" => "Y",
                "AJAX_MODE" => "N",
                "IBLOCK_TYPE" => "content",
                "IBLOCK_ID" => "9",
                "NEWS_COUNT" => "2000",
                "SORT_BY1" => "SORT",
                "SORT_ORDER1" => "ASC",
                "SORT_BY2" => "SORT",
                "SORT_ORDER2" => "ASC",
                "FILTER_NAME" => "",
                "FIELD_CODE" => array(),
                "PROPERTY_CODE" => array(),
                "CHECK_DATES" => "Y",
                "DETAIL_URL" => "",
                "PREVIEW_TRUNCATE_LEN" => "",
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "N",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "ADD_SECTIONS_CHAIN" => "N",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "PARENT_SECTION" => "",
                "PARENT_SECTION_CODE" => "",
                "INCLUDE_SUBSECTIONS" => "Y",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "Y",
                "PAGER_TEMPLATE" => ".default",
                "DISPLAY_TOP_PAGER" => "N",
                "DISPLAY_BOTTOM_PAGER" => "N",
                "PAGER_TITLE" => "Новости",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "AJAX_OPTION_HISTORY" => "N"
            ),
        false
        );?>

    </div>
</div>


<div class="basket_popup closes" id="basket_popup_closes">
       
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




    </div>


<div id="prostoi">
    <span class="close">Закрыть</span>
    <span class="ttl">С системой давно не производилось <br />никаких операций.</span>
    <span class="ttl2">Отложенные покупки скоро будут удалены <br />и автоматически будет начат новый сеанс работы</span>
    <a id="cont_sess" href="javascript:void(0);" onclick="clearInterval();">Продолжить текущий сеанс</a>
    <a id="new_sess" href="/basket/clear.php?action=clear">Начать <br />новый сеанс</a>
</div>



<?
$dbBasketItems = CSaleBasket::GetList(
    array(
        "NAME" => "ASC",
        "ID" => "ASC"
    ),
    array(
        "FUSER_ID" => CSaleBasket::GetBasketUserID(),
        "LID" => SITE_ID,
        "ORDER_ID" => "NULL"
    ),
    false,
    false,
    array("ID",
        "CALLBACK_FUNC",
        "MODULE",
        "PRODUCT_ID",
        "QUANTITY",
        "DELAY",
        "CAN_BUY",
        "PRICE",
        "WEIGHT")
);

//if ($dbBasketItems->SelectedRowsCount() > 0) {
    ?>
    <script type="text/javascript">
      var no_active_delay = 60; // Количество секунд простоя мыши, при котором пользователь считается неактивным
      var no_active_to_clear = no_active_delay+60;
      var now_no_active2 = 0; // Текущее количество секунд простоя мыши

      setInterval(function(){
                
                now_no_active2++;

            },
            1000
      ); // Каждую секунду увеличиваем количество секунд простоя мыши
      setInterval(updateChat, 1000); // Запускаем функцию updateChat() через определённый интервал

      document.onmousemove = activeUser; // Ставим обработчик на движение курсора мыши
      document.onmouseclick = activeUser; // Ставим обработчик на движение курсора мыши

      function activeUser() {
          now_no_active2 = 0; // Обнуляем счётчик простоя секунд
      }

      function updateChat() {
        
        if (now_no_active2 >= no_active_to_clear ) { // Проверяем не превышен ли "предел активности" пользователя
            window.location = "/basket/clear.php?action=clear";
        }else if(now_no_active2 >= no_active_delay){
            $('#prostoi, #overlay').show();
        }
      }

      function clearInterval(){
            now_no_active2 = 0;
      }
    </script>
    <?
//}
?>

<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/scripts/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/scripts/jcarousellite.js"></script>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/scripts/carousel.js"></script>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/scripts/custom.js"></script>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/scripts/jquery.sliderkit.1.4.min.js"></script>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/scripts/jquery.jscrollpane.min.js"></script>

<!--======= SCRIPTS end =======-->

	</body>
</html>