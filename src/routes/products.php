<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// get all products
$app->get('/products', function(Request $request, Response $response){
    $sql="SELECT * FROM products";
    try{
        $db = new db();
        $db = $db->connect();
        $stmt=$db->query($sql);
        $customers=$stmt->fetchAll(PDO::FETCH_OBJ);
        $db=null;
        echo json_encode($customers);
    }catch(PDOException $e){
        echo '{"error":{"text":'.$e->getMessage().'}}';
    }
});
//get customer
$app->get('/customer/{id}', function(Request $request, Response $response){
    $id=$request->getAttribute('id');
    $sql="SELECT * FROM customers WHERE id=$id";
    try{
        $db = new db();
        $db = $db->connect();
        $stmt=$db->query($sql);
        $customer=$stmt->fetchAll(PDO::FETCH_OBJ);
        $db=null;
        echo json_encode($customer);
    }catch(PDOException $e){
        echo '{"error":{"text":'.$e->getMessage().'}}';
    }
});
//get customer's orders
$app->get('/customer/{id}/orders', function(Request $request, Response $response){
    $id=$request->getAttribute('id');
    $sql="SELECT * FROM orders WHERE customerId=$id";
    try{
        $db = new db();
        $db = $db->connect();
        $stmt=$db->query($sql);
        $customer=$stmt->fetchAll(PDO::FETCH_OBJ);
        $db=null;
        echo json_encode($customer);
    }catch(PDOException $e){
        echo '{"error":{"text":'.$e->getMessage().'}}';
    }
});
// add customer
$app->post('/product/add', function(Request $request, Response $response){
    $productName=$request->getParam('productName');
    $description=$request->getParam('description');
    $stock=$request->getParam('stock');
    $price=$request->getParam('price');
    $tumbImg=$request->getParam('tumbImg');
    $fullImg=$request->getParam('fullImg');
    $category=$request->getParam('category');

    $sql="INSERT INTO products (productName,description,stock,price,tumbImg,fullImg,category) VALUES
          (:productName,:description,:stock,:price,:tumbImg,:fullImg,:category)";
    try{
        $db = new db();
        $db = $db->connect();
        $stmt=$db->prepare($sql);
        $stmt->bindParam(':productName',$productName);
        $stmt->bindParam(':description',$description);
        $stmt->bindParam(':stock',$stock);
        $stmt->bindParam(':price',$price);
        $stmt->bindParam(':tumbImg',$tumbImg);
        $stmt->bindParam(':fullImg',$fullImg);
        $stmt->bindParam(':category',$category);

        $stmt->execute();
        echo '{"notice":{"text":"Product Added"}}';
    }catch(PDOException $e){
        echo '{"error":{"text":'.$e->getMessage().'}}';
    }
});
