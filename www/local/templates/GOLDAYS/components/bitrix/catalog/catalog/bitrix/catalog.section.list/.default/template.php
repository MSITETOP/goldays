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
$arViewModeList = $arResult['VIEW_MODE_LIST'];
$arViewStyles = array(
'LIST' => array(
'CONT' => 'bx_sitemap',
'TITLE' => 'bx_sitemap_title',
'LIST' => 'bx_sitemap_ul',
),
'LINE' => array(
'CONT' => 'bx_catalog_line',
'TITLE' => 'bx_catalog_line_category_title',
'LIST' => 'bx_catalog_line_ul',
'EMPTY_IMG' => $this->GetFolder().'/images/line-empty.png'
),
'TEXT' => array(
'CONT' => 'bx_catalog_text',
'TITLE' => 'bx_catalog_text_category_title',
'LIST' => 'bx_catalog_text_ul'
),
'TILE' => array(
'CONT' => 'bx_catalog_tile',
'TITLE' => 'bx_catalog_tile_category_title',
'LIST' => 'bx_catalog_tile_ul',
'EMPTY_IMG' => $this->GetFolder().'/images/tile-empty.png'
)
);
$arCurView = $arViewStyles[$arParams['VIEW_MODE']];
$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));
?>
<div id="container" class="category">
<!--======= HEADER start =======-->
<?
if ('Y' == $arParams['SHOW_PARENT_NAME'] && 0 < $arResult['SECTION']['ID'])
{
	$this->AddEditAction($arResult['SECTION']['ID'], $arResult['SECTION']['EDIT_LINK'], $strSectionEdit);
	$this->AddDeleteAction($arResult['SECTION']['ID'], $arResult['SECTION']['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
}
if (0 < $arResult["SECTIONS_COUNT"])
{
	?>
	<header class="header">
	<a href="javascript:history.back()" onMouseOver="window.status='Назад';return true" class="button button-white inline">
	<img src="<?=SITE_TEMPLATE_PATH?>/images/icons/icon-round-black-left.png" alt="">Назад
	</a>

	<a href="/basket/clear.php?action=clear" class="button button-white inline new_bt white_bt new_bt">
		Новый сеанс
	</a>
	 <?/*$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket.line",
	"basket_list",
	Array(
	"PATH_TO_BASKET" => SITE_DIR."basket/index.php",
	"PATH_TO_PERSONAL" => SITE_DIR."basket/index.php",
	"SHOW_PERSONAL_LINK" => "N",
	"SHOW_NUM_PRODUCTS" => "Y",
	"SHOW_TOTAL_PRICE" => "N",
	"SHOW_PRODUCTS" => "N",
	"POSITION_FIXED" => "N"
	)
	);*/?>
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
	<div class="category-select">
	<script>
	function _go() {
		location.href=document.getElementById('address').options[document.getElementById('address').selectedIndex].value;
	}
	function _go2() {
		location.href=document.getElementById('address2').options[document.getElementById('address2').selectedIndex].value;
	}
	function _go3() {
		location.href=document.getElementById('address3').options[document.getElementById('address3').selectedIndex].value;
	}
	</script>
	



<?
    $arfilter = Array('IBLOCK_ID'=>5,'DEPTH_LEVEL'=>'1');
    $db_list_i = CIBlockSection::GetList(Array(), $arfilter, true, Array("UF_RAZDEL"));

?>


		<select onchange="_go()" id="address">
	<option selected  value="/catalog/">Все</option>
	<?
	switch ($arParams['VIEW_MODE'])
	{
	case 'TILE':
		foreach ($arResult['SECTIONS'] as &$arSection)
		{
		

	
			$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
			$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
			if (false === $arSection['PICTURE'])
			$arSection['PICTURE'] = array(
			'SRC' => $arCurView['EMPTY_IMG'],
			'ALT' => (
			'' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
			? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
			: $arSection["NAME"]
			),
			'TITLE' => (
			'' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
			? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
			: $arSection["NAME"]
			)
			);
			?>
<?
			$ar_result_i = $db_list_i->GetNext();
?>	
		<option class='<?echo $ar_result_i['UF_RAZDEL']; echo $arResult['SECTIONS']['ID'];?>' value="<? echo $arSection['SECTION_PAGE_URL']; ?>" id="<? echo $this->GetEditAreaId($arSection['ID']); ?>"><? echo $arSection['NAME']; ?></option>
	<?
	
		}
		unset($arSection);
		break;
	}
	?>
	</select>
	</div>
	<?}?>
<?
$url_str_1= $_SERVER['REQUEST_URI'];
// вырезаем все геты с верхней сортировкой	
	$dop_url=$_SERVER['REQUEST_URI'];
	$del_ur=$APPLICATION->GetCurPage();
	$dop_url=str_replace($del_ur,'',$dop_url);
	$del_ur='?';
	$dop_url=str_replace($del_ur,'',$dop_url);
	$del_ur='&pole_sort=CAT_BASE_PRICE';
	$dop_url=str_replace($del_ur,'',$dop_url);
	$del_ur='&sort_catalog=desc';
	$dop_url=str_replace($del_ur,'',$dop_url);
	$del_ur='&pole_sort=shows';
	$dop_url=str_replace($del_ur,'',$dop_url);
	$del_ur='&sort_catalog=asc';
	$dop_url=str_replace($del_ur,'',$dop_url);
///////////////////////////////////////

$findme   = 'pole_sort';
$pos = strpos($url_str_1, $findme);
if ($pos === false) {
	$val_n_s='';
} else {
	$findme   = 'pole_sort=CAT_BASE_PRICE';
	$pos = strpos($url_str_1, $findme);
	if ($pos === false) {
		$val_n_s='&pole_sort=shows';
	} else {
		$val_n_s='&pole_sort=CAT_BASE_PRICE';
	}
}
$findme   = 'sort_catalog';
$pos = strpos($url_str_1, $findme);
if ($pos === false) {
	$val_p='';
} else {
	$findme   = 'sort_catalog=desc';
	$pos = strpos($url_str_1, $findme);
	if ($pos === false) {
		$val_p='&sort_catalog=asc';
	} else {
		$val_p='&sort_catalog=desc';
	}
}



if($_GET['sort_catalog']=='asc'){$prov='asc';}else{$prov='desc';}
if($_GET['pole_sort']=='CAT_BASE_PRICE'){$pol_ch ='CAT_BASE_PRICE';}else{$pol_ch ='shows';}
?>

<div class="block-filter">
<div><div>
<ul class="clearfix">
<li>Сортировать:</li>
<li>
<select onchange="_go3()" id="address3">
<option value="?<?echo $dop_url.$val_p ;?>&pole_sort=CAT_BASE_PRICE" <? if($pol_ch=='CAT_BASE_PRICE'){echo 'selected="selected"';} ?>>по цене</option>
<option value="?<?echo $dop_url.$val_p ;?>&pole_sort=shows"  <? if($pol_ch=='shows'){echo 'selected="selected"';} ?>>по популярности</option>
</select>
</li>
<li>
<select onchange="_go2()" id="address2">
<option value="?<? echo $dop_url.$val_n_s ;?>&sort_catalog=asc" <? if($prov=='asc'){echo 'selected="selected"';} ?> >по возрастанию</option>
<option value="?<?echo $dop_url.$val_n_s ;?>&sort_catalog=desc" <? if($prov=='desc'){echo 'selected="selected"';} ?> >по убыванию</option>
</select>
</li>
</ul>
</div></div>
</div>
	<script>
	$(document).ready(function(){
		//нестандартный селект (select)
		var i,n = 0;
		$('select').each(function(){
			if ($(this).parents('div').hasClass('sidebar')) {
			} else {
				if(!n++)
					$(this).wrap('<div class="styled-select '+ $(this).attr('class') +'"></div>').after('<div id="bla_bla" class="select">по популярности</div><ul></ul>');
				else
					$(this).wrap('<div class="styled-select '+ $(this).attr('class') +'"></div>').after('<div id="bla_bla" class="select">по убыванию</div><ul></ul>');
				
				$('option', this).each(function(){
					if ($(this).parents('div').hasClass('category-select')) {
						$(this).parents('select').siblings('ul').append('<li class="'+$(this).attr('class')+'">'+$(this).text()+'</li>');
					} else {
						$(this).parents('select').siblings('ul').append('<li>'+$(this).text()+'</li>');
					};
					if ($(this).attr('selected')=='selected'){
						$(this).parents('select').siblings('.select').text($(this).text());
					};
				});
				$(this).hide().parents('.wrapper_select').css('z-index', (999-i));
				i++;
			};
		});
		$('.styled-select').on('click', function(){
			$(this).toggleClass('active').children('ul').slideToggle(300);
			var obj = $(this);
			$(document).click(function(event) {
				if ($(event.target).closest(obj).length) return;
				obj.removeClass('active').children('ul').slideUp(300);
				event.stopPropagation();
			});
		});
		$('.styled-select ul li').on('click', function(){
			var index=$(this).index();
			$(this).addClass('active').siblings('li').removeClass('active');
			$('.select', $(this).parents('.styled-select')).text($(this).text());
			$('select option', $(this).parents('.styled-select')).removeAttr('selected').eq(index).attr('selected','selected');
			$('select', $(this).parents('.styled-select')).val($('option:selected', $(this).parents('.styled-select')).val()).change();
		});
		<?
		$id_str=$APPLICATION->GetCurDir();
		$id_s=explode('/',$id_str); 
		switch ($id_s[2]) {
		case 21:
			echo "$('#bla_bla').html('Кольца');";
			break;
		case 23:
			echo "$('#bla_bla').html('Серьги');";
			break;
		case 26:
			echo "$('#bla_bla').html('Подвески');";
			break;
		case 27:
			echo "$('#bla_bla').html('Цепи');";
			break;
		default:
			echo "$('#bla_bla').html('Все');";
		}
		?>
	});
	</script>
</header>
<!--/.header-->
<!--======= HEADER end =======-->