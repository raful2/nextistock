<?php

namespace Config;

use Slim\App;
use Controllers\V1\NStockController;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer as Render;
use View;
final class Routes {


    private $app;
    private $view;
    public function __construct(App $app) {
        $this->app = $app;

        if (!empty($this->app)) {
            $this->initRoutesV1();
        } else {
            throw new Exception("Slim não iniciado.");
        }
    }

    private function initRoutesV1() {
       
        $app = $this->app;

        $app->group("/v1", function() use ($app){
            $str = explode('\\',__DIR__,-1);    
            $viewPath = $str[0]."\\".$str[1]."\\".$str[2]."\\".$str[3]."\\".$str[4]."/views";
                $view = new Render($viewPath);
                
            /* Métodos GET */
            $app->get("/status", function(Request $rq, Response $rs, $args=[]){
                $str = explode('\\',__DIR__,-1);
                // $new = str_split($str,-1);
                return $rs->withStatus(200)->withJson($str);
            });
           
            $app->post("/login/do", [NStockController::class,  "login"]);   
            $app->post("/newuser/do", [NStockController::class,  "newuser"]);   
            $app->get("/myproducts/list", [NStockController::class,  "myprods"]);   

            /* Métodos POST */
            $app->get("/", function(Request $rq,Response $rs, $args=[]) use ($view){
                
                
                return $view->render($rs,
                                    'index.html', 
                                    ["name"=>"raful"]
                );
            });  
        });
    }
}