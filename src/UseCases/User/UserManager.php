<?php

namespace Api\UseCases\User;

use \Exception;

use Api\Domain\User\User;
use Api\Domain\User\UserRepo;

class UserManager
{
    private UserRepo $userRepo;
    private array $json;
    private int $variable;
    private $requiredFields = array('name', 'address', 'city', 'state');
    private bool $result;
    private mixed $data;

    public function __construct(&$userRepo, &$variable, &$json)
    {
        $this->userRepo = $userRepo;
        $this->variable = $variable;
        $this->json = $json;
        $this->result = false;
    }
    
    public function create():void
    {
        foreach ($this->requiredFields as $key => $field)
        {
            if(!isset($this->json[$field]))
                throw new Exception("Campo obrigatório não preenchido: ".ucfirst($field), 400);
        }
        
        $user = new User(
            $this->json['name'],
            $this->json['address'],
            $this->json['city'],
            $this->json['state']
        );

        if(!$this->userRepo->create($user))
            throw new Exception("Não foi possível gravar no banco de dados", 500);

        $this->result = true;
        $this->data = $user->whoIs();
    }

    public function read():void
    {
        $user = $this->userRepo->read($this->variable);

        if(!is_array($user))
            throw new Exception("Usuário não encontrado", 404);
        
        $this->result = true;
        $this->data = $user;
    }

    public function update():void
    {
        $user = new User();

        if(count($this->json) <=0 )
            throw new Exception("Erro no payload", 400);
        
        if(isset($this->json['name']))
            $user->setName($this->json['name']);
        
        if(isset($this->json['address']))
            $user->setAddress($this->json['address']);
        
        if(isset($this->json['city']) && is_numeric($this->json['city']))
            $user->setCity($this->json['city']);
        
        if(isset($this->json['state']) && is_numeric($this->json['state']))
            $user->setState($this->json['state']);

         if(!$this->userRepo->update($this->variable, $user))
            throw new Exception("Não foi possível realizar a alteração", 400);

         $this->result = true;
         $this->data = $user->whoIs();
    }

    public function delete():void
    {
        if(!$this->userRepo->delete($this->variable))
            throw new Exception("Não foi possível deleter este usuário", 400);
        
        $this->result = true;
        $this->data = "Usuário deletado";
    }

    public function getResult():bool
    {
        return $this->result;
    }

    public function getData():mixed
    {
        return $this->data;
    }

}
