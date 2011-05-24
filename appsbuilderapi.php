<?php
	class AppsBuilderApi {

		/*
			Authentication
		*/

		private function logout(){
			return $this->doRequest("/auth/logout",false);
		}

		public function connect($username,$password){
			$this->logout();
			$data = "username=".urlencode($username)."&password=".urlencode($password);
			return $this->doRequest("/auth/connect",$data);
		}

		public function register($username,$password,$email){
			$this->logout();
			$data = "username=".urlencode($username)."&password=".urlencode($password)."&email=".urlencode($email);
			return $this->doRequest("/auth/register",$data);
		}

		/*
			App Management

		*/

		public function createApp(){

			$data = "";
			return $this->doRequest("/app/createApp2",$data);
		}

		public function deleteApp($id){

			$data = "";
			return $this->doRequest("/app/deleteApp/$id",$data);
		}

		/*
			styling
		*/

		public function getImages($usertype=false,$imgtype=false,$set = ""){
			if(!$usertype || !$imgtype){
				return false;
			}
			return $this->doRequest("/style/getImages/$usertype/$imgtype/$set",array());
		}

		public function deleteImage($src){
			$datas = array( "src" => $src );
			return $this->doRequest("/style/deleteImage",$datas);
		}

		public function addImage($type,$src){
			$datas = array(
				"type" => $type,
				"userfile" => "@".$src
			);
			return $this->doRequest("/style/deleteImage",$datas);
		}

		public function getTemplates(){
			return $this->doRequest("/style/getTemplates","");
		}

		public function setTemplate($id,$template){
			$datas=array("template" => $template);
			return $this->doRequest("/style/setTemplate".$id,$datas);
		}

		public function getStyle($id,$styles){

			if(is_array($styles) && !is_assoc($styles)){
				$rstyles=implode(",",$styles);
			}else{
				$rstyles=$styles;
			}
			return $this->doRequest("/style/getStyle/".$id,$rstyles);
		}

		public function setStyle($id,$styles){
			return $this->doRequest("/style/getStyle/".$id,$styles);
		}

		public function deleteStyle($id,$style){
			$datas = array( "style" => $style );
			return $this->doRequest("/style/deleteStyle/".$id,$datas);
		}

		/*
			App Tree
		*/
		public function getAppTree($id){

			$data = "";
			return $this->doRequest("/category/getAppTree/$id",$data);
		}

		public function updateAppTree($id,$tree){

			$data = array("tree" => $tree);
			return $this->doRequest("/category/addAppTree/$id",$data);
		}

		/*
			App Infos

		*/
		public function getAppInfos($id){

			$data = "";
			return $this->doRequest("/app/getAppInfos/$id",$data);
		}

		public function setAppInfos($id,$title,$descrizione,$icon = false ,$splash = false){

			$data=array(
			       "titolo" => $title,
			       "descrizione" => $descrizione
			);

			if($icon){
				$data["app_icon"] = "@".$icon;
			}

			if($splash){
				$data["splash_image"] = "@".$splash;
			}

			return $this->doRequest("/app/updateApp/$id",$data);

		}

		/*
			App Creation

		*/
		public function createQRCode($id){

			$this->doRequest("/builder/createQRCode/$id","");
			return $this->baseurl."/apps/{$id}_web.png";

		}

		public function addAppleCertificates($id,$key,$pwd,$provision){
			$datas = array(
				"p12" => "@".$key,
				"password" => $pwd,
				"mobileprovision" => "@".$provision
			);
			return $this->doRequest("/builder/getIphoneApp/$id",$datas);
		}

		public function createIPhone($id){
			$this->doRequest("/builder/createIPhone/$id","");
			return $this->doRequest("/builder/getIphoneApp/$id","");
		}

		public function createAndroid($id){

			$this->doRequest("/builder/createAndroid/$id","");
			return $this->doRequest("/builder/getAndroidApp/$id","");

		}

		/*

			class functions

		*/


		function __construct(){
			$this->cookie = $this->getCookie();
			$this->baseurl="http://beta.apps-builder.com";
		}

		private function getCookie(){
			$dir=getcwd();
                   	if(is_writeable($dir)){
                        	return $dir."/appsbuildercookie.txt";
	                }else{
                        	return tempnam("appsbuildercookie","appsbuildercookie");
			}
		}

		private function doRequest($url,$params){

			$handle = curl_init($this->baseurl.$url);
			curl_setopt($handle, CURLOPT_POST, true);
			curl_setopt($handle, CURLOPT_POSTFIELDS, $params);
			curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($handle, CURLOPT_COOKIEFILE, $this->cookie);
			curl_setopt($handle, CURLOPT_COOKIEJAR, $this->cookie);
			$response = curl_exec($handle);

			return $response;
		}

		private function is_assoc ($arr) {
        		return (is_array($arr) && count(array_filter(array_keys($arr),'is_string')) == count($arr));
		}

	}
?>
