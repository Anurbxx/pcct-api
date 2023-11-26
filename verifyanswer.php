<?php
include 'db.php';

try {

    function verifyAnswer($connection, $nomeUsuario, $resposta) {
        $sql = "SELECT cadastro.nome_usuario, pergunta_rec.resposta FROM cadastro, pergunta_rec WHERE cadastro.nome_usuario = :nomeUsuario and pergunta_rec.resposta = :resposta;";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':nomeUsuario', $nomeUsuario, PDO::PARAM_STR);
        $stmt->bindParam(':resposta', $resposta, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() === 1;
    }

    // Rota para verificar a disponibilidade do nome de usuário
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $data = json_decode(file_get_contents("php://input"), true);
        $nomeUsuario = $data['nomeUsuario'];
        $resposta = $data['resposta'];
        $response = verifyAnswer($connection, $nomeUsuario, $resposta);

        echo json_encode(['check' => $response]);

    }
    } catch (PDOException $e) {
        echo "Erro de conexão com o banco de dados: " . $e->getMessage();
    }
?>
