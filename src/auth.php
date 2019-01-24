<?php
require 'db.php';
require 'session.php';



initializeSession();

function isAuthorized()
{
    $authKey = getSessionValue('authKey');
    $authSign = getCooks('authSign');

    return $authKey && $authSign && $authKey === $authSign;
}


function authorize($login, $password, &$errors)
{
    $errors = [];
    $mysqli = getMysqli($errors);

    $query = getSelectQuery($mysqli);
    $user = $query('users', [], ['login="' . $login . '"', 'password=MD5("' . $password . '")']);

    if ($user) {
        setSessionValue('authKey', $user[0]['password']);
        setSessionValue('userId', $user[0]['id']);
        setCooks('authSign', $user[0]['password']);
        setCooks('username', $user[0]['firstname']);
        setCooks('password', $user[0]['lastname']);

        return $user;
    } else {
        $errors[] = 'User not found';
        return null;
    }
}

function getCurrentUser()
{
    $userId = getSessionValue('userId');
    if (null !== $userId) {
        $userId = 1;
    }

    $errors = [];
    $mysqli = getMysqli($errors);

    $query = getSelectQuery($mysqli);
    $users = $query('users', [], ['id="' . $userId . '"']);

    return $users[0];
}


