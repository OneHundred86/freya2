$(function(){

	var tpl = ui('#tpl');

	var groupList = ui('#group-list', {
		extend : {
			refresh : function(){
				groupList.loading(true);
				G.call('/admin/usergroup/list', {
					offset: 0,limit: 1000
				}, function(c, d){
					var map = {}, list = [];
					groupList.loading(false);
					groupList.$.empty();
					d.list.forEach(function(x){
						x.id         = parseInt(x.id);
						map[x.id]    = x;
					});
					d.list.forEach(function(x){
                        list.push(x);
					});
					groupList.map = map;
					groupList.list = list;
					list.forEach(function(x){
						groupList.add(x, 0);
					});
				}, function(c, m){
					groupList.loading(false);
					G.error(m);
				});
			},
			add : function(d, lv){
				var e = tpl.dwGroupItem.clone();
				e.tData = d;
				e.className += ' lv-' + lv;
				e.dwName.innerHTML = d.name;
				e.ddCharList = ui(e.dwPrivFrame.dwCharList, {
					extend : {
						refresh : function(){
							e.ddCharList.loading(true);
							G.call('/admin/usergroup/character/list', {
								id : d.id
							}, function(c, d){
								e.ddCharList.loading(false);
								e.ddCharList.$.empty();

								e.charList = {};
								d.list.forEach(function(x){
									e.charList[x.id] = x.name;
									e.ddCharList.add(x);
								});
							}, function(c, m){
								e.ddCharList.loading(false);
								G.error(m);
							});
						},
						add : function(d){
							var ei = tpl.dwCharItem.clone();
							ei.cid = d.id;
							ei.tData = d;
							ei.dwName.innerHTML = d.name;
							e.ddCharList.$.append(ei);
							return ei;
						}
					}
				});
				e.ddCharList.$.on('click', '.remove-char', function(){
					var cid = $(this).parents('.char-item')[0].cid;
					ui.confirm({
						text : '确定要删除这个角色吗？',
						okCallback : function(){
							G.call('/admin/usergroup/character/del', {
								id : d.id,
								character : cid
							}, function(c, d){
								e.refreshCharList();
							}, function(c, m){
								G.error(m);
							});
						}
					});
				});
				e.refreshCharList = function(){
					e.ddCharList.refresh();
				};
				groupList.$.append(e);

				return e;
			},
			updateChar : function(chars){
				groupList.charMap = {};
				chars.forEach(function(x){
					groupList.charMap[x.id] = x.name;
				});
			}
		}
	});

	groupList.$.on('click', '.ctrl-item', function(){
		var $p = $(this).parents('.item');
		var p  = $p[0];
		var td = p.tData;

		switch(this.dataset.action){
			case 'add':
				showAddUserGroup(td.id);
				break;
			case 'edit':
				ui.prompt({
					text  : '请输入新的用户组名称：',
					value : td.name,
					okCallback : function(v){
						G.call('/admin/usergroup/edit', {
							id   : td.id,
							name : v
						}, function(c, d){
							p.dwName.innerHTML = v;
							td.name = v;
						}, function(c, m){
							G.error(m);
						});
					}
				});
				break;
			case 'priv':
				if(p.isPrivShowed){
					p.isPrivShowed = false;
					$(p.dwPrivFrame).hide();
				}else{
					p.isPrivShowed = true;
					$(p.dwPrivFrame).show();
					p.refreshCharList();
				}
				break;
			case 'remove':
				ui.confirm({
					text : '确定要删除这个用户组吗？',
					okCallback : function(){
                        G.call('/admin/usergroup/del', {
                            id : td.id
                        }, function(c, d){
                            groupList.refresh();
                        }, function(c, m){
                            G.error(m);
                        });
					}
				});
				break;
			case 'addchar':
				showAddGroupCharacter(p);
				break;
		}
	});

	var btnAdd = ui('#btn-add', {
		click : function(){
			showAddUserGroup(0);
		}
	});

	groupList.refresh();

	function showAddUserGroup(){
		ui.prompt({
			text : '请输入新建的用户组名称：',
			okCallback : function(v){
				G.call('/admin/usergroup/add', {
					name   : v
				}, function(c, d){
					groupList.refresh();
				}, function(c, m){
					G.error(m);
				});
			}
		});
	}

	function showAddGroupCharacter(e){

        G.call('/admin/character/list', {
            offset: 0,
            limit: 1000
        }, function (c, d) {
        	var currentCharlist = e.charList;
            var map = {};

            console.log(e.charList);

            d.list.forEach(function (val) {
            	if (!e.charList[val.id]) {
                    map[val.id] = val.name;
				}
			});

            ui.select({
                text : '请选择要添加的角色',
                options : map,
                okCallback : function(v){
                    G.call('/admin/usergroup/character/add', {
                        id : e.tData.id,
                        character : v
                    }, function(c, d){
                        e.refreshCharList();
                    }, function(c, m){
                        G.error(m);
                    });
                }
            });
        }, function (c,m) {
			G.error(m);
        });

	}

});