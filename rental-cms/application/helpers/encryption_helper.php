<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function encrypt_sha1($string)
{
    return sha1($string);
}

function encrypt_md5($string)
{
    return md5($string);
}

function encrypt_password($password)
{
    $private_key = 'my_secret_key';

    $sha1 = encrypt_sha1($password);
    
    $combined = $sha1 . $private_key;

    $final = encrypt_md5($combined);

    return $final;
}