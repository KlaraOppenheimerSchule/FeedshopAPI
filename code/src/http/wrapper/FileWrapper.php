<?php


namespace feedshop\http\wrapper;


class FileWrapper
{
    public function getRequestBody(): string
    {
        return file_get_contents('php://input');
    }
}