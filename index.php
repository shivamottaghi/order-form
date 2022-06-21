<?php

// This file is your starting point (= since it's the index)
// It will contain most of the logic, to prevent making a messy mix in the html

// This line makes PHP behave in a more strict way
declare(strict_types=1);

// We are going to use session variables so we need to enable sessions
session_start();

// Use this function when you need to need an overview of these variables
function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

// TODO: provide some products (you may overwrite the example)
$products = [
    ['name' => 'Simple Cookie', 'price' => 1.00],
    ['name' => 'Chocolate Chip Cookie', 'price' => 1.50],
    ['name' => 'Oatmeal Raisin Cookie', 'price' => 1.00],
    ['name' => 'Gingersnaps', 'price' => 1.25],
    ['name' => 'php Cookie', 'price' => 0.75],
];

$totalValue = 0;

function validate()
{
    // TODO: This function will send a list of invalid fields back
    $warnArr = [];
    $message = ' field is required';
    if (strlen($_POST['email'])<2){
        array_push($warnArr, 'email'.$message);
    }
    if (strlen($_POST['street'])==0){
        array_push($warnArr, 'street'.$message);
    }
    if (strlen($_POST['streetnumber'])==0){
        array_push($warnArr, 'street number'.$message);
    }
    if (strlen($_POST['city'])<2){
        array_push($warnArr, 'city'.$message);
    }
    if (strlen($_POST['zipcode'])<2){
        array_push($warnArr, 'zipcode'.$message);
    }
    if (empty($_POST['products'])){
        array_push($warnArr, 'You need to choose one of our products!');
    }
    return $warnArr;
}

function handleForm($products)
{
    // TODO: form related tasks (step 1)

    // Validation (step 2)
    $invalidFields = validate();
    $alert = implode('<br>', $invalidFields);
    if (!empty($invalidFields)) {
        echo $alert;
    } else {
        // TODO: handle successful submission
        echo "<h2>Your order was successfully submitted!</h2>";
        echo "<h3>Here is your order detail: </h3>";
        echo "Address: ";
        echo generateAddress() ."<br>";
        echo "Products: <br>";
        echo generateProductList($products);
        echo "Total Amount: &euro;";
        echo calculatePrice($products);
        //echo "";
    }
}
function generateAddress (){
    return $_POST['street']." ".$_POST['streetnumber'].", ".$_POST['city'].", ".$_POST['zipcode'];
}
function generateProductList($products){
    $productList = "";
    $i = 1;
    foreach ($_POST['products'] as $index => $product){
        $productList .= $i .". " .$products[$index]['name'].'&emsp;&euro;'.$products[$index]['price'] ."<br>";
        $i++;
    }
    return $productList;
}
function calculatePrice($products){
    $total = 0;
    foreach ($_POST['products'] as $index => $product){
        $total+= $products[$index]['price'];
    }
    return $total;
}
// TODO: replace this if by an actual check
$formSubmitted = false;



if (isset($_POST['submit'])) {
    handleForm($products);
}
require 'form-view.php';
//whatIsHappening();