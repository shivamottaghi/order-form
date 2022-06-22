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
    if (strlen($_POST['email'])===0){
        array_push($warnArr, 'email'.$message);
    }elseif(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        array_push($warnArr,"Invalid Email Address.");
    }
    if (strlen($_POST['street'])===0){
        array_push($warnArr, 'street'.$message);
    }
    if (strlen($_POST['streetnumber'])===0){
        array_push($warnArr, 'street number'.$message);
    }
    if (strlen($_POST['city'])===2){
        array_push($warnArr, 'city'.$message);
    }
    if (strlen($_POST['zipcode'])===0){
        array_push($warnArr, 'zipcode'.$message);
    }elseif(!filter_var($_POST['zipcode'], FILTER_VALIDATE_INT)){
        array_push($warnArr, 'Invalid ZIP code');
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
    //$alert = implode('<br>', $invalidFields);
    if (!empty($invalidFields)) {
        foreach ($invalidFields as $warning){
            echo '<div class="alert alert-danger" role="alert">';
            echo $warning;
            echo '</div>';
        }
    } else {
        // TODO: handle successful submission
        echo "<div class='container'><div class='row'><div class='col-12 col-md-4 offset-md-4 p-3' style='border: 2px solid #326476'>";
        ///echo "<h2>Your order was successfully submitted!</h2>";
        /// ************** HERE STARTS THE ORDER DETAIL *****************
        echo "<p>";
        echo "<h3>Here is your order detail: </h3>";
        echo "Your Email: " .$_POST['email'] . "<br>";
        echo "Address: ";
        echo generateAddress() ."<br>";
        echo "Products: <br>";
        echo generateProductList($products);
        echo "Total Amount: &euro;";
        echo calculatePrice($products)."<br>";
        echo "</p>";
        ///***************** HERE ENDS THE ORDER DETAIL ******************
        echo "<p>If the information above is correct press confirm otherwise press cancel</p>";
        echo generateButtons();
        //********* to close container and row and col *****
        echo "</div> </div> </div>";
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
function generateButtons(){
    echo "<form method='post' action='index.php'>";
    echo "<button type='confirm' name='confirm' class='btn btn-outline-success btn-sm m-1'>Confirm</button>";
    echo "<button type='cancel' name='cancel' class='btn btn-outline-warning btn-sm m-1'>Cancel</button>";
    echo "</form>";
}
function calculatePrice($products){
    $total = 0;
    foreach ($_POST['products'] as $index => $product){
        $total+= $products[$index]['price'];
    }
    return $total;
}
function confirmation(){
    echo "<div class='container'><div class='row'><div class='col-12 col-md-4 offset-md-4 p-3' style='border: 2px solid #326476'>";
    echo "<h2>Your order was successfully submitted!</h2>";
    //********* to close container and row and col *****
    echo "</div> </div> </div>";
}
function cancelation(){
    echo "<div class='container'><div class='row'><div class='col-12 col-md-4 offset-md-4 p-3' style='border: 2px solid #326476'>";
    echo "<h2>Your order was canceled.</h2>";
    //********* to close container and row and col *****
    echo "</div> </div> </div>";
}
function assignSessionVar(){
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['street'] = $_POST['street'];
    $_SESSION['streetnumber'] = $_POST['streetnumber'];
    $_SESSION['city'] = $_POST['city'];
    $_SESSION['zipcode'] = $_POST['zipcode'];
    if (isset($_POST['products'])){
        foreach ($_POST['products'] as $i => $product){
            $_SESSION['products'][$i] = $product;
        }
    }

}

// TODO: replace this if by an actual check
//$formSubmitted = false;



if (isset($_POST['submit'])) {
    handleForm($products);
    assignSessionVar();
    //$totalValue = calculatePrice($products);
}
if (isset($_POST['newOrder'])){
    session_unset();
}
if (isset($_POST['confirm'])){
    confirmation();
    session_unset();
}
if (isset($_POST['cancel'])){
    cancelation();
    session_unset();
}
require 'form-view.php';



whatIsHappening();