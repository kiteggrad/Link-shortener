<?php

class Link
{
    /**
     * @var string
     */
    private $link;

    public function __construct(string $link)
    {
        $this->link = $link;
    }

    /**
     * Возвращает представление ссылки из данных полученных с хранилища
     *
     * @param array $state
     * @return Link
     */
    public static function fromState(array $state) : Link
    {
        return new self($state['link']);
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }
}