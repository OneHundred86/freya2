<?php

namespace App\Lib;


class CharacterAuth {
	protected static $map = [
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

	private static $all;
	private static $all_route2Auth;

	public function __construct() {
		# code...
	}

	public static function map() {
		return self::$map;
	}

	public static function all() {
		if (self::$all)
			return self::$all;

		$auths = [];
		foreach (self::$map as $module => $info) {
			foreach ($info['auths'] as $k => $v) {
				$auth = sprintf('%s.%s', $module, $k);
				$auths[$auth] = $v;
			}
		}
		self::$all = $auths;
		return self::$all;
	}

	// $auth = sprintf('%s.%s', $module, $authKey);
	# => true | false
	public static function has(string $auth) {
		$all = self::all();
		return array_key_exists($auth, $all);
	}

	protected static function all_route2Auth(){
		if(self::$all_route2Auth)
			return self::$all_route2Auth;

		$all = self::all();

		$arr = [];
		foreach($all as $auth => $v){
			$route = trim($v['route'], '/');
			$arr[$route] = $auth;
		}

		self::$all_route2Auth = $arr;
		return self::$all_route2Auth;
	}

	# => false | $auth :: sprintf('%s.%s', $module, $authKey);
	public static function getAuthByRoute(string $route){
		$route = trim($route, '/');
		$all_route2Auth = self::all_route2Auth();

		if(array_key_exists($route, $all_route2Auth))
			return $all_route2Auth[$route];

		return false;
	}

}

