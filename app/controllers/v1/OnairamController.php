<?php

namespace Controllers\V1;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Controllers\V1\CoreController;
use Dao\ClienteDao;
use Dao\CartaoDao;

final class OnairamController extends CoreController
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
    public static function getProducts(Request $req, Response $res, array $args)
    {
        $dados = [
            "Produtos" => ""
        ];

        return $res->withStatus(200)->withJson($dados);
    }
    public static function saveClients(Request $req, Response $res, array $args)
    {
        $dados = $req->getParsedBody();
        
        $newClient = new ClienteDao();
        $newClient->saveClients($dados);
        return $res->withStatus(200)->withJson($dados);
    }
    public static function getPoints(Request $req, Response $res, array $args)
    {
        $dados = [
            "Pontos" => ""
        ];

        return $res->withStatus(200)->withJson($dados);
    }
}
