<?php
require_once 'Link.php';

class LinkMapper
{
    /**
     * @var StorageAdapter
     */
    private $adapter;

    public function __construct(StorageAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Сохраняет ссылку в базе данных
     * возвращет id записи
     *
     * @param string $url
     * @return int
     */
    public function saveLink(string $url): int
    {
        $link = $this->adapter->search($url);

        if($link) {
            return $link['id'];
        }
        $id = $this->adapter->save($url);

        return $id;
    }


    /**
     * Ищет ссылку в базе данных
     *
     * @param string $url
     * @return bool|Link
     */
    public function search(string $url)
    {
        $link = $this->adapter->search($url);
        if($link) {//todo
            $link = $this->rowToLink($link);
        }

        return $link;
    }

    /**
     * Ищет ссылку в базе данных по id
     *
     * @param int $id
     * @return bool|Link
     */
    public function findById(int $id)
    {
        $link = $this->adapter->findById($id);
        if($link) {//todo
            $link = $this->rowToLink($link);
        }

        return $link;
    }


    private function rowToLink(array $link): Link
    {
        return Link::fromState($link);
    }
}