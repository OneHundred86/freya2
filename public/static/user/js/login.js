$(function(){


	var tbEmail = ui('#tb-email', {
		check : [
			ui.CHECK_RULE.NOT_EMPTY,
            ui.CHECK_RULE.EMAIL
		],
		tip : '#tips-email',
		limit : 64,
		onenter : function(){
			login();
		}
	});

	var tbPassword = ui('#tb-password', {
		check : [
			ui.CHECK_RULE.NOT_EMPTY
		],
		tip : '#tips-password',
		onenter : function(){
			login();
		}
	});

	var tbVericode = ui('#tb-vericode', {
        check : [
            ui.CHECK_RULE.NOT_EMPTY
        ],
        tip : '#tips-login',
		onenter : function(){
			login();
		}
	});

	var tipsLogin  = ui('#tips-login');

	var toggleRemember = ui('#toggle-remember');

	var btnLogin   = ui('#btn-login', {
		click : function(){
			login();
		}
	});

	function login(){
		var email  = tbEmail.val();
			var password = MD5(tbPassword.val());
			var code     = tbVericode.val();
			var keep     = toggleRemember.val() ? 1 : 0;

			tipsLogin.hide();

			G.call('/admin/checkLogin', {
				email  : email,
				password : password,
				code : code,
			}, function(c, d){
				tipsLogin.ok('√');
				G.submit('/admin/login', {
					email  : email,
					password : password,
					code : code,
					keep : keep
				});
			}, function(c, m){
				tipsLogin.warn(m);
			});
	}

});