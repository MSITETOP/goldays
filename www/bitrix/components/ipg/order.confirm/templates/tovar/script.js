function OrderSync(sAjaxDir) {
    var me = this;
    this.debug = false;
    this.sAjaxDir = sAjaxDir;
    this.arList = [];

    this.CheckAvailTovars = function() {
        if (me.arList.length == 0)
            return;

        this.SendAjax({ action: "status", list: me.arList }, this.ResultCardinal);
    };

    this.SendAjax = function(params, callback) {
        var that = this;
        if (this.debug)
            console.log(params);

        $.ajax({
            url: this.sAjaxDir + "/ajax.php",
            type: 'GET',
            data: params,
            dataType: 'json',
            success: function(json) {
                callback(json);
            },
            error: function(e) {
                if (that.debug)
                    console.error(e.responseText);
            }
        });
    };

    this.SendOrder = function() {
        var params = {
            action:"order",
            list: me.arList,
            basket: {
                price: me.arList[0].price,
                discount: me.arList[0].discount
            }
        };

        this.SendAjax(params, this.GotoCompletePage);
    };

    this.GotoCompletePage = function(data) {
        if (data == 1) {
            window.location="/basket/complete.php";
        } else {
            me.ShowMessage("Возникла ошибка, пожалуйста подойдите к окну продавца-консультанта.");
        }
    };

    this.ShowMessage = function(text) {
        if($("h1").is("#okyey")) {
            $("#okyey").html(text);
        } else {
            $('#content').prepend("<h1 id='okyey'>" + text + "</h1>");
        }
    };

    this.ResultCardinal = function(data) {
        data = data[0];
        //data = 1; // test

        if (this.debug)
            console.log(data);

        if (data === 0) {
            me.ShowMessage("В данный момент этот товар меряют. Обратитесь к продавцу");
        } else if (data === 1) {
            me.SendOrder();
        }
    };

    var ChangeCounter = 0;

    BX.addCustomEvent("onCatalogStoreProductChange" , function(id){
        // первые два вызова пропускаем, они системные, а не выбор пользователя
        if (ChangeCounter < 2) {
            ChangeCounter++;
            return;
        }

        me.arList = [];

        var sCataogElementAreaId = $(".wrapper-item-slider").attr('id');
        if (sCataogElementAreaId.length == 0)
            return;

        var JCCE = window["ob" + sCataogElementAreaId];
        if (JCCE.offers == undefined)
            return;

        var oOffer = JCCE.offers[JCCE.offerNum];

        me.arList = [{
            id: oOffer.ID,
            price: oOffer.PRICE.DISCOUNT_VALUE,
            discount: oOffer.PRICE.DISCOUNT_DIFF
        }];
    });
}
