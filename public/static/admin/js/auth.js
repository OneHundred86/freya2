$(function(){

	var tpl = ui('#tpl');

	var caList = ui('#ca-list', {
		extend : {
			refresh : function(){
				caList.loading(true);
				G.call('auth.listCA', function(c, d){
					caList.loading(false);
					caList.$.empty();
					var ignored = {};
					d.ignored.forEach(function(x){
						if(!(x.controller in ignored)){
							ignored[x.controller] = {};
						}
						ignored[x.controller][x.action] = true;
					});
					caList.ignored = ignored;
					var lastController = '';
					d.list.forEach(function(x){
						if(x.controller != lastController){
							lastController = x.controller;
							caList.addController(x);
						}
						caList.add(x);
					});
				}, function(c, m){
					caList.loading(false);
					G.error(m);
				});
			},
			addController : function(d){
				var e = tpl.dwCItem.clone();
				e.tData = d;
				e.dwC.dwText.innerHTML = d.controller;
				e.dwDesc.dwText.innerHTML = d.controller_desc;
				ui(e.dwSelAll, {
					click : function(){
						var $r = $(e).next();

						while(ui.checkDataSet($r[0],'node') == 'dwCAItem'){
							$r[0].ddIgnored.toggle();
							$r = $r.next();
						}
					}
				});
				caList.$.append(e);
				return e;
			},
			add : function(d){
				var e = tpl.dwCAItem.clone();
				e.tData = d;
				e.dwC.dwText.innerHTML = d.controller;
				e.dwA.dwText.innerHTML = d.action;
				e.dwDesc.dwText.innerHTML = d.action_desc;
				e.ddIgnored = ui(e.dwOp.dwIgnore, {
					checked : caList.ignored[d.controller] && caList.ignored[d.controller][d.action],
					toggle : function(v){
						if(v){
							caList.loading(true);
							G.call('auth.addCAIgnore', {
								controller : d.controller,
								action     : d.action
							}, function(c, d){
								caList.loading(false);

							}, function(c, m){
								caList.loading(false);
								e.ddIgnored.val(!v);
								G.error(m);
							});
						}else{
							caList.loading(true);
							G.call('auth.delCAIgnore', {
								controller : d.controller,
								action     : d.action
							}, function(c, d){
								caList.loading(false);

							}, function(c, m){
								caList.loading(false);
								e.ddIgnored.val(!v);
								G.error(m);
							});
						}
					}				
				});
				caList.$.append(e);
				return e;
			}
		}
	});

	var btnFresh = ui('#btn-refresh', {
		click : function(){
			caList.refresh();
		}
	});

	caList.refresh();


});