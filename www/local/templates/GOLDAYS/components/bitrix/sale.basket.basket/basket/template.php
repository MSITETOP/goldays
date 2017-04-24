<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$arUrls = Array(
	"delete" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=delete&id=#ID#",
	"delay" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=delay&id=#ID#",
	"add" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=add&id=#ID#",
);
?>

<? 

$arBasketJSParams = array(
	'SALE_DELETE' => GetMessage("SALE_DELETE"),
	'SALE_DELAY' => GetMessage("SALE_DELAY"),
	'SALE_TYPE' => GetMessage("SALE_TYPE"),
	'TEMPLATE_FOLDER' => $templateFolder,
	'DELETE_URL' => $arUrls["delete"],
	'DELAY_URL' => $arUrls["delay"],
	'ADD_URL' => $arUrls["add"]
);
global $sum_tov;
global $kol_tov;
?>
<script type="text/javascript">
	var basketJSParams = <?=CUtil::PhpToJSObject($arBasketJSParams);?>
</script>

<?
$APPLICATION->AddHeadScript($templateFolder."/script.js");

include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/functions.php");
include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/result_modifier.php");

if (strlen($arResult["ERROR_MESSAGE"]) <= 0)
{
	?>
	<div id="warning_message">
		<?
		if (is_array($arResult["WARNING_MESSAGE"]) && !empty($arResult["WARNING_MESSAGE"]))
		{
			foreach ($arResult["WARNING_MESSAGE"] as $v)
				echo ShowError($v);
		}
		?>
	</div>
	<?

	$normalCount = count($arResult["ITEMS"]["AnDelCanBuy"]);
	$normalHidden = ($normalCount == 0) ? "style=\"display:none\"" : "";

	$delayCount = count($arResult["ITEMS"]["DelDelCanBuy"]);
	$delayHidden = ($delayCount == 0) ? "style=\"display:none\"" : "";

	$subscribeCount = count($arResult["ITEMS"]["ProdSubscribe"]);
	$subscribeHidden = ($subscribeCount == 0) ? "style=\"display:none\"" : "";

	$naCount = count($arResult["ITEMS"]["nAnCanBuy"]);
	$naHidden = ($naCount == 0) ? "style=\"display:none\"" : "";

	?>

	
	
		<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="basket_form" id="basket_form">
			<div id="basket_form_container">
				<div class="bx_ordercart">
<!--======= CONTAINER start =======-->
	<div id="container" class="cart">
		<div class="left-gradient"></div>
        <div class="right-gradient"></div>
<!--======= HEADER start =======-->
		<header class="header">
        	<a href="/catalog/" class="button button-white inline">
            	<img src="<?=SITE_TEMPLATE_PATH?>/images/icons/icon-round-black-left.png" alt="">Назад
            </a>
			<a class="button button-white inline" onClick="document.location='<?=$APPLICATION->GetCurPage();?>?action=clear'" onclick="return ClearCart(this);" >
				<img src="<?=SITE_TEMPLATE_PATH?>/images/icons/icon-round-black-refresh.png" alt="">Очистить
			</a>
        	<div class="slogan">Товары для примерки</div>
		</header>
		<!--/.header-->
<!--======= HEADER end =======-->
<!--======= CONTENT start =======-->
		<section id="content">
			<div class="slider-wrapper">
				<div class="slider">
					<ul class="clearfix">
				<?
				
				foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):

					if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):
					
				$kol_tov = $kol_tov + 1;
				?>					
					
				    	<li>
	
							<div class="inline delete"><span><a href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>"><?=GetMessage("SALE_DELETE")?></a></span></div>
							
							
							
							<!--<a href="<? //str_replace("#ID#", $arItem["ID"], $arUrls["delay"])?>"><? //GetMessage("SALE_DELAY")?></a> !-->
							
							<div class="block-card">
                               	<a href="<?=$arItem["DETAIL_PAGE_URL"] ?>">
								
										<?
										if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0):
											$url = $arItem["PREVIEW_PICTURE_SRC"];
										elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0):
											$url = $arItem["DETAIL_PICTURE_SRC"];
										else:
											$url = $templateFolder."/images/no_photo.png";
										endif;
										?>

										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
											<img src="<?=$url?>" alt="">
										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>

		                        

									<div class="quantity">
									 
									<?
													$ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
													$max = isset($arItem["AVAILABLE_QUANTITY"]) ? "max=\"".$arItem["AVAILABLE_QUANTITY"]."\"" : "";
													$useFloatQuantity = ($arParams["QUANTITY_FLOAT"] == "Y") ? true : false;
													$useFloatQuantityJS = ($useFloatQuantity ? "true" : "false");
													
													echo $arItem["QUANTITY"]; ?> шт
									<?$sum_tov = $sum_tov + $arItem["QUANTITY"] ;?>
									
									</div>
		                            <div class="price" "current_price_<?=$arItem["ID"]?>"><?=$arItem["PRICE_FORMATED"]?></div>
		                            <div class="name"><? echo $arItem[PROPERTY_VID_VALUE];?></div>
		                            <div class="description"><? echo $arItem[PROPERTY_VSTAVKA_VALUE];?> </br><? echo $arItem[PROPERTY_MATERIAL_VALUE];?> <? echo $arItem[PROPERTY_PROBA_VALUE];?>
	                                </div>
                                </a>
                            </div>
                        </li>
					
					<?
					

					
					
					endif;
				endforeach;
				?>
					
				    </ul>
				</div>
				<?
			if ($kol_tov > 3) {?>
				<div class="prev"></div>
				<div class="next"></div>
			<?}?>			
				
			</div>
			<h1>Вы выбрали следующие <?echo $sum_tov; ?> товара.</h1>
            <div class="wrapper-total clearfix">
                <div class="total"><?=GetMessage("SALE_TOTAL")?> <?=str_replace(" ", "&nbsp;", $arResult["allSum_FORMATED"])?></div>
                <div class="try">
                	<a href="javascript:void(0);" class="button button-white inline">
		            	<img src="<?=SITE_TEMPLATE_PATH?>/images/icons/icon-round-black-try.png" alt=""> Примерить эти изделия
		            </a>
                    <div>
                    	Нажмите на эту кнопку и подойдите<br>
                    	к консультанту для примерки и продажи
                    </div>
                </div>
            </div>
		</section><!--/.content -->
