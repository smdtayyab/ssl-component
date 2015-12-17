<?php 

namespace smdtayyab;

class SSL {   

    public $force_ssl = null;
    public $neutral_actions = null;
    
    function initialize($force_ssl_urls = null,$neutral_action_urls = null) {
    	//Default urls for testing.
        $this->force_ssl = array();   // Default values $this->force_ssl = array();
        $this->neutral_actions = array();  // Default values $this->neutral_actions = array();  		


    	if(isset($force_ssl_urls) && !empty($force_ssl_urls)){
	        $this->force_ssl = $force_ssl_urls;    		
    	}

    	if(isset($neutral_action_urls) && !empty($neutral_action_urls)){
	        $this->neutral_actions = $neutral_action_urls;    		
    	}

        $this->__check_url();
    }
    
    function force() {
        if(!$this->__isSSL()) {
            // $this->redirect('https://'.$this->__url());
            $redirect_url=$this->__url();
            header( "Location: https://$redirect_url") ;
			die();
        }
    }
	function unforce() {
	       if($this->__isSSL()) {
		   $redirect_url=$this->__url();
            header( "Location: http://$redirect_url") ;
			//following code does not working static pages so used php redirect
			//$this->redirect('http://'.$this->__url());
			die();
        }
    }    
    function __url() {
        $port = $this->__env('SERVER_PORT') == 80 ? '' : ':'.$this->__env('SERVER_PORT');
        return $this->__env('SERVER_NAME').$this->__env('REQUEST_URI');
    }
    function __env($attr){
    	if(isset($_SERVER[$attr])) {
    		return $_SERVER[$attr];
    	}
    	return '';
    }

	function check_ssl(){
		if($this->__isSSL()) {
			return true;
		}else{
			return false;
		}
	}
	
	/*
	 * Returns true if the current request is over HTTPS, false otherwise.
 	 * @return bool True if call is over HTTPS
	*/
	function __isSSL() {
		if($this->__env('REQUEST_SCHEME')=='https') {
			return true; 
		}else{
			return false;
		}
	}
	/*
		functions that check current url for ssl and enforces if it required.
	*/
	function __check_url(){
		$current_url = $this->__env('REQUEST_URI');
		if (!in_array($current_url, $this->neutral_actions)) {
				if (in_array($current_url, $this->force_ssl)) {
					$this->force();
				} else {
					$this->unforce();
				}
			}
	}
}
?>