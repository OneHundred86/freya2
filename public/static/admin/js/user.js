$(function () {

    var tpl = ui('#tpl');

    var userList = ui('#user-list', {
        extend: {
            group: 0,
            refresh: function (group, page) {
                group = group === undefined ? userList.group : group;
                page = page || 1;
                var pageSize = 50;
                var offset = (page - 1) * pageSize;
                var args = {
                    group: group,
                    offset: offset,
                    limit: pageSize
                };
                var url = '/admin/user/list';
                userList.loading(true);
                if (group < 0) {
                    args = {
                        kw: iptSearch.val(),
                        offset: offset,
                        limit: pageSize
                    };
                    url = '/admin/user/list';
                }
                G.call(url, args, function (c, d) {
                    userList.group = group;
                    userList.loading(false);
                    userList.$.empty();
                    d.list.forEach(function (x) {
                        userList.add(x);
                    });
                    spUserList.refresh(Math.ceil(d.total / pageSize), page)
                }, function (c, m) {
                    userList.loading(false);
                    G.error(m);
                });
            },
            add: function (x) {
                var e = tpl.dwUserItem.clone();
                e.ddPassword = ui(e.dwEditFrame.dwRowPassword.dwTB);
                e.ddGroup = ui(e.dwEditFrame.dwRowGroup.dwSel);

                e.refresh = function (d) {
                    e.tData = d;
                    e.dwId.innerHTML = '#' + d.id;
                    e.dwUserName.innerHTML = d.email;
                    e.dwGroup.innerHTML = groupList.map[d.group] ? groupList.map[d.group].name : '-';
                    if (d.ban == 1) {
                        $(e.dwCtrl.dwBan).addClass('actived');
                    } else {
                        $(e.dwCtrl.dwBan).removeClass('actived');
                    }

                    e.ddPassword.val('');
                    e.ddGroup.val(d.group);

                    e.dwEditFrame.dwRowRegDate.dwText.innerHTML = d.created_at;
                };
                e.showEditFrame = function () {
                    $(e.dwEditFrame).show(200);
                };
                e.hideEditFrame = function () {
                    $(e.dwEditFrame).hide(200);
                };
                e.refresh(x);
                userList.element.appendChild(e);
            }
        }
    });
    userList.$.on('click', '.ctrl-item', function () {
        var $p = $(this).parents('.item');
        var p = $p[0];
        var td = p.tData;
        var t;
        var action = ui.checkDataSet(this, 'action')
        switch (action) {
            case 'edit':
                p.showEditFrame();
                p.ddGroup.select(parseInt(td.group)).resetOptions(groupList.selMap);
                break;
            case 'move':
                ui.select({
                    text: '要移动到哪个分组？',
                    options: groupList.selMap,
                    okCallback: function (v) {
                        G.call('/admin/user/changeGroup', {
                            group: v,
                            id: td.id
                        }, function (c, d) {
                            userList.loading(false);
                            userList.refresh();
                        }, function (c, m) {
                            userList.loading(false);
                            G.error(m);
                        });
                    }
                });
                break;
            case 'ban':
                userList.loading(true);
                G.call('/admin/user/ban', {
                    id: td.id,
                    ban: td.ban == 1 ? 0 : 1
                }, function (c, d) {
                    userList.loading(false);
                    td.ban = td.ban == 1 ? 0 : 1;
                    p.refresh(td);
                }, function (c, m) {
                    userList.loading(false);
                    G.error(m);
                });
                break;
            case 'remove':
                ui.confirm({
                    text: '确定要删除邮箱为“' + td.email + '”的用户吗？',
                    okCallback: function () {
                        userList.loading(true);
                        G.call('/admin/user/del', {
                            id: td.id
                        }, function (c, d) {
                            userList.loading(false);
                            $p.remove();
                        }, function (c, m) {
                            userList.loading(false);
                            G.error(m);
                        });
                    }
                });
            case 'fold':
                p.hideEditFrame();
                break;
            case 'save':
                if (!p.ddPassword.val().length) {
                    ui.alert('密码不能为空');
                    return;
                }
                userList.loading(true);
                G.call('/admin/user/edit', {
                    group: p.ddGroup.val(),
                    password: MD5(p.ddPassword.val()),
                    id: td.id
                }, function (c, d) {
                    userList.loading(false);
                    td.group = p.ddGroup.val();
                    p.refresh(td);
                    ui.notify('已保存');
                }, function (c, m) {
                    userList.loading(false);
                    G.error(m);
                });
                break;
        }
    });


    var spUserList = ui('#sp-user-list', {
        gotoPage: function (n) {
            userList.refresh(userList.group, n);
        }
    });
    var groupList = ui('#group-list', {
        extend: {
            refresh: function () {
                groupList.loading(true);
                G.call('/admin/usergroup/list', {offset: 0, limit: 1000}, function (c, d) {
                    groupList.loading(false);
                    var list = [{
                        id: 0,
                        name: '所有用户',
                        char_list: null,
                        parent: 0,
                        sub: []
                    }];
                    var map = {0: list[0]};
                    var selMap = {0: list[0].name};
                    d.list.forEach(function (x) {
                        x.id = parseInt(x.id);
                        x.parent = 0;
                        x.sub = [];
                        map[x.id] = x;
                        selMap[x.id] = x.name;
                    });
                    d.list.forEach(function (x) {
                        if (x.parent === 0) {
                            list.push(x);
                        } else {
                            if (x.parent in map) {
                                map[x.parent].sub.push(x);
                            }
                        }
                    });
                    groupList.map = map;
                    groupList.selMap = selMap;
                    list.forEach(function (x) {
                        groupList.add(x, 0);
                    });
                    groupList.select(userList.group);
                    selAddGroup.resetOptions(selMap).select(0);
                }, function (c, m) {
                    groupList.loading(false);
                    G.error(m);
                });
            },
            add: function (d, lv) {
                var e = tpl.dwGroupItem.clone();
                e.tData = d;
                e.dwName.innerHTML = d.name;
                e.className += ' l' + lv;
                groupList.element.appendChild(e);
                groupList.map[d.id].element = e;
                if (d.sub.length) {
                    d.sub.forEach(function (x) {
                        groupList.add(x, lv + 1);
                    });
                }
                return e;
            },
            select: function (id) {
                var it = groupList.map[id];
                groupList.$.find('.item').removeClass('selected');
                if (id >= 0) {
                    if (groupList.map[id]) {
                        groupList.map[id].element.className += ' selected';
                    }
                } else {
                    groupList.$.find('.item.search').addClass('selected');
                }
                userList.refresh(id);
            }
        }
    });
    groupList.$.on('click', '.item', function () {
        if (this.tData) {
            groupList.select(this.tData.id);
        } else if ($(this).hasClass('search')) {
            groupList.select(-1);
        }
    });

    var iptAddAccName = ui('#ipt-add-accname', {});
    var iptAddCellphone = ui('#ipt-add-cellphone', {});
    var iptAddUserName = ui('#ipt-add-username', {
        limit: 30
    });
    var iptAddPassword = ui('#ipt-add-password', {});
    var iptAddEmail = ui('#ipt-add-email', {
        limit: 200
    });
    var selAddGroup = ui('#sel-add-group').val(0);

    var addFrame = ui('#add-frame', {});
    var btnRefresh = ui('#btn-refresh', {
        click: function () {
            userList.refresh();
        }
    });
    var btnAdd = ui('#btn-add', {
        click: function () {
            addFrame.$.toggle(200);
        }
    });
    var btnAddFold = ui('#btn-add-fold', {
        click: function () {
            addFrame.$.slideUp();
        }
    });
    var btnAddClear = ui('#btn-add-clear', {
        click: function () {
            clearFrame();
        }
    });
    var btnAddSave = ui('#btn-add-save', {
        click: function () {
            var password = iptAddPassword.val();
            var email = iptAddEmail.val();
            var group = selAddGroup.val();

            if (!password.length) {
                ui.alert('密码不能为空');
                return;
            }
            if (!email.length) {
                ui.alert('邮箱不能为空');
                return;
            }
            var emailCheck = ui.CHECK_RULE.EMAIL(email);
            if (typeof  emailCheck === 'string') {
               ui.alert(emailCheck);
                return;
            }

            addFrame.loading(true);
            G.call('/admin/user/add', {
                password: MD5(password),
                email: email,
                group: group
            }, function (c, d) {
                addFrame.loading(false);
                ui.notify('已添加');
                userList.refresh();
                clearFrame();
            }, function (c, m) {
                addFrame.loading(false);
                ui.alert(m);
            });
        }
    });

    var iptSearch = ui('#ipt-search', {
        onenter: function () {
            search();
        }
    });

    var btnSearch = ui('#btn-search', {
        click: function () {
            search();
        }
    });

    function search() {
        groupList.select(-1);
    }

    function clearFrame() {
        iptAddPassword.val('');
        iptAddEmail.val('');
        selAddGroup.val(0);
    }

    groupList.refresh();
});