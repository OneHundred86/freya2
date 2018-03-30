<?php

namespace App\Lib;


class CharacterAuth {
	protected static $map = [
		'User' => [
			'description' => '用户模块',
			'auths' => [
				'add' => '添加用户',
				'edit' => '修改用户',
				'del' => '删除用户',
			],
		],

		'UserGroup' => [
			'description' => '用户组模块',
			'auths' => [
				'add' => '添加用户组',
				'edit' => '修改用户组',
				'del' => '删除用户组',
			],
		],

		'Character' => [
			'description' => '角色模块',
			'auths' => [
				'add' => '添加角色',
				'edit' => '修改角色',
				'del' => '删除角色',
				'deployAuth' => '配置角色权限',
			],
		],

		// 用于控制web侧边栏的显示
		'Sidebar' => [
			'description' => 'web侧边栏显示控制模块',
			'auths' => [
				'adminmain' => '系统概述页',
				'adminuser' => '用户管理页',
				'adminusergroup' => '用户组管理页',
				'admincharacter' => '角色定义页'
			],
		],
	];

	private static $all;

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
		foreach (self::$map as $group => $info) {
			foreach ($info['auths'] as $k => $v) {
				$auth = sprintf('%s.%s', $group, $k);
				$auths[$auth] = $v;
			}
		}
		self::$all = $auths;
		return self::$all;
	}

	// $authName = sprintf('%s.%s', $group, $authKey);
	public static function has(string $auth) {
		$all = self::all();
		return array_key_exists($auth, $all);
	}

}