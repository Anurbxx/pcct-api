<?php
 try {
    include 'db.php';
     
     // Getting the received JSON into $json variable.
    $json = file_get_contents('php://input');
     
     // decoding the received JSON and store into $obj variable.
    $obj = json_decode($json,true);
     
     // Populate User name from JSON $obj array and store into $name.
    $nome = $obj['nome'];
    $nomeUsuario = $obj['nomeUsuario'];
    $senha = $obj['senha'];
    $pergunta = $obj['pergunta'];
    $resposta = $obj['resposta'];

    $statement_insert_cad = $connection->prepare('INSERT INTO cadastro(nome_usuario, nome, senha) VALUES (:nomeUserGet, :nomeGet, :senhaGet)');
    $statement_insert_cad->bindParam(':nomeUserGet', $nomeUsuario);
    $statement_insert_cad->bindParam(':nomeGet', $nome);
    $statement_insert_cad->bindParam(':senhaGet', $senha);
    $statement_insert_cad->execute();

    $statement_insert_perg = $connection->prepare('INSERT INTO pergunta_rec(pergunta, resposta, user_cadastro) VALUES (:perguntaGet, :respostaGet, :userCadastroGet)');
    $statement_insert_perg->bindParam(':perguntaGet', $pergunta);
    $statement_insert_perg->bindParam(':respostaGet', $resposta);
    $statement_insert_perg->bindParam(':userCadastroGet', $nomeUsuario);
    $statement_insert_perg->execute();

    $MSG = 'Successful';
    $json = json_encode($MSG);
    echo $json;
    } catch (PDOException $e) {
        echo json_encode("Erro: " . $e->getMessage());
    }
?>