var EJS = function(src){
    if(typeof src == 'string'){
        this.compile(src);
    }
};

EJS.prototype = {
    regexp: /(?:\n\s*)?({%[=]?)((?:[^%]|[%][^}])+)%}/gm,
    helper: {},
    cached: {},
    render: function(data){
        if(this.method instanceof Function){
            try{
                return this.method('', this.parsed, this.helper, data);
            }catch(e){
                this.error = new EJS.RenderError(e.message);
            }
        }
        return this.error;
    },
    compile: function(src){
        delete this.method;
        delete this.error;
        var p = src.split(this.regexp), r = [], i, o;
        this.parsed = p;
        for(i = 0; i < p.length; i++){
            if(p[i] == '{%'){
                o = p[++i];
            }else{
                if(p[i] == '{%='){
                    o = p[++i];
                }else{
                    o = 'arguments[1][' + i + ']';
                }
                o = 'arguments[0]+=' + o + ';';
            }
            r.push(o);
        }
        r.unshift('this.method=function(){'+
            'with(arguments[2]){'+
            'with(arguments[3]){');
        r.push('};};return arguments[0];};');
        try{
            eval(r.join('\n'));
            return true;
        }catch(e){
            if(typeof this.check == 'function'){
                e = this.check(r);
            }
            this.error = new EJS.CompileError(e.message);
            return this.error;
        }
    }
};

EJS.CompileError = function(message){
    if(typeof message == 'string'){
        this.message = message;
    }
};
EJS.CompileError.prototype = new Error();
EJS.CompileError.prototype.name = 'EJS.CompileError';

EJS.RenderError = function(message){
    if(typeof message == 'string'){
        this.message = message;
    }
};
EJS.RenderError.prototype = new Error();
EJS.RenderError.prototype.name = 'EJS.RenderError';

EJS.Helper = function(name, func){
    if(arguments.length < 2){
        return EJS.prototype.helper[name];
    }
    if(func === null){
        delete EJS.prototype.helper[name];
        return;
    }
    if(typeof func == 'function'){
        EJS.prototype.helper[name] = func;
        return true;
    }
};

EJS.Helper('img_tag', function(src, alt){
    return src ? '<img src="' + src + '"' +
        (alt ? ' alt="' + alt + '"' : '') + '/>' : '';
});
EJS.Helper('link_to', function(title, href){
    return title && href ?
        '<a href="' + href + '">' + title + '</a>' : '';
});

function OrderSync(sAjaxDir, template) {
    var me = this;
    this.debug = false;
    this.sAjaxDir = sAjaxDir;
    this.template = template;
    this.arList = [];

    this.getTovarList = function() {
        var arList = [];

        $("input[data-cart='y']").each(function() {
            var $this = $(this);
            arList.push({
                xmlid: $this.attr("data-xmlid"),
                price: $this.attr("data-price"),
                name: $this.attr("data-name"),
                desc: $this.attr("data-desc"),
                img: $this.attr("data-img")
            })
        });

        return arList;
    };

    this.CheckAvailTovars2 = function() {
       
        var list = [];
        for (var i in this.arList) {
            list.push({xmlid: this.arList[i].xmlid});
        }

        this.SendAjax({action: "status", list: list}, this.ResultCardinal);
    };

    this.CheckAvailTovars = function() {
       
        var list = [];
        for (var i in this.arList) {
            list.push({xmlid: this.arList[i].xmlid});
        }

        this.SendAjax({action: "status", list: list}, this.ResultCardinal);
    };

    this.SendAjax = function(params, callback) {
        var that = this;

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
        var $basket = $("input[data-cart-basket='y']");
        var list = [];

        for (var i in me.arList) {
            if (me.arList[i].avail == 1) {
                list.push(me.arList[i]);
            }
        }

        if (list.length == 0) {
            if (this.debug)
                console.error("Все товары недоступны к заказу");

            return false;
        }

        var params = {
            action:"order",
            list: list,
            basket: {
                price: $basket.attr("data-price"),
                discount: $basket.attr("data-discount")
            }
        };

        //console.log("SendOrder: ");
        if (this.debug)
            console.log(params);

        this.SendAjax(params, this.GotoCompletePage);
    };

    this.GotoCompletePage = function(data) {
        if (data == 1) {
            window.location="/basket/complete.php";
        } else {
            alert("Возникла ошибка, пожалуйста подойдите к окну продавца-консультанта.");
        }
    };

    this.ResultCardinal = function(data) {
        //console.log("Check result: ");
        if (this.debug)
            console.log(data);

        for (var i in me.arList) {
            me.arList[i].avail = data[i];
        }

        for (var i in me.arList) {
            if (me.arList[i].avail == 0) {
                me.ShowDialog();
                return;
            }
        }

        me.SendOrder();
        //me.GotoCompletePage(1);
    };

    this.ShowDialog = function() {
        var oEJS = new EJS($(this.template).html());

        $("div.items").empty();

        var AvailExists = false;

        for (var i in me.arList) {
            if (me.arList[i].avail == 1) {
                AvailExists = true;
                continue;
            }

            params = me.arList[i];
console.log(html);
            var html = oEJS.render(params);
            $("div.items").prepend(html);
        }

        // Если хоть один товар доступен к заказу, то предлагаем примерку, иначе перейти в каталог

        if (AvailExists) {
            $("#popup-dx a.take-other").html("Примерить другие отложенные мной товары");
            $("#popup-dx a.take-other").attr("href", "#");
            $("#popup-dx .take-other").on('click', this.FittingSendOrderAnimate);
        } else {
            $("#popup-dx .take-other").unbind('click', this.FittingSendOrderAnimate);
            $("#popup-dx a.take-other").html("Вернуться в каталог");
            $("#popup-dx a.take-other").attr("href", "/");
        }

        $("#alpha,#popup-dx").show(500);
    };

    this.FittingSendOrderAnimate = function(e) {
        me.SendOrder();

        $("#alpha,#popup-dx").hide(200);
        e.preventDefault();
    };

    this.arList = this.getTovarList();

    if (this.debug)
        console.log(this.arList);
}
