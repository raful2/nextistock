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
           
            
                    $sql = "SELECT name FROM public.users WHERE email = ? AND pw = ?";
                    $stm = $this->pdo->prepare($sql);
                    $stm->bindParam(1, $user['email']);
                    $stm->bindValue(2, $user['pw']);
                    $stm->execute();
                    $data = $stm->fetch();
                    if(empty($data['name'])){
                        return array(
                            "result"=>0
                        );
                    }else{
                        return array(
                            "result"=>1,
                            "name"=>$data['name']
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