<?php

class Pizza {
	private static $table = 'pizza';

	public static function f_list() {
		$table = static::$table;
		$query = "SELECT * FROM {$table}";

		return Request::exec(['query' => $query]);
	}
}
