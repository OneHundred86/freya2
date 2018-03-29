$(function(){

	var passwordModifyFrame = ui('#password-modify-frame', {
		extend : {
			close : ui('#wf-close-pmf'),
			oldpass : ui('#ipt-pmf-oldpass'),
			newpass : ui('#ipt-pmf-newpass'),
			cfmpass : ui('#ipt-pmf-cfmpass'),
			btnCancel  : ui('#btn-pmf-cancel', {
				click : function(){
					passwordModifyFrame.hide();
				}
			}),
			btnDone    : ui('#btn-pmf-done', {
				click : function(){
					var oldpass = passwordModifyFrame.oldpass.val();
					var newpass = passwordModifyFrame.newpass.val();
					var cfmpass = passwordModifyFrame.cfmpass.val();
					if(!oldpass.length || !newpass.length || !cfmpass.length){
						passwordModifyFrame.tipsResult.show('请输入密码');
						return;
					}
					if(newpass !== cfmpass){
						passwordModifyFrame.tipsResult.show('两次输入的密码不一致');
						return;
					}

					if(newpass.length < 6 || newpass.length > 18) {
                        passwordModifyFrame.tipsResult.show('密码必须是6-18位');
                        return;
					}

					passwordModifyFrame.tipsResult.show('');
					passwordModifyFrame.btnDone.loading(true);
					G.call('/admin/user/modifyPass', {
						old : MD5(oldpass),
						new : MD5(newpass)
					}, function(){
						passwordModifyFrame.btnDone.loading(false);
						passwordModifyFrame.hide();
					}, function(c, m){
						passwordModifyFrame.btnDone.loading(false);
						passwordModifyFrame.tipsResult.show(m);
					});
				}
			}),
			tipsResult : ui('#tips-pmf-result', {
				extend : {
					show : function(text){
						this.$.html(text);
					}
				}
			}),
			show : function(){
				ui.showFrameMask();
				setTimeout(function(){
					passwordModifyFrame.$.fadeIn(200);
				}, 200);
			},
			hide : function(){
				ui.hideFrameMask();
				passwordModifyFrame.$.hide();
			}
		}
	});

	passwordModifyFrame.$.appendTo($('body'));
	passwordModifyFrame.close.$.click(function(){
		passwordModifyFrame.hide();
	});
	$('#ank-passwd').click(function(){
		passwordModifyFrame.show();
	});

});