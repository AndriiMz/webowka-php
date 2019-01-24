<?php
require 'src/auth.php';


function render($templatePath, $arguments) {
    echo vsprintf(file_get_contents($templatePath), $arguments);
}

if (isAuthorized()) {
    $user = getCurrentUser();

    render('home.html', [
        '',
        $user['firstname'],
        $user['lastname'],
        $user['login'],
        $user['email']
    ]);

} else {
    echo '<h3>Not found!</h3>';
}



