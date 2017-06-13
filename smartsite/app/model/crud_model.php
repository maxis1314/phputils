<?php
class crud_model extends model {
	function get_check_filter() {
		return array (

			'varchar1' => array (
				array (
					'method' => 'length',
					'max' => 45,
					'min' => 3,
					'msg' => '長さは3~45です'
				),
				array (
					"method" => "notnull",
					"msg" => '空白です'
				)
			),

			'int1' => array (
				array (
					'method' => 'int',
					'msg' => '整数じゃありません'
				),
				array (
					"method" => "notnull",
					"msg" => '空白です'
				)
			),

			'float1' => array (),

			'double1' => array (),

			'text1' => array (
				array (
					'method' => 'length',
					'max' => 5000,
					'min' => 10,
					'msg' => '長さは10~5000です'
				),
				array (
					"method" => "notnull",
					"msg" => '空白です'
				)
			),

			'blob1' => array (
				array (
					'method' => 'length',
					'max' => 5000,
					'min' => 10,
					'msg' => '長さは10~5000です'
				),
				array (
					"method" => "notnull",
					"msg" => '空白です'
				)
			),

			'bolean1' => array (
				"method" => "include",
				"in" => array(0,1),
				'msg' => '0か1を入力してください'
			),

			'tinyint1' => array (
				array (
					'method' => 'range',
					'max' => 255,
					'min' => 0,
					'msg' => '0~255の間の数字を入力してください'
				),
				array (
					"method" => "notnull",
					"msg" => '空白です'
				)
			),

			'id' => array (
				array (
					'method' => 'int'
				)
			)
		);
	}
}
?>
