<?php

namespace pdo;

use BigShark\ORMBenchmark\AbstractTest;

class TestDefault extends AbstractTest
{

    /**
     * @var \PDO
     */
    protected $con;

    public function getName()
    {
        return 'PDO';
    }

    public function initialization()
    {
        $this->con = new \PDO($_ENV['dsn'], $_ENV['username'], $_ENV['password']);
    }

    function authorInsertion($firstName, $lastName)
    {
        $query = 'INSERT INTO author (first_name, last_name) VALUES (?, ?)';
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(1, $firstName);
        $stmt->bindParam(2, $lastName);
        $stmt->execute();
        $author = [
            'id' => $this->con->lastInsertId(),
            'firstName' => $firstName,
            'lastName' => $lastName,
        ];
        return $author;
    }

    function authorInsertionTest($firstName, $lastName)
    {
        $author = $this->authorInsertion($firstName, $lastName);
        return $author['id'];
    }

    function bookInsertion($title, $ISBN, $author)
    {
        $query = 'INSERT INTO book (title, isbn, author_id) VALUES (?, ?, ?)';
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(1, $title);
        $stmt->bindParam(2, $ISBN);
        $stmt->bindParam(3, $author['id'], \PDO::PARAM_INT);
        $stmt->execute();
        $book = [
            'id' => $this->con->lastInsertId(),
            'title' => $title,
            'isbn' => $ISBN,
            'author' => $author,
        ];
        return $book;
    }

    function bookInsertionTest($title, $ISBN, $author)
    {
        $book = $this->bookInsertion($title, $ISBN, $author);
        return $book['id'];
    }

    public function findByPk($id)
    {
        $query = 'SELECT author.id, author.first_name, author.last_name FROM author WHERE author.id = ? LIMIT 1';
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function findByPkTest($id)
    {
        $author = $this->findByPk($id);
        return $author['id'];
    }
}
