<?php

namespace One\Exceptions;

class Handler
{
    public static function render(HttpException $e)
    {
        $code = $e->getCode();
        if ($code === 0) {
            $code = 1;
        }
        $e->response->code($code);

        if ($e->response->getHttpRequest()->isJson()) {
            return $e->response->json(format_json($e->getMessage(), $code, $e->response->getHttpRequest()->id()));
        } else {
            $file = _APP_PATH_VIEW_ . '/exceptions/' . $code . '.php';
            if (file_exists($file)) {
                return $e->response->tpl('exceptions/' . $code, ['e' => $e]);
            } else {
                return $e->response->json(format_json($e->getMessage(), $code, $e->response->getHttpRequest()->id()));
            }
        }
    }
}

