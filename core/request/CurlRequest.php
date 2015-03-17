<?php
/**
 * Created by PhpStorm.
 * User: Ruud
 * Date: 17-3-2015
 * Time: 12:38
 */

namespace Game\Request;

class CurlRequest{

    private $url = null;
    private $options = null;
    private $curl = null;
    private $username = null;
    private $password = null;
    private $data = null;

    public function __construct($url){
        $this->url = $url;
        $this->options = array(
            CURLOPT_RETURNTRANSFER => true
        );
    }

    public function auth($username, $password){
        $this->username = $username;
        $this->password = $password;
    }

    public function setOption($option, $value){
        $this->options[$option] = $value;
    }

    public function execute(){
        $this->curl = curl_init();

        curl_setopt($this->curl, CURLOPT_URL, $this->url);

        if($this->username !== null && $this->password !== null){
            curl_setopt($this->curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($this->curl, CURLOPT_USERPWD, $this->username . ":" . $this->password);
        }

        curl_setopt_array($this->curl, $this->options);

        $this->data = curl_exec($this->curl);
    }

    public function getInfo($opt = null){
        if($this->curl !== null){
            return curl_getinfo($this->curl, $opt);
        }
        return null;
    }

    public function hasError(){
        if($this->curl !== null){
            return curl_errno($this->curl);
        }
        return true;
    }

    public function getError(){
        if($this->curl !== null){
            return curl_error($this->curl);
        }
        return null;
    }

    public function getResponseCode(){
        if($this->curl !== null){
            return curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        }
        return -1;
    }

    public function getData(){
        return $this->data;
    }
}