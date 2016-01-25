<?php

namespace eloquent;

use BigShark\ORMBenchmark\AbstractTest;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Events\Dispatcher;

class TestDefault extends AbstractTest
{
    /**
     * @var Manager
     */
    protected $capsule;

    public function getName()
    {
        return 'Eloquent';
    }

    public function initialization()
    {
        $capsule = new Manager() ;

        $capsule->addConnection([
            'driver'    => $_ENV['driver'],
            'host'      => $_ENV['host'],
            'database'  => $_ENV['database'],
            'username'  => $_ENV['username'],
            'password'  => $_ENV['password'],
            'port'      => $_ENV['port'],
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        // Set the event dispatcher used by Eloquent models... (optional)
        $capsule->setEventDispatcher(new Dispatcher(new Container()));

        // Make this Capsule instance available globally via static methods... (optional)
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $capsule->bootEloquent();

        $this->capsule = $capsule;
    }

    function authorInsertion($firstName, $lastName)
    {
        $author = new \Author();
        $author->first_name = $firstName;
        $author->last_name = $lastName;
        $author->save();
        return $author;
    }

    function authorInsertionTest($firstName, $lastName)
    {
        $author = $this->authorInsertion($firstName, $lastName);
        return $author->id;
    }

    function bookInsertion($title, $ISBN, $author)
    {
        $book = new \Book();
        $book->title = $title;
        $book->isbn = $ISBN;
        $book->author()->associate($author);
        $book->save();
        return $book;
    }

    function bookInsertionTest($title, $ISBN, $author)
    {
        $book = $this->bookInsertion($title, $ISBN, $author);
        return $book->id;
    }

    public function findByPk($id)
    {
        return \Author::find($id);
    }

    public function findByPkTest($id)
    {
        $author = $this->findByPk($id);
        return $author->id;
    }
}