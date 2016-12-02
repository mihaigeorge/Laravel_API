<?php 

namespace App\Exceptions;

use Exception;

class APIException extends Exception
{   
    /**
     * @var array
     */
    protected $errors;

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @param string|array $errors
     * @param int $statusCode
     */
    public function __construct($errors, $statusCode) 
    {
        $this->errors = $errors;
        $this->statusCode = $statusCode;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}