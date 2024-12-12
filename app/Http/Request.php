<?php 
    namespace App\Http;

    class Request {

        protected $segments = [];
        protected $controller;
        protected $method;

        // Constructor de la clase.
        public function __construct() { 
            $this->segments = explode('/', $_SERVER['REQUEST_URI']);            
            $this->setController();
            $this->setMethod();       
        }

        // Llena de datos a las propiedades controller.
        public function setController() {
            $this->controller = empty($this->segments[1])
                ? 'home'
                : $this->segments[1];
        }

        // Devuelve el valor de la propiedad controller.
        public function getController() {
            //home, HomeController
            $controller = ucfirst($this->controller);
            return "App\Http\Controllers\\{$controller}Controller";
        }

        // Llena de datos a las propiedades method.
        public function setMethod() {
            $this->method = empty($this->segments[2])
                ? 'index'
                : $this->segments[2];
        }

        // Devuelve el valor de la propiedad method.
        public function getMethod() {
            return $this->method;
        }

        // Ejecuta el método del controlador.
        public function send() {
            $controller = $this->getController();
            $method = $this->getMethod();

            $response = call_user_func([
                new $controller,
                $method
            ]);

            $response->send();
        }


    }
?>