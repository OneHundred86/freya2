$(function () {

    var menuItems = {};
    var WEB_PRIX = 'Sidebar';

    var adminMenu = ui('#admin-menu');


    G.call('/admin/user/info', {}, function (c, d) {
        var info = d.info;
        $('#header-email').html(info.email);
        $('#account-setting-email').html(info.email);

        d.auths.forEach(function (auth) {
            if (auth.indexOf(WEB_PRIX) === 0) {
                for (var k in menuItems) {
                    if (k === auth) {
                        delete menuItems[k]
                    }
                }
            }
        });

        for (var k in menuItems) {
            if (menuItems[k].hasClass('selected')) {
                window.location.href = '/error/noauth';
            }
            menuItems[k].remove();
        }

        adminMenu.$.find('.group').each(function (idx, dom) {
            var $dom = $(dom);
            var len = $dom.find('.item').length;
            if (len === 0 && !$dom.hasClass('single')) {
                $dom.remove();
            }
        });
        adminMenu.$.fadeIn(200);
    }, function (c, m) {
        G.error('获取用户信息失败');
    });


    adminMenu.$.on('click', '.hd', function () {
        $(this).parent().toggleClass('folded');
    }).find('.item,.group.single').each(function () {
        var c = ui.checkDataSet(this, 'c');
        var a = ui.checkDataSet(this, 'a');
        var noAuth = ui.checkDataSet(this, 'noAuth');
        var pathName = window.location.href;
        if (!this.href) {
            this.href = '/' + c + '/' + a;
        }
        if (pathName === this.href) {
            $(this).addClass('selected');
        }
        if (noAuth !== '1') {
            var auth = WEB_PRIX + '.' + c + a;
            menuItems[auth] = $(this);
        }
    });


    $('.header.logined').find('a.navi').each(function (idx, val) {
        var c = ui.checkDataSet(this, 'c');
        var a = ui.checkDataSet(this, 'a');
        if (!this.href) {
            this.href = '/' + c + '/' + a;
        }
    });


});