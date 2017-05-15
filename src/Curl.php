<?php

namespace Vesic\Curl;

class Curl {
    
    protected $_url;
    protected $_session;
    protected $_options = [
        'url' => CURLOPT_URL,
        'transferAsString' => CURLOPT_RETURNTRANSFER
    ];
    
    public function __construct() {
        $this->_session = curl_init();
    }
    
    public static function getCurlObject($url = null) {
        if ($url != null) {
            $curlObject = new self();
            $curlObject->setUrl($url);
            return $curlObject;
        } else {
            return new self();
        }
    }
    
    protected function isValidUrl($url) {
        return (preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url));
    }
    
    protected function setUrl($url) {
        if ($this->isValidUrl($url)) {
            $this->_url = $url;
            curl_setopt($this->_session, $this->_options['url'], $this->_url); 
        } else {
            die('Not a valid url');
        }
    }
    
    public function exec($transferAsString = true) {
        if ($transferAsString) {
            curl_setopt($this->_session, $this->_options['transferAsString'], true);
        }
        return curl_exec($this->_session);
    }
    
    public function __destruct() {
        curl_close($this->_session);
    }
}
