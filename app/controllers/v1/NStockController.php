<?php

namespace Controllers\V1;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Controllers\V1\CoreController;
use Dao\UserDAO;
use Dao\CartaoDao;

final class NStockController extends CoreController
{

    /**
     * @api {GET} /status Status da API
     * 
     * @apiVersion 1.0.0
     * 
     * @apiDescription Verifica a disponibilidade da API
     * 
     * @apiGroup Recursos Abertos
     * 
     * @apiSuccess (200) {String} status Resultado da disponibilidade do servidor.
     * 
     * @apiSuccessExample {JSON} Success-Response:
     *  {
     *      "status": "Serviço disponível WS3"
     *  }
     */

    public static function getStatus(Request $req, Response $res, array $args)
    {
        $dados = [
            "status" => "Serviço disponível WS3"
        ];

        return $res->withStatus(200)->withJson($dados);
    }
    public static function newuser(Request $req, Response $res, array $args){
        $dados = $req->getParsedBody();
        if(empty($dados['name']) || empty($dados['email']) || empty($dados['pw']) ){
            return $res->withStatus(401)->withJson(
                [
                    "result" => "Fail",
                    "reason" => "The data must not be empty"
                ]
            );

        }else{
            $newUser = new UserDAO();
            $result = $newUser->newUser($dados);
            return $res->withStatus(401)->withJson(
                [
                    "result" => "success",
                    "reason" => "User ".$dados['name']." registered successfuly"
                ]
            );
        }
        
        
    }
    public static function login(Request $req, Response $res, array $args)
    {
        $dados = $req->getParsedBody();
        
        $login = new UserDAO();
        $result = $login->login($dados);
        if($result['result'] == 0){
            return $res->withStatus(403)->withJson(
                [
                    "try" => "fail",
                    "reason" => "invalid information"
                 ]);

        }elseif ($result['result'] == 1) {
            # code...
        
            return $res->withStatus(200)->withJson(
                ["try" => "success",
                 "name"=>$result['name']]);

        }

       

    }

}