<?php

/**
* Class for sending HTTP Requests using raw sockets
*
* This class compiles HTTP Requests and use's raw sockets
* to interact with the given server. Upon recieving data
* it uses RegEx to parse the header information and any
* given cookie data.
*
* @author Joshua Gilman
* @package HTTPSock
*/
class HTTPSock
{
    public $error = array();
    public $last_error = NULL;

    public $headers = array();
    public $cookie = NULL;
    public $cookies = NULL;

    private $socket = NULL;
    private $host = NULL;
    private $numerical_host = NULL;
    private $path = NULL;
    private $port = NULL;

    private $header = NULL;
    private $content = NULL;

    protected $newline = "\r\n";
    protected $connection = "tcp";
    protected $service = "www";

    /**
    * Sends an HTTP Request and returns the content
    *
    * This function will send an HTTP Request using the specified
    * url as you would a web browser. A type ("GET" or "POST") and
    * a valid URL is mandatory. Upon recieving a response it will
    * remove and parse the headers and return the content.
    *
    * @var String $HTTP_TYPE
    * @var String $webURL
    * @var Mixed $HTTPPostVars
    * @var Mixed $headers
    *
    * @return String The returned HTTP response with stripped header
    */
    public function HTTPRequest($HTTP_Type, $webURL, $HTTPPostVars = array(), $headers = array())
    {
        $this->new_socket();

        list($host, $path) = $this->url_details($webURL);

        $this->host = $host;
        $this->numerical_host = $this->get_numerical_host();
        $this->path = $path;
        $this->port = $this->get_port();

        $this->connect($this->host, $this->port);

        $header = $this->assemble_header($HTTP_Type, $this->host, $this->path, $HTTPPostVars, $headers);

        socket_write($this->socket, $header, strlen($header));

        $this->read_socket();
        $this->parse_header();

        if ($this->headers['Content-Encoding'] == "gzip")
        {
            $this->content = gzinflate(substr($this->content, 10));
        }

        return $this->content;
    }

    /**
    * Logs an error and throws an exception
    *
    * This function uses an error string to log an error
    * and throw a new exception. When using this class
    * always include it in a try/catch statement.
    *
    * @var String $error_string
    */
    private function new_error($error_string)
    {
        $this->error[] = $error_string;
        $this->last_error = $error_string;

        throw new Exception("Socket Error: " . $error_string);
    }

