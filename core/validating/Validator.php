<?php
    /**
     * Created by PhpStorm.
     * User: Ruud
     * Date: 17-3-2015
     * Time: 11:44
     */

    namespace Game\Validating;

    class Validator{

        public static $validators = array();
        private $rules = null;
        private $input = null;
        private $failed = true;
        private $errors = array();
        private $messages = array();
        private static $default_messages = array();

        public function __construct($rules, $input){
            $this->rules = $rules;
            $this->input = $input;
        }

        public static function add($name, $callback){
            if(is_callable($callback)){
                static::$validators[$name] = $callback;
            }
        }

        public function check(){
            if($this->input !== null && is_array($this->input) && $this->rules !== null && is_array($this->rules)){

                $total = array();

                foreach($this->rules as $key => $value){
                    $v = explode("|", $value);

                    $out = array();

                    if(isset($this->input[$key])){
                        foreach($v as $validator){
                            $options = array();
                            if(strpos($validator, ":")){
                                $options = explode(":", $validator);
                                if(count($options) >= 2){
                                    $validator = $options[0];
                                }
                                unset($options[0]);
                                $options = array_values($options);
                            }

                            if(isset(static::$validators[$validator])){
                                $result = call_user_func(static::$validators[$validator], $this->input[$key], $options);
                                if($result === false){
                                    $this->errors[$key][$validator] = $this->getMessage($key, $validator, $options);
                                    $out[] = false;
                                }
                            }
                            else{
                                $out[] = false;
                                $this->errors[$key]["global"] = $this->getMessage($key, "global", $options);
                            }
                        }
                    }
                    else{
                        if(in_array("required", $v)){
                            $out[] = false;
                            $this->errors[$key]["required"] = $this->getMessage($key, "required");
                        }
                    }

                    if(in_array(false, $out)){
                        $total[$key] = false;
                    }
                    else{
                        $total[$key] = true;
                    }
                }

                if(in_array(false, $total)){
                    $this->failed = true;
                }
                else{
                    $this->failed = false;
                }
            }
        }

        private function getMessage($key, $validator, $parameters = array()){
            foreach($this->messages as $message => $value){
                if(strpos($message, ".") !== false){
                    $m = explode(".", $message);
                    if(count($m) >= 2){
                        if($key === $m[0] && $validator === $m[1]){
                            var_dump($validator);

                            return $value;
                        }
                    }
                }
                else{
                    if($validator === $message){
                        return $value;
                    }
                }
            }

            $message = "";
            if(!array_key_exists($key, static::$default_messages)){
                $message = "Default message. {key}";
            }
            else{
                $message = static::$default_messages[$key];
            }

            $message = str_replace("{key}", $key, $message);

            foreach($parameters as $key => $parameter){
                $message = str_replace("{parameter_" . $key . "}", $parameter, $message);
            }

            return $message;
        }

        public function setMessages($messages){
            $this->messages = $messages;
        }

        public static function addMessage($key, $value){
            static::$default_messages[$key] = $value;
        }

        public function fails(){
            return $this->failed;
        }

        public function allErrors(){
            return $this->errors;
        }

        public function hasError($name){
            if(isset($this->errors[$name])){
                return true;
            }

            return false;
        }

        public function getError($name){
            if(isset($this->errors[$name])){
                return $this->errors[$name];
            }

            return null;
        }
    }