<?php
header("Content-type: text/css", true);

if (isset($_GET['f'])) {
	$css_param = $_GET['f'];
} else {
	//auf die gespeicherte Version zugreifen
	
	$p =  __DIR__.'/param.txt';
	//echo $p;
	if (file_exists($p)) {
		$css_param =  file_get_contents ($p);
	} else {	
		$css_param = '444444,1b868b,24b1b9,a80004,ff171d,22a9b0,006871,b81418,eff6f6';
	}	
}

$css_param = strtolower($css_param);
$css_param = preg_replace("/[^a-z0-9,.]+/", "", $css_param);
//echo $css_param;

$css_paramArr = explode(',',$css_param);
$css_paramArrNew = array();
foreach ($css_paramArr  as $f) {
	if (strlen($f) != 6) $f='000000';
	$css_paramArrNew[] = $f;		
}



$p =  __DIR__.'/colors.txt';
$css =  file_get_contents ($p);

$fnr = 0;
foreach ($css_paramArrNew  as $f) {
	$css = str_replace('[f'.$fnr.']', $f, $css);
	$fnr++;
}
echo $css;


$css_param = implode(',',$css_paramArrNew);
if (isset($_GET['do']) AND $_GET['do'] == "save" ) {
	require('../../../config.php');
	if (defined('WB_PATH') == false) { exit("Cannot access this file directly"); }
	require_once WB_PATH . '/framework/class.frontend.php';
	$wb = new frontend();
	if (is_numeric($wb->get_session('USER_ID'))) {
		if ($wb->ami_group_member('1')) {
			$p =  __DIR__.'/param.txt';
			file_put_contents ($p, $css_param);
		}
	}
}



?>