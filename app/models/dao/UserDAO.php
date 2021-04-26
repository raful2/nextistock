<?php
namespace Dao;

use Dao\Dao;
use Dados\Cliente;

final class UserDAO extends Dao {

    public function insert($obj) { throw new Exception("Não precisa implementar"); }
    public function readAll() { throw new Exception("Não precisa implementar"); }
    public function update($obj) { throw new Exception("Não precisa implementar"); }
    public function delete(int $idObj) { throw new Exception("Não precisa implementar"); }
    public function login(array $user){
        try {
           
            
                    $sql = "SELECT name FROM public.users WHERE email = :email AND pw = :pw";
                    $stm = $this->pdo->prepare($sql);
                    $stm->bindValue(':email', $user['email']);
                    $stm->bindValue(':pw', $user['pw']);
                    $stm->execute();
                    $datac = $stm->rowCount();
                    $datad = $stm->fetchAll();
                    if($datac < 1){
                        return array(
                            "result"=>0
                        );
                    }else{

                        return array(
                            "result"=>1,
                            "name"=>$datad['name']
                        );
                    }

                    
                       
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