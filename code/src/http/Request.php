<?php


namespace feedshop\http;


use InvalidArgumentException;
use feedshop\http\exception\UnsupportedHttpMethodException;
use feedshop\http\wrapper\FileWrapper;
use feedshop\http\wrapper\ServerWrapper;
use feedshop\http\wrapper\VariablesWrapper;

class Request implements RequestInterface
{
    private ServerWrapper $serverWrapper;

    private VariablesWrapper $variablesWrapper;

    private FileWrapper $fileWrapper;

    private HttpFactory $factory;

    /** @var Header[] */
    private array $headers;

    public function __construct(
        ServerWrapper $serverWrapper,
        VariablesWrapper $variablesWrapper,
        FileWrapper $fileWrapper,
        HttpFactory $factory
    ) {
        $this->serverWrapper = $serverWrapper;
        $this->variablesWrapper = $variablesWrapper;
        $this->fileWrapper = $fileWrapper;
        $this->factory = $factory;
        $this->headers = $this->loadHeader();
    }

    public function getHeader(string $key): Header
    {
        foreach ($this->headers as $header) {
            if ($header->getKey() === $key) return $header;
        }
        throw new InvalidArgumentException("Header with $key does not exists");
    }

    public function getBody(): string
    {
        return $this->fileWrapper->getRequestBody();
    }

    public function getQueryParam(string $key): string
    {
        if (strtolower($this->getHttpMethod()) === "post") {
            return $this->variablesWrapper->getPostParam($key);
        }

        if (strtolower($this->getHttpMethod()) === "get") {
            return $this->variablesWrapper->getGetParam($key);
        }

        throw new UnsupportedHttpMethodException("QueryParams only supported for GET and POST requests");
    }

    public function getHttpMethod(): string
    {
        return $this->serverWrapper->getRequestMethod();
    }

    public function getRequestUri(): Uri
    {
        return $this->factory->createUri($this->serverWrapper->getRequestUri());
    }

    /**
     * @return Header[]
     */
    private function loadHeader(): array
    {
        $requestHeader = $this->serverWrapper->getRequestHeader();
        $headers = [];

        foreach ($requestHeader as $key => $value) {
            $headers[] = $this->factory->createHeader($key, $value);
        }

        return $headers;
    }

}