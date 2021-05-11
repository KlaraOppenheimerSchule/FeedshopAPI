<?php


namespace feedshop\http;


class Response implements ResponseInterface
{
    /** @var Header[] */
    private array $headers = [];

    private string $body = '';

    private int $code = 200;


    public function setHeader(Header $header)
    {
        for ($i = 0; $i < count($this->headers); $i++) {
            if ($this->headers[$i]->getKey() === $header->getKey()) {
                $this->headers[$i] = $header;
                return;
            }
        }

        $this->headers[] = $header;
    }

    public function setBody(string $body)
    {
        $this->body = $body;
    }

    public function setResponseCode(int $code)
    {
        $this->code = $code;
    }

    public function send()
    {
        $this->sendHeaders();
        $this->sendResponseCode();
        $this->sendBody();

    }

    private function sendHeaders()
    {
        foreach ($this->headers as $header) {
            header($header->getKey() . ": " . $header->getValue());
        }
    }

    private function sendResponseCode()
    {
        http_response_code($this->code);
    }

    private function sendBody()
    {
        echo $this->body;
    }

}