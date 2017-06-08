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

<div id="popup-dx" style="display: none;    position: absolute;    top: 180px;    text-align: center;    width: 100%;    font-size: 20px;    color: red;">
    В данный момент эти товары меряют. Обратитесь к продавцу.
</div>
<script>
    

    $(document).ready(function() {
        $(document).off('click', '.try .button, .now-order');
        $(document).on('click', '.try .button, .now-order', function(e) {
            console.log($(this));
      		var os = new OrderSync("<?=$arResult['AJAX_URL']?>", "#item-template");
            
            //console.log(os);
		
            os.CheckAvailTovars2();


            e.preventDefault();
            return false;
        });
    });
</script>