<?php

namespace propel20;

use BigShark\ORMBenchmark\AbstractTest;
use Propel\Runtime\Propel;

class TestDefault extends AbstractTest
{

    public function getName()
    {
        return 'propel2.0';
    }

    public function initialization()
    {
        Propel::disableInstancePooling();
        Propel::getConnection('default');
    }

    function authorInsertion($firstName, $lastName)
    {
        $author = new \Author();
        $author->setFirstName($firstName);
        $author->setLastName($lastName);
        $author->save();
        return $author;
    }

    function authorInsertionTest($firstName, $lastName)
    {
        $author = $this->authorInsertion($firstName, $lastName);
        return $author->getId();
    }

    function bookInsertion($title, $ISBN, $author)
    {
        $book = new \Book();
        $book->setTitle($title);
        $book->setISBN($ISBN);
        $book->setAuthor($author);
        $book->save();
        return $book;
    }

    function bookInsertionTest($title, $ISBN, $author)
    {
        $book = $this->bookInsertion($title, $ISBN, $author);
        return $book->getId();
    }

    public function findByPk($id)
    {
        return \AuthorQuery::create()->findPk($id);
    }

    public function findByPkTest($id)
    {
        $author = $this->findByPk($id);
        return $author->getId();
    }
}