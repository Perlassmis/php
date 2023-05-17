//author rumeysa bakar 29.04.23



<?php
// Connect to the database
$host = 'your_host';
$password = 'your_password';
$user = 'your_username';
$db = 'your_database';


$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);

// Handle POST requests for creating orders
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'create_order') {
    // Retrieve the order details from the request
    $customerName = $_POST['customer_name'];
    $pizzaType = $_POST['pizza_type'];
    $pizzaSize = $_POST['pizza_size'];
    $toppings = $_POST['toppings'];

    // Insert the order into the database
    $stmt = $pdo->prepare('INSERT INTO orders (customer_name, pizza_type, pizza_size, toppings, status) VALUES ( ?, ?, ?, ?)');
    $stmt->execute([$customerName, $pizzaType, $pizzaSize, $toppings, 'pending']);

    // Return a success message
    $response = [
        'message' => 'Order created successfully'
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'get_orders') {
    // Retrieve orders from the database
    $stmt = $pdo->query('SELECT * FROM orders');
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    header('Content-Type: application/json');
    echo json_encode($orders);
}
?>
