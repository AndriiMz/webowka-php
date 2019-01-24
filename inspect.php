<?php
require 'src/db.php';
require 'src/session.php';

initializeSession();

echo '<h3>Session values</h3>';
if ($_SESSION) foreach ($_SESSION as $key => $value) {
    echo sprintf('%s: %s%s', $key, $value, PHP_EOL);
}

echo '<h3>Cookies values</h3>';
if ($_COOKIE) foreach ($_COOKIE as $key => $value) {
    echo sprintf('%s: %s%s', $key, $value, PHP_EOL);
}

$mysqli = getMysqli($errors);

$query = getSelectQuery($mysqli);
$users = $query('users', [], []);
echo '<h3>Database users table</h3>';
echo '<table><thead><tr><td>Id</td><td>Login</td><td>First name</td><td>Last name</td><td>Email</td></tr></thead><tbody>';
foreach ($users as $user) {
    echo sprintf(
        '<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',
            $user['id'],
            $user['login'],
            $user['firstname'],
            $user['lastname'],
            $user['email']
        );
}
echo '</tbody></table>';