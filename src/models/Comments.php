<?php

namespace Fede\Backend\models;

use Fede\Backend\lib\Database;
use PDO;
use PDOException;

class Comments extends Database
{



    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        try{
            $pdo = $this->Connect();
            $stmt = $pdo->prepare('SELECT id, user, coment_text, likes FROM user_comment');
            $stmt->execute();
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($comments);
        } catch (PDOException $e) {

            $this->errorCode(500);
            echo json_encode(['error' => 'Ocurrió un error al obtener los comentarios.' . $e->getMessage()]);
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
            $stmt = $pdo->prepare('SELECT user, coment_text, likes FROM user_comment WHERE id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            $stmt->execute();
    
            $comment = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($comment);
        } catch (PDOException $e) {
            $this->errorCode(500);
            echo json_encode(['error' => 'Ocurrió un error al obtener el comentario.' . $e->getMessage()]);
        }
        
       
    }

    public function showByUser($id)
    {
        if (empty($id)) {
            echo json_encode(['message' => 'id es requerido']);
            return;
        }
        try{
            $pdo = $this->Connect();
            $stmt = $pdo->prepare('SELECT id, user, coment_text, likes FROM user_comment WHERE user = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            //return one row
            $comment = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($comment);
        } catch (PDOException $e) {
            $this->errorCode(500);
            echo json_encode(['error' => 'Ocurrió un error al obtener el comentario.' . $e->getMessage()]);
        }
       
    }


    public function createComment($data)
    {
        if (empty($data)){
            echo json_encode(['message' => 'parametros incompletos']);
            return;
        }
        try {
            $pdo = $this->Connect();
            $stmt = $pdo->prepare('INSERT INTO user_comment (user, coment_text, likes ) VALUES (:user, :coment_text, :likes)');

            $stmt->bindParam(':user', $data['user'], PDO::PARAM_INT);
            $stmt->bindParam(':coment_text', $data['coment_text'], PDO::PARAM_STR);
            $stmt->bindParam(':likes', $data['likes'], PDO::PARAM_INT);

            $stmt->execute();

            echo json_encode(['message' => 'Comentario creado correctamente.']);
        } catch (PDOException $e) {
            $this->errorCode(500);
            echo json_encode(['error' => 'Ocurrió un error al crear el comentario.' . $e->getMessage()]);
        }
        
    }

    public function updateComment($data)
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
            
            $stmt = $pdo->prepare("UPDATE user_comment SET $set WHERE id = :id");

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();

            if($stmt->rowCount() == 0){
                echo json_encode(['message' => 'comentario no encontrado']);
                return;
            }
            echo json_encode(['message' => 'comentario actualizado correctamente.']);
        } catch (PDOException $e) {
            $this->errorCode(500);
            echo json_encode(['error' => 'Ocurrió un error al actualizar el comentario.' . $e->getMessage()]);
        }

        
    }

    public function deleteComment($id)
    {
        if (empty($id)) {
            echo json_encode(['message' => 'id es requerido']);
            return;
        }
        
        try {
            $pdo = $this->Connect();
            $stmt = $pdo->prepare('DELETE FROM user_comment WHERE id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            echo json_encode(['message' => 'comentario eliminado']);
        } catch (PDOException $e) {
            $this->errorCode(500);
            echo json_encode(['error' => 'Ocurrió un error al eliminar el comentario.' . $e->getMessage()]);
        }
    }

    function errorCode($code){
       return http_response_code($code);
    }
}