    /**
    * Creates a new TCP socket using some default values
    *
    * This function creates and sets the class socket to
    * be used when sending and reading data from and to
    * the socket stream.
    */
    private function new_socket()
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        if (!$this->socket)
        {
            $this->new_error(socket_strerror($this->socket));
        }
    }

    /**
    * Returns the default service port for the requested service
    *
    * This function uses the assigned settings for the service
    * and connection type to grab the default port for the settings
    *
    * @return Integer
    */
    private function get_port()
    {
        return $service_port = getservbyname($this->service, $this->connection);
    }

    /**
    * Returns the IP of the given host name
    *
    * This function takes a host name and returns the
    * numerical IP related to the host name.
    *
    * @return String
    */
    private function get_numerical_host()
    {
        return gethostbyname($this->host);
    }

    /**
    * Connects the already created class socket
    *
    * This function connects the socket using the
    * already set host and port details. Throws an
    * exception when the connection fails.
    */
    private function connect()
    {
        if (!($result = socket_connect($this->socket, $this->numerical_host, $this->port)))
        {
            $this->new_error(socket_strerror($result));
        }
    }

    /**
    * Assembles an HTTP Header
    *
    * This function is used to create an HTTP Header using
    * some minor details. Default values are given to the
    * common HTTP values but can be overriden by refferencing
    * them in the $headers variable.
    *
    * @param String $HTTP_Type
    * @param String $host
    * @param String $path
    * @param Mixed $HTTPPostVars
    * @param Mixed $headers
    *
    * @return String
    */
    private function assemble_header($HTTP_Type, $host, $path, $HTTPPostVars, $headers)
    {
        $HTTP_Type = strtoupper($HTTP_Type);

        $header = "{$HTTP_Type} {$path} HTTP/1.1\r\n";
        $header .= "Host: " . $host . "\r\n";

        $params['User-Agent'] = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
        $params['Accept'] = "text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        $params['Accept-Language'] = "en-us,en;q=0.5";
        $params['Accept-Encoding'] = "gzip,deflate";
        $params['Accept-Charset'] = "ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $params['Keep-Alive'] = "300";
        $params['Connection'] = "Close";

        if (sizeof($headers) >= 1)
        {
            $params = array_merge($params, $headers);
        }

        foreach ($params as $key => $value)
        {
            $header .= "{$key}: {$value}\r\n";
        }

        if (!empty($this->cookie))
        {
            $header .= "Cookie: " . $this->cookie . "\r\n";
        } elseif (sizeof($this->cookies >= 1)) {
            $cookie_str="";
	   if(isset($this->cookies)) {
	    foreach ($this->cookies as $key => $value)
            {
                $cookie_str .= "$key=$value;";
            }
	}

            $header .= "Cookie: " . $cookie_str . "\r\n";
        }

        if ($HTTP_Type == "POST")
        {
	   $postData="";
            foreach ($HTTPPostVars as $key => $value)
            {
                $key = urlencode($key);
                $value = urlencode($value);

                $postData .= "{$key}={$value}&";
            }

            $postData = substr($postData, 0, strlen($postData) - 1);

            $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $header .= "Content-Length: " . strlen($postData) . "\r\n\r\n";
            $header .= $postData;
        } else {
            $header .= "\r\n";
        }

        return $header;
    }

    /**
    * Parses the returned HTTP Header
    *
    * This function parses the returned HTTP Header into
    * logical parts using an array. Each value is parsed
    * and loaded into the $headers array
    */
    private function parse_header()
    {
        $parts = explode($this->newline . $this->newline, $this->content);

        $this->header = array_shift($parts);
        $this->content = implode($parts, $this->newline . $this->newline);

        $parts = explode($this->newline, $this->header);
        foreach ($parts as $part)
        {
            if (preg_match("/(.*)\: (.*)/", $part, $matches))
            {
                $this->headers[$matches[1]] = $matches[2];
            }
        }

        if (preg_match("/Set-Cookie/i", $this->header))
        {
            $this->parse_cookies();
        }
    }

    /**
    * Parses the cookies from the HTTP Header
    *
    * This function uses RegEx to parse all cookies
    * from the HTTP header and load them into an
    * associative array with the cookie name as the
    * key and the cookie value as the value
    */
    private function parse_cookies()
    {
        $lines = explode($this->newline, $this->header);

        foreach ($lines as $line)
        {
            if (preg_match("/Set-Cookie: (.+?)=(.+?);/", $line, $matches))
            {
                $this->cookies[$matches[1]] = $matches[2];
            }
        }
    }

    /**
    * Reads all data from the socket
    *
    * This reads all the returned data off of
    * the socket stream and returns it in one
    * string
    *
    * @return String
    */
    private function read_socket()
    {
        while ($buffer = socket_read($this->socket, 2048))
        {
             $this->content .= $buffer;
        }

        socket_close($this->socket);
        return $this->content;
    }

    /**
    * Parses a URL into a host and a path
    *
    * This function uses RegEx to parse the host
    * and the path from a URL. Returns the host
    * and path in an array.
    *
    * @param String $url
    *
    * @return Mixed
    */
    private function url_details($url)
    {
        $url = str_replace("http://", "", $url);
        $host = preg_replace("/\/.*/", "", $url);
        $path = str_replace($host, "", $url);

        return array($host, $path);
    }
}


	class AppsBuilderApi {

		/*
			Authentication
		*/

		private function logout(){
			return $this->doRequest("/auth/logout",array());
		}

		/*
			return true if logged, false on error
		*/

		public function connect($username,$password){
			$this->logout();
			$data = array("username" => urlencode($username), "password" => urlencode($password));
			return $this->doRequest("/auth/connect",$data);
		}

		/*
			return true if registered, false on error
		*/

		public function register($username,$password,$email){
			$this->logout();
			$data = array("username" => urlencode($username), "password" => urlencode($password), "email" => urlencode($email));
			return $this->doRequest("/auth/register",$data);
		}

		/*
			App Management

		*/

		/*
			return APPID or false on error
		*/
		public function createApp(){

			$data = array();
			return $this->doRequest("/app/createApp2",$data);
		}

		public function deleteApp($id){

			$data = array();
			return $this->doRequest("/app/deleteApp/$id",$data);
		}

		/*
			styling
		*/

		public function getImages($usertype=false,$imgtype=false,$set = "sets"){
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
			return $this->doRequest("/style/addImage",$datas);
		}

		public function getTemplates(){
			return $this->doRequest("/style/getTemplates",array());
		}

		public function setTemplate($id,$template){
			$datas=array("template" => $template);
			return $this->doRequest("/style/setTemplate/".$id,$datas);
		}

		public function setLayout($id,$layout){
			$datas=array("layout" => $layout);
			return $this->doRequest("/category/setLayout/".$id,$datas);
		}

		public function getStyle($id,$styles){

			if(is_array($styles) && !is_assoc($styles)){
				$rstyles=implode(",",$styles);
			}else{
				$rstyles=$styles;
			}
			$rstyles=array("style" => $rstyles);
			return $this->doRequest("/style/getStyle/".$id,$rstyles);
		}

		public function setStyle($id,$styles){
			return $this->doRequest("/style/addStyle/".$id,$styles);
		}

		public function deleteStyle($id,$style){
			$datas = array( "style" => $style );
			return $this->doRequest("/style/deleteStyle/".$id,$datas);
		}

		/*
			App Tree
		*/
		public function getAppTree($id){

			$data = array();
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

			$data = array();
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

			$this->doRequest("/builder/createQRCode/$id",array());
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
			$this->doRequest("/builder/createIPhone/$id",array());
			return $this->doRequest("/builder/getIphoneApp/$id",array());
		}

		public function createAndroid($id){

			$this->doRequest("/builder/createAndroid/$id",array());
			return $this->doRequest("/builder/getAndroidApp/$id","");

		}

		/*

			class functions

		*/


		function __construct(){

			$this->socket = new HTTPSock();
			//$this->cookie = $this->getCookie();
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

			return $this->socket->HTTPRequest("POST", $this->baseurl.$url,$params);
			/*
			$handle = curl_init($this->baseurl.$url);
			curl_setopt($handle, CURLOPT_POST, true);
			curl_setopt($handle, CURLOPT_POSTFIELDS, $params);
			curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($handle, CURLOPT_COOKIEFILE, $this->cookie);
			curl_setopt($handle, CURLOPT_COOKIEJAR, $this->cookie);
			$response = curl_exec($handle);

			return $response;
			*/
		}

		private function is_assoc ($arr) {
        		return (is_array($arr) && count(array_filter(array_keys($arr),'is_string')) == count($arr));
		}

	}


?>
