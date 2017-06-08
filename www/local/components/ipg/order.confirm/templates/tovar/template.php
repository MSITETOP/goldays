<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script>
    var os = new OrderSync("<?=$arResult['AJAX_URL']?>");

    $(document).ready(function() {
        $("#try_now").on('click', function(e) {
            iClickType = 2;

            if (os.arList.length > 0)
                os.CheckAvailTovars();
            else
                $('#size-select').fadeIn(400).siblings('#overlay').fadeIn(400);

            e.preventDefault();
        });
    });
</script>
