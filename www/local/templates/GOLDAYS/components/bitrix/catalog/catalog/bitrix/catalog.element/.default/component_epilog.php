<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
global $APPLICATION;
if (isset($templateData['TEMPLATE_THEME']))
{
	$APPLICATION->SetAdditionalCSS($templateData['TEMPLATE_THEME']);
}
if (isset($templateData['JS_OBJ']))
{
?>
<script type="text/javascript">
BX.ready(
	BX.defer(function(){
		if (!!window.<? echo $templateData['JS_OBJ']; ?>)
		{
			window.<? echo $templateData['JS_OBJ']; ?>.allowViewedCount(true);
		}
	})
);
</script>
<?
}
?>

<?

$str_ids = "";
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
        array("ID", "PRODUCT_ID")
    );
while ($arItems = $dbBasketItems->Fetch())
{
	$str_ids .= $arItems["PRODUCT_ID"].",";
}

$str_ids = substr($str_ids, 0,-1);
?>

<script type="text/javascript">
	var deleteItem = 0;
	var basketIds = [<?=$str_ids;?>];

	function showDeleteButton(id){
		console.log(basketIds);
		if(basketIds.indexOf(parseInt(id)) != -1){
			$('#delete_button').show();
			deleteItem = id;
		}else{
			$('#delete_button').hide();
			deleteItem = 0;
		}
	}

	$(document).ready(function(){
		$(document).on('click', '#delete_button', function(){
			if(deleteItem > 0){
				
				$.ajax({
				  url: '/basket/delete.php?id='+deleteItem,
				  success: function(data){
				  	if(data.SUCCESS){
				  		
					    $('#delete_button').hide();
						
						for(var i in basketIds){
							if(basketIds[i] == deleteItem){
								basketIds.splice(i,1);
							}
						}
						deleteItem = 0;
						$('#small_basket').html(data.BASKET_HTML);
						smallBasket3Count();
					}
				  }
				});
			}
		});
	});

	
</script>