<?php
/**
 * OAuth 2.0 处理类
 * 
 * @author Administrator
 *
 */
include('DBOwnerOAuth.php'); //验证类

class DBOwner{
	var $code = 'code'; //默认的验证方式
	var $format = 'json'; //请求方法
	
	function __construct($config,$token=null){
		$this->client_id      = $config['client_id'];
		$this->client_secret  = $config['client_secret'];
		$this->redirect_uri   = $config['redirect_uri'];
		
		$this->authorizeURL   = $config['authorizeURL'];
		$this->accessTokenURL = $config['accessTokenURL'];
		$this->host           = $config['host'];
		
		$this->access_token   = $token['access_token'];
		$this->refresh_token  = $token['refresh_token'];
		$this->user_id        = $token['user_id'];
		
		
		$this->DBOwnerOAuth = new DBOwnerOAuth($this->client_id,$this->client_secret,$this->access_token,$this->refresh_token);
	}
	
	/**
	 * 第一步请求用户授权临时信息
	 */
	function getAuthorizeOAuth($seArr=false){
		$response_type = 'code';
	
		$authorize_request_url = $this->DBOwnerOAuth->getAuthorizeURL($this->authorizeURL,strtolower($this->redirect_uri) ,$response_type , $state = NULL, $display = NULL ,$seArr);
	
		return $authorize_request_url;
	}
	
	/**
	 * 第二步获取用户授权信息
	 */
	function getAccessOAuth(){
		$key['code']   = $_GET['code'];
	
		$key['redirect_uri'] = $this->redirect_uri;
	
		return $this->DBOwnerOAuth->getAccessToken($this->accessTokenURL,$this->code,$key);
	}
	/**
	 * 获取用户信息
	 */
	function api_show(){
		$url = $this->host.'/users/show';
		
		$params['format']       = $this->format;
		$params['access_token'] = $this->access_token;
		
		return $this->DBOwnerOAuth->get($url,$params);
	}
	/**
	 * 退出此用户登录状态 
	 */
	function api_signout(){
		$url = $this->host.'/users/signout';
	
		$params['format']       = $this->format;
		$params['access_token'] = $this->access_token;
	
		return $this->DBOwnerOAuth->get($url,$params);
	}
	/**
	 * 判断是否过期 
	 */
	function api_istimeout(){
		$url = $this->host.'/users/istimeout';
	
		$params['format']       = $this->format;
		$params['access_token'] = $this->access_token;
	
		return $this->DBOwnerOAuth->get($url,$params);
	}
	/**
	 * 用refresh_token刷新access_token
	 */
	function api_fresh_token(){
		$url = $this->host.'/users/istimeout';
	
		$params['format']        = $this->format;
		$params['refresh_token'] = $this->refresh_token;
	
		return $this->DBOwnerOAuth->get($url,$params);
	}
	/**
	 * 返回用户所有应用及其权限代码
	 */
	function api_getapplist(){
		$url = $this->host.'/users/getapplist';
	
		$params['format']       = $this->format;
		$params['access_token'] = $this->access_token;
	
		return $this->DBOwnerOAuth->get($url,$params);
	}
	/**
	 * 查询指定用户名的用户信息
	 */
	function api_show_by_name($fieldArr){
		$url = $this->host.'/users/show_by_name';
	
		$params['format']       = $this->format;
		$params['access_token'] = $this->access_token;
		$params['name']         = $fieldArr['name'];
	
		return $this->DBOwnerOAuth->get($url,$params);
	}
	/**
	 * 查询指定用户user_id的用户信息
	 */
	function api_show_by_userid($fieldArr){
		$url = $this->host.'/users/show_by_userid';
	
		$params['format']       = $this->format;
		$params['access_token'] = $this->access_token;
		$params['user_id']      = $fieldArr['user_id'];
	
		return $this->DBOwnerOAuth->get($url,$params);
	}
	/**
	 * 发布信息
	 */
	function api_send_msg($fieldArr){
		$url = $this->host.'/content/send_msg';
	
		$params['format']       = $this->format;
		$params['access_token'] = $this->access_token;
		$params['accepter']     = $fieldArr['accepter'];
		$params['theme']        = $fieldArr['theme'];
		$params['content']      = $fieldArr['content'];
	
		return $this->DBOwnerOAuth->post($url,$params);
	}
	/**
	 * 取用户未读短信息列表
	 */
	function api_get_new_msg($fieldArr){
		$url = $this->host.'/content/get_new_msg';
	
		$params['format']       = $this->format;
		$params['access_token'] = $this->access_token;
		$params['pagesize']     = $fieldArr['pagesize'];
		$params['page']         = $fieldArr['page'];
	
		return $this->DBOwnerOAuth->post($url,$params);
	}
	/**
	 * 取用户已读短信息列表
	 */
	function api_get_read_msg($fieldArr){
		$url = $this->host.'/content/get_read_msg';
	
		$params['format']       = $this->format;
		$params['access_token'] = $this->access_token;
		$params['pagesize']     = $fieldArr['pagesize'];
		$params['page']         = $fieldArr['page'];
	
		return $this->DBOwnerOAuth->post($url,$params);
	}
	/**
	 * 取用户已发送信息列表
	 */
	function api_get_send_msg($fieldArr){
		$url = $this->host.'/content/get_send_msg';
	
		$params['format']       = $this->format;
		$params['access_token'] = $this->access_token;
		$params['pagesize']     = $fieldArr['pagesize'];
		$params['page']         = $fieldArr['page'];
	
		return $this->DBOwnerOAuth->post($url,$params);
	}
	/**
	 * 取用户已删除信息列表
	 */
	function api_get_del_msg($fieldArr){
		$url = $this->host.'/content/get_del_msg';
	
		$params['format']       = $this->format;
		$params['access_token'] = $this->access_token;
		$params['pagesize']     = $fieldArr['pagesize'];
		$params['page']         = $fieldArr['page'];
	
		return $this->DBOwnerOAuth->post($url,$params);
	}
	/**
	 * 删除短信息
	 */
	function api_del_msg($fieldArr){
		$url = $this->host.'/content/del_msg';
	
		$params['format']       = $this->format;
		$params['access_token'] = $this->access_token;
		$params['id']           = $fieldArr['id'];
		$params['type']         = $fieldArr['type'];
	
		return $this->DBOwnerOAuth->get($url,$params);
	}
}