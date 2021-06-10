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
        $data = [
            "status" => "Serviço disponível WS3"
        ];

        return $res->withStatus(200)->withJson($data);
    }
    public static function newuser(Request $req, Response $res, array $args){
        $data = $req->getParsedBody();
        if(empty($data['name']) || empty($data['email']) || empty($data['pw']) ){
            return $res->withStatus(403)->withJson(
                [
                    "result" => "Fail",
                    "reason" => "The data must not be empty."
                ]
            );

        }else{
            $newUser = new UserDAO();
            $result = $newUser->newUser($data);
            return $res->withStatus(200)->withJson(
                [
                    "result" => $result[0]['result'],
                    "reason" => $result[0]['reason']
                ]
            );
        }
        
        
    }
    public static function myprods(Request $req, Response $res, array $args)
    {
        $data = $req->getParsedBody();
        if(empty($data['iduser'])){
            return $res->withStatus(404)->withJson([
                "error"=>"could not bring the user data"
            ]);
        }
        $myitens = new UserDAO();
        $result = $myitens->myProducts($data);
        return $res->withStatus(200)->withJson($result);

    }
    public static function login(Request $req, Response $res, array $args)
    {
        $data = $req->getParsedBody();
        
        $login = new UserDAO();
        $result = $login->login($data);
        if($result['result'] == 0){
            return $res->withStatus(403)->withJson(
                [
                    "try" => "fail",
                    "reason" => "Could not log in due invalid credentials. Check your data and try again."
                 ]);

        }elseif ($result['result'] == 1) {
           
        
            return $res->withStatus(200)->withJson(
                ["try" => "success",
                 "message"=>$result['name']." logged successfully!"]);

        }

       

    }

}