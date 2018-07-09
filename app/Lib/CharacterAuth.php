<?php

namespace App\Lib;


class CharacterAuth {

	private static $all;
	private static $all_route2Auth;

	public function __construct() {
		# code...
	}

	public static function map() {
		return config('characterAuth');
	}

	public static function all() {
		if (self::$all)
			return self::$all;

		$auths = [];
		foreach (self::map() as $module => $info) {
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

