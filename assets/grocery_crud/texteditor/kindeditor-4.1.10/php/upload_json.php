<?php
/**
 * KindEditor PHP
 *
 * 本PHP程序是演示程序，建议不要直接在实际项目中使用。
 * 如果您确定直接使用本程序，使用之前请仔细确认相关安全设置。
 *
 */
require_once 'JSON.php';
//文件保存目录路径
$save_path = $_SERVER['DOCUMENT_ROOT'] .'/upload/';
//文件保存目录URL
$save_url = '/upload/';
//定义允许上传的文件扩展名
$ext_arr = array(
	'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
	'flash' => array('swf', 'flv'),
	'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
	'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
);
//最大文件大小
$max_size = 1024*1024*50;

$save_path = realpath($save_path) . '/';

//PHP上传失败
if (!empty($_FILES['imgFile']['error'])) {
	switch($_FILES['imgFile']['error']){
		case '1':
			$error = '超过php.ini允许的大小。';
			break;
		case '2':
			$error = '超过表单允许的大小。';
			break;
		case '3':
			$error = '图片只有部分被上传。';
			break;
		case '4':
			$error = '请选择图片。';
			break;
		case '6':
			$error = '找不到临时目录。';
			break;
		case '7':
			$error = '写文件到硬盘出错。';
			break;
		case '8':
			$error = 'File upload stopped by extension。';
			break;
		case '999':
		default:
			$error = '未知错误。';
	}
	alert($error);
}

//有上传文件时
if (empty($_FILES) === false) {
	//原文件名
	$file_name = $_FILES['imgFile']['name'];
	//服务器上临时文件名
	$tmp_name = $_FILES['imgFile']['tmp_name'];
	//文件大小
	$file_size = $_FILES['imgFile']['size'];
	//检查文件名
	if (!$file_name) {
		alert("请选择文件。");
	}
	//检查目录
	if (@is_dir($save_path) === false) {
		alert("上传目录不存在。");
	}
	//检查目录写权限
	if (@is_writable($save_path) === false) {
		alert("上传目录没有写权限。");
	}
	//检查是否已上传
	if (@is_uploaded_file($tmp_name) === false) {
		alert("上传失败。");
	}
	//检查文件大小
	if ($file_size > $max_size) {
		alert("上传文件大小超过限制。");
	}
	//检查目录名
	$dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
	if (empty($ext_arr[$dir_name])) {
		alert("目录名不正确。");
	}
	//获得文件扩展名
	$temp_arr = explode(".", $file_name);
	$file_ext = array_pop($temp_arr);
	$file_ext = trim($file_ext);
	$file_ext = strtolower($file_ext);
        
	//检查扩展名
	if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
		alert("上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr[$dir_name]) . "格式。");
	}
//	//创建文件夹
//	if ($dir_name !== '') {
//		$save_path .= $dir_name . "/";
//		$save_url .= $dir_name . "/";
//		if (!file_exists($save_path)) {
//			mkdir($save_path);
//		}
//	}
//	$ymd = date("Ymd");
//	$save_path .= $ymd . "/";
//	$save_url .= $ymd . "/";
	if (!file_exists($save_path)) {
		mkdir($save_path);
	}
	//新文件名
	$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
	//移动文件
	$file_path = $save_path . $new_file_name;
	if (move_uploaded_file($tmp_name, $file_path) === false) {
		alert("上传文件失败。");
	}
	@chmod($file_path, 0644);
	$file_url = $save_url . $new_file_name;
    //上传到七牛空间的名称 【需要修改】
    $qiniuBucket = 'shecai-test';
    qiniu($qiniuBucket,$new_file_name,$save_path);
    //【可能修改】七牛空间的名称
    $file_url = 'http://'.$qiniuBucket.'.qiniudn.com/'.$new_file_name;

	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 0, 'url' => $file_url));
	exit;
}

/**
 * @param $new_file_name 新图片名称
 * @param $file_url 图片地址
 */
function qiniu($bucket,$new_file_name,$save_path){
    $qiniuPath = $save_path.'../application/libraries/qiniu/';
    require_once($qiniuPath.'rs.php');
    require_once($qiniuPath.'io.php');
    $accessKey = 'RwJm_Cq0sV2XU_m7wqsAEUTlKxmz56knovbMvsjz';
    $secretKey = 'JLkbeW5V8by6rabobccQ7AwNeHnxQK-ZT-WfwoKa';
    Qiniu_setKeys($accessKey, $secretKey);
    $putPolicy = new Qiniu_RS_PutPolicy($bucket);
    $upToken = $putPolicy->Token(null);
    $putExtra = new Qiniu_PutExtra();
    $putExtra->Crc32 = 1;
    list($ret, $err) = Qiniu_PutFile($upToken, $new_file_name, $save_path.$new_file_name, $putExtra);
    if ($err !== null) {
        throw new Exception($err->Err, $err->Code);
    }
}

function alert($msg) {
	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 1, 'message' => $msg));
	exit;
}
