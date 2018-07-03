<?php
    $servername = "localhost";
    $dbname = "ecommerce";
    $username = "root";
    $password = "";
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", 
            $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec("set names utf8");
        
        
        if(isset($_GET['retornar_imagem'])) {
            // Consulta com imagem
            $stmt = $conn->prepare("
                SELECT p.id, 
                       p.nome, 
                       p.descricao, 
                       p.preco, 
                       p.dt_alteracao, 
                       p.categoria_id,
                       i.tipo,
                       i.imagem
                FROM produto p
            INNER JOIN  imagem_produto i ON i.produto_id = p.id
              WHERE p.categoria_id = :IdCategoria
            ");
            
            $stmt->bindParam(':IdCategoria', $_GET['categoria']);
            $stmt->execute();
        
            $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach($lista as $key => $value) {
                $lista[$key]['imagem'] = "data:image/" . $value['tipo'] . 
                    ";base64, " . base64_encode($value['imagem']);
            }
            
            
            
        } else {
            $stmt = $conn->prepare("
                SELECT p.id, 
                       p.nome, 
                       p.descricao, 
                       p.preco, 
                       p.dt_alteracao, 
                       p.categoria_id
                FROM produto p
              WHERE p.categoria_id = :IdCategoria
            ");
            
            $stmt->bindParam(':IdCategoria', $_GET['categoria']);
            $stmt->execute();
        
            $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
       
        
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        
        echo json_encode($lista);
        
        
        
    } catch(Exception $e) {
        echo "Erro na consulta de produtos. " . 
            $e->getMessage();
    }


?>