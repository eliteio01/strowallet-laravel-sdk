<?php
declare(strict_types=1);

namespace Elite\StrowalletLaravel\Exceptions;

use Exception;

class StrowalletException extends Exception
{
    /**
     * Additional details about the error.
     *
     * @var array
     */
    protected $errorDetails;

    /**
     * StrowalletException constructor.
     *
     * @param string $message The error message
     * @param int $code The error code (optional)
     * @param Exception|null $previous The previous exception (optional)
     * @param array $errorDetails Additional error details (optional)
     */
    public function __construct($message = "", $code = 0, Exception $previous = null, array $errorDetails = [])
    {
        parent::__construct($message, $code, $previous);
        $this->errorDetails = $errorDetails;
    }

    /**
     * Get the error details for debugging or logging.
     *
     * @return array
     */
    public function getErrorDetails(): array
    {
        return $this->errorDetails;
    }

    /**
     * String representation of the exception for debugging.
     *
     * @return string
     */
    public function __toString(): string
    {
        return parent::__toString() . " | Error Details: " . json_encode($this->errorDetails);
    }
}
