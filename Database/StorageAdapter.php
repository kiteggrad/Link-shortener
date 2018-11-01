<?php
require_once 'DB.php';

class StorageAdapter
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Ищет ссылку в базе данных по id
     *
     * @param int $id
     * @return bool|array
     */
    public function findById(int $id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM links WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $link = $stmt->fetch($this->pdo::FETCH_ASSOC);

        return $link;
    }

    /**
     * Ищет ссылку в базе данных
     *
     * @param string $url
     * @return bool|array
     */
    public function search(string $url)
    {

        $stmt = $this->pdo->prepare('SELECT * FROM links WHERE link = :url');
        $stmt->execute([':url' => $url]);
        $link = $stmt->fetch($this->pdo::FETCH_ASSOC);

        return $link;
    }

    /**
     * Сохраняет ссылку в базе данных
     * возвращет id записи
     *
     * @param string $url
     * @return int
     */
    public function save(string $url): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO links(link) VALUES (:url)');
        $stmt->execute([':url' => $url]);
        $id = $this->pdo->lastInsertId();

        return $id;
    }
}