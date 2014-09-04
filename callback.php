<?php
include('oauth/config.php'); //配置文件
include('oauth/DBOwner.php');

if(isset($_GET['code'])){
	$DBOwner = new DBOwner($config);
	$token = $DBOwner->getAccessOAuth();
	
	header('location:?'.http_build_query($token));
}elseif(isset($_GET['access_token'])){
	$DBOwner = new DBOwner($config,$_GET);
	$userinfo = $DBOwner->api_show();
	var_dump($userinfo);
}else{
	$DBOwner = new DBOwner($config);
	$url = $DBOwner->getAuthorizeOAuth();
	
	header('location:'.$url);
}