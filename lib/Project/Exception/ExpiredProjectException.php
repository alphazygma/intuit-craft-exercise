<?php
namespace Intuit\Project\Exception;

use Intuit\Http\Response\Exception\ResponseException;

class ExpiredProjectException extends \RuntimeException implements  ResponseException
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null) {
        if (empty($message)) {
            $message = 'The project is expired';
        }
        parent::__construct($message, $code, $previous);
    }

    public function getStatus(): int {
        return 400;
    }
}
