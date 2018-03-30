$(function () {

    var tpl = ui('#tpl');

    var characterList = ui('#character-list', {
        extend: {
            selected: 0,
            refresh: function () {
                loading(true);
                G.call('/admin/character/list', {
                    offset: 0,
                    limit: 1000
                }, function (c, d) {
                    loading(false);
                    characterList.$.empty();
                    characterList.map = {};
                    d.list.forEach(function (x) {
                        characterList.map[x.id] = characterList.add(x);
                        if (characterList.selected == 0 && d.list.length) {
                            characterList.selected = x.id;
                        }
                    });
                    characterList.select(characterList.selected);
                }, function (c, m) {
                    loading(false);
                    G.error(m);
                });
            },
            add: function (d) {
                var e = tpl.dwCharacterItem.clone();
                e.tData = d;
                e.dwName.innerHTML = d.name;
                characterList.$.append(e);
                return e;
            },
            select: function (id) {
                if (characterList.selected && characterList.map[characterList.selected]) {
                    $(characterList.map[characterList.selected]).removeClass('selected');
                }
                characterList.selected = id;
                $(characterList.map[id]).addClass('selected');
                caList.refresh(id);
            }
        }
    });
    characterList.$.on('click', '.item', function () {
        characterList.select(this.tData.id);
    });

    var caList = ui('#ca-list', {
        extend: {
            refresh: function (cid) {
                caList.loading(true);
                caList.cid = cid;
                if (caList.cacheMap) {
                    caList.map = JSON.parse(caList.cacheMap);
                    caList.$.empty();
                    caList.characterAuthById(cid);
                    return;
                }
                G.call('/admin/character/auth/all', {}, function (c, d) {
                    caList.map = {};
                    caList.domMap = {};

                    caList.$.empty();

                    $.each(d.list, function (key, val) {
                        var map = caList.map[key] = {};
                        map.description = val.description;
                        map.moduleName = key;
                        map.auths = {};
                        $.each(val.auths, function (auth, desc) {
                            map.auths[auth] = {auth: auth, desc: desc, real: key+'.'+auth};
                        })
                    });

                    caList.cacheMap = JSON.stringify(caList.map);

                    caList.characterAuthById(cid);

                }, function (c, m) {
                    caList.loading(false);
                    G.error(m);
                });
            },
            characterAuthById: function (cid) {
                G.call('/admin/character/auth/list', {
                    id: cid
                }, function (c, d) {
                    caList.loading(false);
                    d.list.forEach(function (val) {
                        val = val.split('.');
                        caList.map[val[0]].auths[val[1]].checked = true;
                    });
                    $.each(caList.map, function (auth, data) {
                        caList.addGroup(auth, data);
                    });
                }, function (c, m) {
                    caList.loading(false);
                    G.error(m);
                });
            },
            addGroup: function (auth, d) {
                var e = tpl.dwCAListGroup.clone();
                e.dwC.innerHTML = auth;
                e.dwDesc.innerHTML = d.description;
                e.tData = d;
                caList.$.append(e);
                var domMap = caList.domMap[auth] = {}
                $.each(d.auths, function (key, val) {
                    domMap[key] = caList.add(val);
                });
                return e;
            },
            add: function (d) {
                var e = tpl.dwCAListItem.clone();
                e.tData = d;
                e.dwC.innerHTML = d.auth;
                e.dwA.innerHTML = d.desc;
                e.ddToggle = ui(e.dwToggle, {
                    checked: d.checked,
                    toggle: function (v) {
                        d.checked = v;
                        var mt = '/admin/character/auth/add';
                        if (!v) {
                            mt = '/admin/character/auth/del';
                        }
                        G.call(mt, {
                            name: d.real,
                            id: caList.cid
                        }, function (c, d) {

                        }, function (c, m) {
                            G.error(m);
                        });
                    }
                });

                caList.$.append(e);
                return e;
            }
        }
    });
    caList.$.on('click', '.btn-all', function () {
        var controller = $(this).parent().parent()[0].tData;
        $.each(controller.auths, function (key, val) {
            if (!val.checked) {
                caList.domMap[controller.moduleName][key].ddToggle.toggle(true);
            }
        })

    }).on('click', '.btn-rev', function () {
        var controller = $(this).parent().parent()[0].tData;
        $.each(controller.auths, function (key, val) {
            caList.domMap[controller.moduleName][key].ddToggle.toggle();
        })
    });

    var btnAdd = ui('#btn-add', {
        click: function () {
            ui.prompt({
                text: '请输入角色名称',
                okCallback: function (v) {
                    loading(true);
                    G.call('/admin/character/add', {
                        name: v
                    }, function (c, d) {
                        loading(false);
                        characterList.refresh();
                    }, function (c, m) {
                        loading(false);
                        G.error(m);
                    })
                }
            });
        }
    });

    var $ctrlEdit = $('#ctrl-edit').click(function () {
        if (caList.cid == 0) {
            return;
        }
        ui.prompt({
            text: '请输入新的角色名称',
            value: characterList.map[caList.cid].tData.name,
            okCallback: function (v) {
                G.call('/admin/character/edit', {
                    id: caList.cid,
                    name: v
                }, function (c, d) {
                    characterList.refresh();
                }, function (c, m) {
                    G.error(m);
                });
            }
        });
    });
    var $ctrlRemove = $('#ctrl-remove').click(function () {
        if (caList.cid == 0) {
            return;
        }
        G.call('/admin/character/del', {
            id: caList.cid
        }, function (c, d) {
            characterList.selected = 0;
            characterList.refresh();
        }, function (c, m) {
            G.error(m);
        });
    });


    characterList.refresh();

    function loading(v) {
        characterList.loading(v);
        caList.loading(v);
    }

});