var C = {
    webSocketAccept : function(){
        return 'marnode';
    },
    webSocketServer : function(){
        return 'ws://' + document.domain + ':8080';
    },
    basePath : function(){
        if('_WEBSITE_URL_ROOT' in window){
            return window._WEBSITE_URL_ROOT;
        }
        return document.location.href.replace(/\/[^\/]+$/, '');
    },
    postEditURL : function(id,type){
        return C.basePath() + '/?c=post&a=edit&id=' + id+'&type='+type;
    },
    gotoUserManager : function(){
        return C.basePath() + '/?c=admin&a=user';
    },
    staticPath : function(){
        return C.basePath() + '/static';
    },
    modURL : function(c, a){
        return C.basePath() + '/?c=' + c + '&a=' + a;
    },
    methodURL : function(url){
        return C.basePath() + '/method.php?m=' + url;
    },
    jsonpURL : function(url){
        return C.basePath() + '/jsonp.php?m=' + url;
    },
    timeStr : function(timestamp, withsec){
        var ec = new Date(),
            et = new Date(timestamp * 1000);
        var yc = ec.getFullYear(), yt = et.getFullYear(),
            mc = ec.getMonth() + 1, mt = et.getMonth() + 1,
            dc = ec.getDate(), dt = et.getDate();
        var s = '';
        function f(x){ return x < 10 ? '0' + x : x; }
        switch(true){
            case yc == yt && mc == mt && dc == dt:
                s = '今天';
                break;
            case yc == yt && mc == mt && dc - dt == 1:
                s = '昨天';
                break;
            case yc == yt && mc == mt && dc - dt == 2:
                s = '前天';
                break;
            case ec.getTime() / 1000 - timestamp <= 86400 * 7:
                s = LANG.WEEKDAY[et.getDay()];
                break;
            case yc == yt:
                s = f(mt) + '月' + f(dt) + '日';
                break;
            default:
                s = yt + '年' + f(mt) + '月' + f(dt) + '日';
                break;
        }
        return s + ' ' + f(et.getHours()) + ':' + f(et.getMinutes()) + (withsec ? (":" + f(et.getSeconds())) : "");
    },
    mpResImg : function(data, thumb){
        var date = new Date(data.time * 1000);
        var m = date.getMonth() + 1;
        var d = date.getDate();
        if(m < 10){
            m = "0" + m;
        }
        if(d < 10){
            d = "0" + d;
        }
        return C.basePath() + '/data/mp_res/img/' + 
                                data.mid + '/' + 
                                date.getFullYear() + m + d + '/' + 
                                data.id + '.' + data.type + (thumb ? '.tmb.jpg' : '');
    },
    mpResVoc : function(data){
        var date = new Date(data.time * 1000);
        var m = date.getMonth() + 1;
        var d = date.getDate();
        if(m < 10){
            m = "0" + m;
        }
        if(d < 10){
            d = "0" + d;
        }
        return './data/mp_res/voc/' + 
                                data.mid + '/' + 
                                date.getFullYear() + m + d + '/' + 
                                data.id + '.' + data.type;
    },
    mpResVdo : function(data){
        var date = new Date(data.time * 1000);
        var m = date.getMonth() + 1;
        var d = date.getDate();
        if(m < 10){
            m = "0" + m;
        }
        if(d < 10){
            d = "0" + d;
        }
        return C.basePath() + '/data/mp_res/vdo/' + 
                                data.mid + '/' + 
                                date.getFullYear() + m + d + '/' + 
                                data.id + '.' + data.type;
    },
    mpResVdoThumb : function(data){
        var date = new Date(data.time * 1000);
        var m = date.getMonth() + 1;
        var d = date.getDate();
        if(m < 10){
            m = "0" + m;
        }
        if(d < 10){
            d = "0" + d;
        }
        return C.basePath() + '/data/mp_res/vdo_tmb/' + 
                                data.mid + '/' + 
                                date.getFullYear() + m + d + '/' + 
                                data.id + '.png';
    },
    mpResMusic : function(data){
        var date = new Date(data.time * 1000);
        var m = date.getMonth() + 1;
        var d = date.getDate();
        if(m < 10){
            m = "0" + m;
        }
        if(d < 10){
            d = "0" + d;
        }
        return C.basePath() + '/data/mp_res/music/' + 
                                data.mid + '/' + 
                                date.getFullYear() + m + d + '/' + 
                                data.id + '.' + data.type;
    },
    mpAvatar : function(mid){
        return './data/mp_avatar/' + mid + '.png';
    },
    readnewsURL : function(id){
        return C.basePath() + '/?c=readnews&id=' + id;
    },
    UEditorURL : function(){
        return C.basePath() + '/static/ueditor/';
    }
};

var LANG = {
    CONTENT_NOT_EMPTY : function(prefix){
        return prefix + '的内容不能为空';
    },
    CONTENT_LENGTH : function(prefix, from, to){
        return prefix + '的长度需为' + from + '~' + to + '位';
    },
    CONTENT_LENGTH_FIXED : function(prefix, length){
        return prefix + '的长度需为' + length + '位';
    },
    CONTENT_LENGTH_LEAST : function(prefix, length){
        return prefix + '的长度最少需为' + length + '位';
    },
    NEED_CORRECT_EMAIL : '请输入合法的email地址',
    ASK_SUBMITED : '提问已成功提交。',
    ANSWER_SUBMITED : '回答已提交。',
    WEEKDAY : ['周日', '周一', '周二', '周三', '周四', '周五', '周六', '周日'],
    CONTENT_TYPE : {
        image   : '图片',
        article : '图文消息',
        voice   : '语音',
        text    : '文本',
        video   : '视频'
    }
}

var KEYBOARD = {
    ENTER : 13
}