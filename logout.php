<?php
session_start() ;

if(isset($_SESSION['member_id'])) {
	$_SESSION = array() ;
	
	if(isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time() - 3600) ;
	}
	
	session_destroy() ;
	
	if(empty($_SESSION['member_id'])) {
		echo '您已成功登出！' ;
	}
}

setcookie('member_id', '', time() - 3600) ;

$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php' ;
header('Location: ' . $home_url ) ;
?>