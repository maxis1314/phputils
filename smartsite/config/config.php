<?php
define("RANDSTR", "gasgga3409sdhf");

	define("PREFIXURL", "");
	define("PREFIXNUM", 0);

//	define("PREFIXURL", "/self");
//	define("PREFIXNUM", 1);


$init_values = array (
	'default_controller' => 'quick',
	'default_action' => 'index'	
);

$short_action = array (
	"pub" => array (
		"error",
		"pub"
	),	
	'cms' => array (
		'cms',
		'dispatch'
	),
	'cms2' => array (
		'cms2',
		'dispatch'
	),
	'demo' => array (
		'demo',
		'dispatch'
	),
	'qiyedb' => array (
		'qiyedb',
		'dispatch'
	),
	'filecms' => array (
		'filecms',
		'dispatch'
	)
);

if (file_exists(ROOT . "../perl/setting.ini")) {
	$configini = parse_ini_file(ROOT . "../perl/setting.ini", true);
} else {
	$configini = parse_ini_file(ROOT . "config/setting.ini", true);
}

//db config
$configini['hasOne'] = array (
	//;table'='other table:select items:join statement	
	'courses' => array (
		array (
			'Name' => 'teachers'
		)
	),
	'students' => array (
		array (
			'Name' => 'users',
			'Join' => 'left join users on users.identity = "student" and users.identity_id=students.id'
		)
	),
	'teachers' => array (
		array (
			'Name' => 'users',
			'Join' => 'left join users on users.identity = "teacher" and users.identity_id=teachers.id'
		)
	),
	'users' => array (
		array (
			'Name' => 'students',
			'Join' => 'left join students on users.identity = "student" and users.identity_id=students.id'
		),
		array (
			'Name' => 'teachers',
			'Join' => 'left join teachers on users.identity = "teacher" and users.identity_id=teachers.id'
		)
	)
);
$configini['belongsTo'] = array (
	//;table:other table:select item:join statement
	'students' => array (
		array (
			'Name' => 'classes'
		)
	),
	'teachers' => array (
		array (
			'Name' => 'courses'
		),
		array (
			'Name' => 'classes'
		)
	),
	'course_student' => array (
		array (
			'Name' => 'students',
			
		),
		array (
			'Name' => 'courses'
		)
	)
);

$configini['hasMany'] = array (
	//;table'=array('other table:select item:other table's id	
	'classes' => array (
		array (
			'Name' => 'students'
		),
		array (
			'Name' => 'teachers'
		),
		array (
			'Name' => 'courses',
			'Join' => 'join course_student on courses.id=course_student.course_id join students on students.id=course_student.student_id',
			'InField' => 'students.class_id'
		)
	),
	'students'=>array(
		array(
			'Name'=>'course_student'			
		)
	),
	'courses'=>array(
		array(
			'Name'=>'course_student'			
		)
	)
);

$configini['hasAndBelongsToMany'] = array (
	//;table:other table:select items:join statement:middle table'id	
	'students' => array (
		array (
			'Name' => 'courses'
		),
		array (
			'Name' => 'teachers',
			'Join' => 'join courses on teachers.course_id=courses.id join course_student on courses.id=course_student.course_id',
			'InField' => 'course_student.student_id'			
		)
	),

	'teachers' => array (
		array (
			'Name' => 'students',
			'Join' => 'join course_student on students.id=course_student.student_id join teachers on teachers.course_id=course_student.course_id',
			'InField' => 'teachers.id'
		)
	),
	'courses' => array (
		array (
			'Name' => 'students'
		),
		array (
			'Name' => 'classes',
			'Join' => 'join students on classes.id=students.class_id join course_student on students.id=course_student.student_id',
			'InField' => 'course_student.course_id'
		)
	)
);
?>