<!--====== CONTENT end =======-->
	</div>
<!--/.container -->
<!--======= CONTAINER end =======-->

				</div>
			</div>
			<input type="hidden" name="BasketOrder" value="BasketOrder" />
			<!-- <input type="hidden" name="ajax_post" id="ajax_post" value="Y"> -->
		</form>



<!-- IPG Expansion -->
<input type="hidden" data-cart-basket="y" data-price="<?=$arResult['allSum']?>" data-discount="<?=$arResult['DISCOUNT_PRICE_ALL']?>" />
<?
//echo "<pre>"; print_r($arResult); echo "</pre>";
foreach ($arResult["GRID"]["ROWS"] as $k => $arItem) {
    if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y") {
        ?>
        <input type="hidden" data-cart="y" data-price="<?=$arItem['PRICE']?>" data-img="<?=$arItem['DETAIL_PICTURE_SRC']?>" data-xmlid="<?=$arItem['PRODUCT_XML_ID']?>" data-name="<?=$arItem['NAME']?>" data-desc="" />
    <?
    }
}
?>
<!-- _IPG Expansion -->
	<?
}
else
{?>
	
	
	<!--======= CONTAINER start =======-->
	<div id="container" class="cart">
		<div class="left-gradient"></div>
        <div class="right-gradient"></div>
<!--======= HEADER start =======-->
		<header class="header">
        	<a href="/" class="button button-white inline">
            	<img src="<?=SITE_TEMPLATE_PATH?>/images/icons/icon-round-black-left.png" alt="">Назад
            </a>
		</header>
		<!--/.header-->
<!--======= HEADER end =======-->
	
<!--======= CONTENT start =======-->
		<section id="content">
            <h1>Ваша корзина пуста.</h1>
			<div class="slider-wrapper">


			</div>
            <div class="wrapper-total clearfix">

            </div>
		</section><!--/.content -->
<!--====== CONTENT end =======-->
	</div>
<!--/.container -->
<!--======= CONTAINER end =======-->

<?}
?>