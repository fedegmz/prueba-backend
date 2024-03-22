<?php

namespace Fede\Backend\models;

use Fede\Backend\lib\Database;
use PDO;
use PDOException;

class User extends Database
{



    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        try {
            $pdo = $this->Connect();
            $stmt = $pdo->prepare('SELECT u.id, u.fullname, u.email, u.pass, u.openid, IFNULL(uc.user, null) as id_comment
                                    FROM user  as  u 
                                    LEFT JOIN user_comment  as uc 
                                    ON u.id = uc.user
                                    GROUP BY u.id;');
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($users);
        } catch (PDOException $e) {
            $this->errorCode(500);
            echo json_encode(['error' => 'Ocurrió un error al obtener los usuarios. Inténtalo de nuevo más tarde.']);
        }
    }

    public function show($id)
    {
        if (empty($id)) {
            echo json_encode(['message' => 'id es requerido']);
            return;
        }
        try {
            $pdo = $this->Connect();
            $stmt = $pdo->prepare('SELECT fullname, email, pass, openid FROM user WHERE id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            $stmt->execute();
    
            //return one row
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($user);
        }
        catch (PDOException $e) {
            $this->errorCode(500);
            echo json_encode(['error' => 'Ocurrió un error al obtener el usuario.'. $e->getMessage()]);
        }
    }


    public function createUser($data)
    {
        if (empty($data)){
            echo json_encode(['message' => 'parametros incompletos']);
            return;
        }

        try{
            $pdo = $this->Connect();
            $stmt = $pdo->prepare('INSERT INTO user (fullname, email, pass, openid) VALUES (:fullname, :email, :pass, :openid)');

            $stmt->bindParam(':fullname', $data['fullname'], PDO::PARAM_STR);
            $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindParam(':pass', $data['pass'], PDO::PARAM_STR);
            $stmt->bindParam(':openid', $data['openid'], PDO::PARAM_STR);

            $stmt->execute();

            echo json_encode(['message' => 'Usuario creado correctamente.']);
        } catch (PDOException $e) {
            $this->errorCode(500);
            echo json_encode(['error' => 'Ocurrió un error al crear el usuario.' . $e->getMessage()]);
        }
    }

    public function updateUser($data)
    {
        if (empty($data['id']) || empty($data)) {
            echo json_encode(['message' => 'parametros incompletos']);
            return;
        }

        try{
            $pdo = $this->Connect();

            $set = [];

            foreach ($data as $key => $value) {
                if($key == 'id'){
                    continue;
                }

                $set[] = "$key = :$key";
            }
            $set = implode(', ', $set);
            
            $stmt = $pdo->prepare("UPDATE user SET $set WHERE id = :id");

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();

            if($stmt->rowCount() == 0){
                echo json_encode(['message' => 'No se actualizó ningún registro. Verifique los datos ingresados.']);
                return;
            }
            echo json_encode(['message' => 'Usuario Actualizado correctamente.']);
        } catch (PDOException $e) {
            $this->errorCode(500);
            echo json_encode(['error' => 'Ocurrió un error al actualizar el usuario.' . $e->getMessage()]);
        }

        
    }

    public function deleteUser($id)
    {
        if (empty($id)) {
            echo json_encode(['message' => 'id es requerido']);
            return;
        }
        try {
            $pdo= $this->Connect();
            $pdo->beginTransaction();

            $stmt = $pdo->prepare('DELETE FROM user WHERE id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $stmt = $pdo->prepare('DELETE FROM user_comment WHERE user = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $pdo->commit();

            echo json_encode(['message' => 'Usuario Eliminado']);

        } catch (\Exception $e) {
            $pdo->rollBack();
            $this->errorCode(500);
            echo json_encode(['message' => 'Error al eliminar el usuario.'. $e->getMessage()]);
            return;
        }
    }
    
    function errorCode($code){
        return http_response_code($code);
     }
}