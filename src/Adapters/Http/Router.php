<?php

namespace Api\Adapters\Http;

use \Exception;

class Router {

    public $request;
    private $allowedResources = [
        'user'
    ];
    private $resource;
    private $variable;

    public function __construct()
    {
        $this->request  = new Request();
        $this->setRoute();
        $this->request->execute();
    }
    
    private function setRoute():void 
    {
        $route = explode('/', $this->request->getUri());
        
        if(isset($route[2])) {
            foreach ($this->allowedResources as $key => $resource) {
                if($resource === $route[2]) {
                    $this->resource = ucfirst($route[2]);
                    continue;
                }
                else 
                    throw new Exception("Recurso não encontrado", 404);
            }
        }

        if(isset($route[3]))
            if(strlen($route[3]) >= 1 && is_numeric($route[3]))    
                $this->variable = intval($route[3]);
        else
            throw new Exception("Variável não permitida ou indefinida", 401);
    }

    public function getResource():string 
    {
        return $this->resource;
    }
    
    public function getVariable():int
    {
        if(!isset($this->variable))
            return 0;
            
        return $this->variable;
    }
}
