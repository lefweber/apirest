<?php

use \App\Http\Response;
use \App\Controller\Leads;

$leads = new Leads();

//ROTA PARA PEGAR TODOS OS LEADS
$obRouter->get('/leads',[
    function() {
        global $leads;
        return new Response(200, $leads->getAllLeads());
    }
]);

//ROTA PARA PEGAR OS ÚLTIMOS DEZ LEADS
$obRouter->get('/leads/last',[
    function() {
        global $leads;
        return new Response(200, $leads->getLastTenLeads());
    }
]);

//ROTA DINÂMICA
$obRouter->get('/leads/{id}',[
    function($id) {
        global $leads;
        return new Response(200, $leads->getLead($id));
    }
]);