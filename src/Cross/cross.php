<?php
/**
 *  Author:        ShinChen
 *  Email:         shinchen_php@163.com
 *  Create Time:   2018/11/9 10:42
 */


$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

#允许跨域
$accessCrossUrls = [
	'http://localhost:8081',
];
if (in_array($origin, $accessCrossUrls)) {
	// 指定允许其他域名访问
	header('Access-Control-Allow-Origin:' . $origin);
	header('Access-Control-Allow-Methods:GET,POST,PUT,PATCH,OPTIONS,DELETE');
    header('Access-Control-Allow-Headers:authorize');
	if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') exit;
}