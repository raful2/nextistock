<?php
namespace Dao;

use Dao\Dao;
use Dados\Cliente;

final class UserDAO extends Dao {

    public function insert($obj) { throw new Exception("Não precisa implementar"); }
    public function readAll() { throw new Exception("Não precisa implementar"); }
    public function update($obj) { throw new Exception("Não precisa implementar"); }
    public function delete(int $idObj) { throw new Exception("Não precisa implementar"); }
    public function newUser(array $user){
        try {
            $sql = "SELECT email FROM public.users2 WHERE email = :email";
            $stm = $this->pdo->prepare($sql);
            $stm->bindValue(':email', $user['email']);
            $stm->execute();
            $datac = $stm->rowCount();
            if($datac > 0){
                return array([
                    "result"=>"fail",
                    "reason"=>"User ".$user['email']." is already registered"]);
            }else {
                $sql = "INSERT INTO public.users2( name, email, pw) VALUES (?,?,?);";
                $stm = $this->pdo->prepare($sql);
                $stm->bindValue(1,$user['name']);
                $stm->bindValue(2,$user['email']);
                $stm->bindValue(3,$user['pw']);
                $stm->execute();
                return array([
                    "result"=>"success",
                    "reason"=>"User ".$user['email']." registered successfully!"]);            }
        
    }catch(\Throwable $th){
        echo $th;

    }
}
    public function myProducts(array $info){
        try {
            $sql = "SELECT p.id_prod as id_prod, u.name as username, p.name as prod_name, pc.name as cat_name 
            FROM public.users2 as u 
            JOIN public.products as p 
            ON p.owner = u.id_user 
            JOIN public.pcat as pc 
            ON p.cat = pc.id_cat 
            WHERE u.id_user = :iduser 
            group by prod_name, p.id_prod, cat_name ,pc.id_cat, u.name";
            $stm = $this->pdo->prepare($sql);
            $stm->bindValue(':iduser', $info['iduser']);
            $stm->execute();
            $datac = $stm->rowCount();
            
            if($datac < 1){
                return array(
                    'result'=> 0
                );
            }else{
                $datad = $stm->fetch();
                return $datad;
                }    
            } catch (\Throwable $th) 
        {
            echo $th;
        }      
    }
    public function login(array $user){
        try {
            $sql = "SELECT name FROM public.users2 WHERE email = :email AND pw = :pw";
            $stm = $this->pdo->prepare($sql);
            $stm->bindValue(':email', $user['email']);
            $stm->bindValue(':pw', $user['pw']);
            $stm->execute();
            $datac = $stm->rowCount();
            
            if($datac < 1){
                return array(
                    "result"=> 0
                );
            }else{
                $datad = $stm->fetch();
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