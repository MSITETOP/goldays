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

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/colors.css',
	'TEMPLATE_CLASS' => 'bx-'.$arParams['TEMPLATE_THEME']
);

if (isset($templateData['TEMPLATE_THEME']))
{
	$this->addExternalCss($templateData['TEMPLATE_THEME']);
}
$this->addExternalCss("/bitrix/css/main/bootstrap.css");
$this->addExternalCss("/bitrix/css/main/font-awesome.css");


?>

<div class="sidebar"> 
<h1>Какие товары вам интересны?</h1>
	<nav class="menu-sidebar">
		<ul>
			<?	//not prices
				foreach($arResult["ITEMS"] as $key=>$arItem)
				{
					if(
						empty($arItem["VALUES"])
						|| isset($arItem["PRICE"])
					)
						continue;

					if (
						$arItem["DISPLAY_TYPE"] == "A"
						&& (
							$arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0
						)
					)
						continue;
					?>
							<?
							$arCur = current($arItem["VALUES"]);
							switch ($arItem["DISPLAY_TYPE"])
							{
								case "F":
									$arResult["FILTER_URL"] = htmlspecialchars_decode($arResult["FILTER_URL"]);
									$propURL = preg_replace("/&arrFilter_(\d+)_(\d+)=Y/i", "", $arResult["FILTER_URL"]);
									$class = "";
									if($arItem["CODE"]=="HIT") 
										$class = "gold";
									if($arItem["CODE"]=="SKID") 
										$class = "silver";
									if($arItem["CODE"]=="NOV") 
										$class = "bronze";
									?>
									<li class="<?=$class?>">
									<?foreach ($arItem["VALUES"] as $val => $ar):?>
										<a href="<?=$propURL?>&<?=$ar["CONTROL_NAME"]?>=Y"><?=$arItem["NAME"]?><span></span></a>
									<?endforeach?>
									</li>
									<?
									break;
								case "P":
									$arResult["FILTER_URL"] = htmlspecialchars_decode($arResult["FILTER_URL"]);
									$propURL = preg_replace("/&arrFilter_".$arItem["ID"]."_(\d+)=Y/i", "", $arResult["FILTER_URL"]);
									?>
									<li>
										<a><?=$arItem["NAME"]?><ss id='xx_<?echo $arItem["ID"];?>'></ss></a>
										<select size="1">	
											<option iii="1" kuku="<?=$propURL?>" vbrsp="<? echo "xx_".$arItem["ID"];?>">Все варианты</option>
											<?foreach($arItem["VALUES"] as $val => $ar):?>							
											<option vbrsp="<? echo "xx_".$arItem["ID"];?>" mmm="<?=$ar["VALUE"];?>" yes_no="<? if($ar["CHECKED"]){echo "Y";}else{ echo "N";} ?>" kuku='<?=$propURL?>&<?=$ar["CONTROL_NAME"]?>=Y'><?echo $ar["VALUE"];?></option>
											<?endforeach;?>
										</select>		
									</li>
									<?
									break;
							}
							?>
				<?
				}
				?>
		</ul>
	</nav>
</div>
<script>
//скрипт рисования левого меню
var i =0;
	$('select').each(function(){
		if ($(this).parents('div').hasClass('sidebar')) {
			$(this).after('<ul></ul>').hide();
			
			$('option', this).each(function(){
			var ssv=$(this).attr('kuku');
			$(this).parents('select').siblings('ul').append('<li><a href="'+ssv+'">'+$(this).text()+'</a></li>');
				var id_el=$(this).attr('vbrsp');
				var nam_val=$(this).attr('mmm');
				var y_n=$(this).attr('yes_no');
				var ff=$(this).attr('iii');
				var temp=id_el;
				if(ff==1){$("#"+temp).html('Все варианты');}			
				if(y_n=="Y"){$("#"+temp).html(nam_val);}
			});
		} 
	});
</script>	
<script>
//скрипт показа левого меню
    $('.menu-sidebar>ul>li:last').addClass('last');
	$('.menu-sidebar>ul>li').on('mouseover', function(){
	    $(this).addClass('active');
		var obj=$(this);
		function f_delay(){
			if (obj.hasClass('active')) {
				obj.children('ul').fadeIn(300);
			} else {
				obj.removeClass('active');
				obj.children('ul').fadeOut(300);
			};
		};
		setTimeout(f_delay, 600);
	});
	$('.menu-sidebar>ul>li').on('mouseleave', function(){
	    $(this).removeClass('active');
		var obj=$(this);
		function f_delay(){
			if (obj.hasClass('active')) {
				obj.children('ul').fadeIn(300);
			} else {
				obj.removeClass('active');
				obj.children('ul').fadeOut(300);
			};
		};
		setTimeout(f_delay, 200);
	});
</script>