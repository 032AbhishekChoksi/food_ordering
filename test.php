<?php
$password = "admin";

// echo password_hash($password,PASSWORD_BCRYPT);
$str = '$2y$10$hjwLUJt5JwMF3lZf4dr7Lei3nDsVODxR9BEPyRzVXQJpPoK.OeRyG';
if (password_verify($password, $str)) {
    echo 'Yes';
} else {
    echo 'No';
}
