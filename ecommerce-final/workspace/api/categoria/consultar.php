<?php 
    $servername = "localhost";
    $dbname = "ecommerce";
    $username = "root";
    $password = "";
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec("set names utf8");
        
        $lista = array();
        
        if(isset($_GET['retornar_imagem']) && $_GET['retornar_imagem'] == 'sim') {
             $stmt = $conn->prepare("
                SELECT id,
                       nome,
                       i.tipo,
                       i.imagem
                  FROM categoria c
              inner join imagem_categoria i 
                 on i.categoria_id = c.id
            ");
            
            $stmt->execute();
            $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach($lista as $key => $value) {
                $lista[$key]['imagem'] = "data:image/" . $value['tipo'] . 
                    ";base64, " . base64_encode($value['imagem']);
            }
        } else {
            $stmt = $conn->prepare("
                SELECT id,
                       nome
                  FROM categoria c
            ");
            
            $stmt->execute();
            $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        //print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
        
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        
        echo json_encode($lista);
        exit();
    }catch(Exception $e) {
        echo "Erro na consulta de categorias. " . $e->getMessage();
    }
?>