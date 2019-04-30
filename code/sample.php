#!/usr/local/bin/php

<?php
require __DIR__ . '/vendor/autoload.php';

$API_KEY = 'XX';
$authy = new Authy\AuthyApi($API_KEY);

//
// TODO: Add docs for sample app and check arguments
//

if(is_callable($argv[1])) {
    $argv[1]($authy, $argv);
} else {
    usage();
}

function registerUser($authy, $argv) {
    $user = $authy->registerUser($argv[2], $argv[3], $argv[4]);
    if($user->ok()) {
        echo "Authy id: {$user->id()}\n";
        return;
    }
    error($user);
}

function totpVerify($authy, $argv){
    $verification = $authy->verifyToken($argv[2], $argv[3]);
    if($verification->ok()) {
        echo "Verification: {$verification->message()}\n";
        return;
    }
    error($verification);
}

function requestSms($authy, $argv) {
    $sms = $authy->requestSms($argv[2]);
    if($sms->ok()) {
        echo "SMS: {$sms->message()}\n";
        return;
    }
    error($sms);
}

function userStatus($authy, $argv){
    $status = $authy->userStatus($argv[2]);
    if($status->ok()) {
        echo "User status: {$status->message()}\n";
        return;
    }
    error($status);
}

function verifyStart($authy, $argv) {
    $verify = $authy->phoneVerificationStart($argv[2], $argv[3], $argv[4]);
    if($verify->ok()) {
        echo "Verify: {$verify->message()}\n";
        return;
    }
    error($verify);
}

function verifyCheck($authy, $argv) {
    $verify = $authy->phoneVerificationCheck($argv[2], $argv[3], $argv[4]);
    if($verify->ok()) {
        echo "Verify: {$verify->message()}\n";
        return;
    }
    error($verify);
}

function usage() {
    echo "usage: sample-app [command]\n";
    echo "Commands:\n";
    echo "  registerUser\tRegister a user in the authy app\n";
    echo "  totpVerify\tVerify a TOTP for the given user\n";
    echo "  requestSms\tSend TOTP via sms to the given user\n";
    echo "  userStatus\tGet user status\n";
    echo "  verifyStart\tStart phone verification\n";
    echo "  verifyCheck\tCheck phone verification\n";
}

function error($obj) {
    echo "\e[31mSomething went wrong!\n\e[0m";
    foreach($obj->errors() as $field => $message) {
        printf("  $field = $message\n");
    }
}
