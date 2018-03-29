$(function(){

	var adminMenu = ui('#admin-menu');
	adminMenu.$.on('click', '.hd', function(){
		$(this).parent().toggleClass('folded');
	}).find('.item,.group.single').each(function(){
		var c = ui.checkDataSet(this, 'c');
		var a = ui.checkDataSet(this, 'a');
		var pathName = window.location.href;
		if(!this.href){
			this.href = '/' + c + '/' + a;
		}
		if(pathName === this.href){
			$(this).addClass('selected');
		}
	});


	$('.header.logined').find('a.navi').each(function (idx, val) {
		var c = ui.checkDataSet(this,'c');
        var a = ui.checkDataSet(this,'a');
        if(!this.href){
            this.href = '/' + c + '/' + a;
        }
    });

	G.call('/admin/user/info',{}, function (c,d) {
		$('#header-email').html(d.email);
		$('#account-setting-email').html(d.email);
    }, function (c,m) {
        G.error('获取用户信息失败');
    })


});