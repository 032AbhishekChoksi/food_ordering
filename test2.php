<?php
session_start();
echo '<pre>';
unset($_SESSION['cart']);
// unset($_SESSION['cart']);

// if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
//     foreach($_SESSION['cart'] as $key=>$val){
//         echo $key;
//         echo "<br>";
//         echo $val['qty'];
//     }
// }
?>