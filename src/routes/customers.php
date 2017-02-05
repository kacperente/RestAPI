<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// get all customers
$app->get('/customers', function(Request $request, Response $response){
    $sql="SELECT * FROM customers";
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

// add customer
$app->post('/customer/add', function(Request $request, Response $response){
    $first_name=$request->getParam('first_name');
    $last_name=$request->getParam('last_name');
    $phone=$request->getParam('phone');
    $email=$request->getParam('email');
    $address=$request->getParam('address');
    $city=$request->getParam('city');
    $state=$request->getParam('state');

    $sql="INSERT INTO customers (first_name,last_name,phone,email,address,city,state) VALUES
          (:first_name,:last_name,:phone,:email,:address,:city,:state)";
    try{
        $db = new db();
        $db = $db->connect();
        $stmt=$db->prepare($sql);
        $stmt->bindParam(':first_name',$first_name);
        $stmt->bindParam(':last_name',$last_name);
        $stmt->bindParam(':phone',$phone);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':address',$address);
        $stmt->bindParam(':city',$city);
        $stmt->bindParam(':state',$state);

        $stmt->execute();
        echo '{"notice":{"text":"Customer Added"}}';
    }catch(PDOException $e){
        echo '{"error":{"text":'.$e->getMessage().'}}';
    }
});