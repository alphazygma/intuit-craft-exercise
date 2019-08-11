<?php
namespace Intuit\Http\Response\Exception;

interface ResponseException extends \Throwable
{
    public function getStatus() : int;
}
