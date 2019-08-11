<?php
namespace Intuit\Http\Response\Exception;

class InvalidInputException extends \RuntimeException implements  ResponseException
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null) {
        if (empty($message)) {
            $message = 'Invalid Input';
        }
        parent::__construct($message, $code, $previous);
    }

    public function getStatus(): int {
        return 400;
    }
}
