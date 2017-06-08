<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$arUrls = Array(
	"delete" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=delete&id=#ID#",
	"delay" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=delay&id=#ID#",
	"add" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=add&id=#ID#",
);

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
				<?
				
				foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):

					if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):
					
				$kol_tov = $kol_tov + 1;
					?>					
						<?$sum_tov = $sum_tov + $arItem["QUANTITY"] ;?>
					<?
		
					endif;
				endforeach;
				?>
	<input type="hidden" id='colichestvo_tovara' value="<? echo $sum_tov; ?>">				

<?}
?>