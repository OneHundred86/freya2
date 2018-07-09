<?php

/*
管理员角色权限配置
*/

return [
  'User' => [
    'description' => '用户模块',
    'auths' => [
      'add' => [
        'desc' => '添加用户',
        'route' => '/admin/user/add',
      ],
      'edit' => [
        'desc' => '修改用户',
        'route' => '/admin/user/edit',
      ],
      'del' => [
        'desc' => '删除用户',
        'route' => '/admin/user/del',
      ],
    ],
  ],

  'UserGroup' => [
    'description' => '用户组模块',
    'auths' => [
      'add' => [
        'desc' => '添加用户组',
        'route' => '/admin/usergroup/add',
      ],
      'edit' => [
        'desc' => '修改用户组',
        'route' => '/admin/usergroup/edit',
      ],
      'del' => [
        'desc' => '删除用户组',
        'route' => '/admin/usergroup/del',
      ],
    ],
  ],

  'Character' => [
    'description' => '角色模块',
    'auths' => [
      'add' => [
        'desc' => '添加角色',
        'route' => '/admin/character/add',
      ],
      'edit' => [
        'desc' => '修改角色',
        'route' => '/admin/character/edit',
      ],
      'del' => [
        'desc' => '删除角色',
        'route' => '/admin/character/del',
      ],
      'addCharacterAuth' => [
        'desc' => '给角色添加权限',
        'route' => '/admin/character/auth/add',
      ],
      'delCharacterAuth' => [
        'desc' => '给角色删除权限',
        'route' => '/admin/character/auth/del',
      ],
    ],
  ],

  // 用于控制web侧边栏的显示
  'Sidebar' => [
    'description' => 'web侧边栏显示控制模块',
    'auths' => [
      'adminmain' => [
       'desc' => '系统概述页',
       'route' => '/admin/main',
      ],
      'adminuser' => [
        'desc' => '用户管理页',
        'route' => '/admin/user',
      ],
      'adminusergroup' => [
        'desc' => '用户组管理页',
        'route' => '/admin/usergroup',
      ],
      'admincharacter' => [
        'desc' => '角色定义页',
        'route' => '/admin/character',
      ],
    ],
  ],
  
];