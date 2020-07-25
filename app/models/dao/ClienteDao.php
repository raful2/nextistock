<?php
namespace Dao;

use Dao\Dao;
use Dados\Cliente;

final class ClienteDao extends Dao {

    public function insert($obj) { throw new Exception("Não precisa implementar"); }
    public function readAll() { throw new Exception("Não precisa implementar"); }
    public function update($obj) { throw new Exception("Não precisa implementar"); }
    public function delete(int $idObj) { throw new Exception("Não precisa implementar"); }
    public function saveClients(array $clients){
        try {
           
                
                    $sql = "INSERT INTO CLIENTES (NOME, PHONE) VALUES (:id, :nome, :phone)";
                    $stm = $this->pdo->prepare($sql);
                    $stm->bindValue(':id', $clients['id']);
                    $stm->bindValue(':nome', $clients['nome']);
                    $stm->bindValue(':phone', $clients['phone']);
                    $stm->execute();
                       
            } catch (\Throwable $th) 
            {
                echo $th;
            }   
    }
    public function read(int $idObj) {
        try {
            $sql = "SELECT * FROM tb_cliente WHERE id = :id";
            $req = $this->pdo->prepare($sql);
            $req->bindValue(":id", $idObj);
            $req->execute();

            $result = $this->createObj($req->fetch());

        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $result;
    }

    private function createObj($reqFetch) {
        return new Cliente($reqFetch['id'], $reqFetch['nome']);
    }
}