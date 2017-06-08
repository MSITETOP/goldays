<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<script id="item-template" type="text/html">
    <div class="item">
        <span class="img">
            <img src="{%=img%}" alt="name" />
            <span class="price">
                от <b>{%=price%} Р</b>
            </span>
        </span>
        <div class="des">
            <span class="ttl">{%=name%}</span>
            <p>
                {%=desc%}
            </p>
        </div>
    </div>
</script>

<div id="alpha"></div>
<div id="popup-dx" style="display: none;">
    В данный момент эти товары меряют. Обратитесь к продавцу.
    <div class="items">
    </div>
    <div class="clr"></div>
    <a class="take-other" href="#">Примерить другие отложенные мной товары</a>
    <a class="back" href="#">Назад</a>
</div>
<script>
    

    $(document).ready(function() {
        $(document).on('click', '.try .button, .now-order', function(e) {
      		var os = new OrderSync("<?=$arResult['AJAX_URL']?>", "#item-template");
		
		console.log(os);
		
            os.CheckAvailTovars2();


            e.preventDefault();
        });
        $("#popup-dx .back").on('click', function(e) {
            $("#alpha,#popup-dx").hide(200);
            e.preventDefault();
        });
    });
</script>