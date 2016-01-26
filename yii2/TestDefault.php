<?php

namespace yii2;

use BigShark\ORMBenchmark\AbstractTest;

class TestDefault extends AbstractTest
{
    public function getName()
    {
        return 'Yii2';
    }

    public function initialization()
    {
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        defined('YII_ENV') or define('YII_ENV', 'dev');

        require(__DIR__ . '/vendor/autoload.php');
        require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');

        (
        new \yii\console\Application(
            [
                'id' => 'testapp',
                'basePath' => __DIR__,
                'vendorPath' => __DIR__ . '/vendor/',
                'components' => [
                    'db' => [
                        'class' => 'yii\db\Connection',
                        'dsn' => $_ENV['dsn'],
                        'username' => $_ENV['username'],
                        'password' => $_ENV['password'],
                        'charset' => 'utf8',
                    ],
                ]

            ]
        )
        );
    }

    function authorInsertion($firstName, $lastName)
    {
        $author = new \Author(
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
            ]
        );
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
        $book = new \Book(
            [
                'title' => $title,
                'isbn' => $ISBN,
            ]
        );
        $book->link('author', $author);
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
        return \Author::findOne($id);
    }

    public function findByPkTest($id)
    {
        $author = $this->findByPk($id);
        return $author->getId();
    }
}
