<?php
namespace Intuit\Bid\Exception;

use Intuit\Http\Response\Exception\ResponseException;

class LowerBidNotMetException extends \RuntimeException implements  ResponseException
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null) {
        if (empty($message)) {
            $message = 'Bid value not lower than current winning bid';
        }
        parent::__construct($message, $code, $previous);
    }

    public function getStatus(): int {
        return 428;
    }
}
