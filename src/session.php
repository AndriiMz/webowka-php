<?php

function setCooks($name, $value, $time = false){
    if(!$time){
        $time = time() + 250000;
    }
    setcookie($name, $value, $time , '/');
}

function getCooks($name){
    return $_COOKIE[$name];
}


function deleteCooks($name){
    setcookie($name, '', time() - 3600,'/');
}

function initializeSession()
{
    session_start();
    setCooks('sessionId', session_id());
}


function destroySession()
{
    session_destroy();
}


function setSessionValue($key, $value){
    $_SESSION[$key] = $value;
}

function getSessionValue($key) {
    return $_SESSION[$key];
}

function deleteSessionValue($key) {
    unset($_SESSION[$key]);
}