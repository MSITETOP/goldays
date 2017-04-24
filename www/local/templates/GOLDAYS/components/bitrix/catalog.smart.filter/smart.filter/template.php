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
CJSCore::Init(array("fx"));
if (file_exists($_SERVER["DOCUMENT_ROOT"].$this->GetFolder().'/themes/'.$arParams["TEMPLATE_THEME"].'/colors.css'))
	$APPLICATION->SetAdditionalCSS($this->GetFolder().'/themes/'.$arParams["TEMPLATE_THEME"].'/colors.css');?>
<div class="sidebar"> 
<h1>Какие товары вам интересны?</h1>
	<nav class="menu-sidebar">
		<ul>
		<?
		function fun_2($val_pr){
				$fl[1]=false;
			switch ($val_pr) {
				case 436:
					$fl[0]=" class='gold'";$fl[1]=true;$fl[3]=99;
				break;
				case 437:
					$fl[0]=" class='bronze' ";$fl[1]=true;$fl[3]=100;
				break;
				case 438:
					$fl[0]=" class='silver' ";$fl[1]=true;$fl[3]=101;
				break;
		}
			return $fl;
		} 
		
		?> 
		<?foreach($arResult["ITEMS"] as $key=>$arItem):?>
		<?if($arItem["PROPERTY_TYPE"] == "N" ):?>
					<?
					if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
						continue;
					?>
					<?elseif(!empty($arItem["VALUES"]) && !isset($arItem["PRICE"])):?>
						<?	$kk=fun_2($arItem["ID"]);
							$val_coun_ar=count($arItem["VALUES"]);	
							if($kk[1]!=false){$val_coun_ar++;}
		                 if($val_coun_ar!=1){
					?>
					<li <? echo $kk[0]; ?> >			
							<?
							
							
							$url=$_SERVER['REQUEST_URI'];
							// удаляем путь до каталога;
							$del_ur=$APPLICATION->GetCurPage();
							$url=str_replace($del_ur,'',$url);
							//проверяем есть ли ?
							$findme   = '?';
							$pos = strpos($url, $findme);
							 
							if ($pos === false){$vopros='?';}else{
							// удаляем set_filter=Показать
							$del_ur='&set_filter=%D0%9F%D0%BE%D0%BA%D0%B0%D0%B7%D0%B0%D1%82%D1%8C';
							$url=str_replace($del_ur,'',$url);
							
							$vopros='';
							//удаляем все геты из строки по нашему фильтру
						    foreach($arItem["VALUES"] as $val => $ar):
							$temp=$ar["CONTROL_ID"];
							$del_ur= '&'.$temp.'=Y';
							$url=str_replace($del_ur,'',$url);
							endforeach;		
							}
							if($kk[1]==false){ ?>
							<a ><?=$arItem["NAME"]?><span id='xx_<?echo $arItem["ID"];?>'></span></a>
							<?}else{?>			
							<a  href='<?echo  $vopros.$url.'&'.$arItem["VALUES"][$kk[3]]["CONTROL_ID"]."=Y&set_filter=Показать";?>' ><?=$arItem["NAME"]?><span></span></a>
							<?}	
							if($kk[1]==false){ ?>
							<select size="1">	
							<?$ii=1?>
							<option kuku="<?echo $vopros.$url."&set_filter=Показать"; ?>">Все варианты</option>
						<?foreach($arItem["VALUES"] as $val => $ar):?>
						<?$get_pr=$_GET[$ar["CONTROL_ID"]];?>
							<option iii='<? echo $ii;?>' vbrsp="<? echo "xx_".$arItem["ID"];?>" mmm="<?=$ar["VALUE"];?>" yes_no="<? if($get_pr=="Y"){echo "Y";}else{ echo "N";} ?>" kuku='<?echo $vopros.$url.'&'.$ar["CONTROL_ID"]."=Y&set_filter=Показать"; ?>'><?echo $ar["VALUE"];?></option>
						<?$ii++;?>
						<?endforeach;?>				
						</select>
						<?}
						
						}?>
				<?endif;?>
					</li>
			<?endforeach;?>
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
				if(y_n=="Y"){$("#"+id_el).html(nam_val);}
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