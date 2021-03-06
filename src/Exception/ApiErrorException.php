<?php

namespace App\Exception;

use App\Exception\HttpException;
use App\Renderable;
use App\View;
use function Helpers\printArray;
use Throwable;

class ApiErrorException extends HttpException implements Renderable
{
    /**
     * Метод выводит шаблон Errors.php
     */
    public function render()
    {

        $data['message'] = $this->getMessage();
        $data['title'] = 'Ошибка API';

        (new View('error', $data))->render();
    }
}
