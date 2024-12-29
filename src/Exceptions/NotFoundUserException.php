<?php

namespace App\Exceptions;

class NotFoundUserException extends \Exception
{
    protected $message = "User not found!";
}