<?php

namespace BigShark\ORMBenchmark;

abstract class AbstractTest implements TestInterface
{
    public function run()
    {
        $memory = memory_get_usage();
        $this->initialization();

        $insertAuthor = microtime(true);
        $authors = [];
        for($i = 1; $i<=100; $i++) {
            $authors[] = $this->authorInsertion('FirstName', 'LastName');
        }
        $insertAuthor = microtime(true) - $insertAuthor;

        $insertBook = microtime(true);
        foreach($authors as $author) {
            for($i = 1; $i<=5; $i++) {
                $this->bookInsertion('Title', 'ISBN', $author);
            }
        }
        $insertBook = microtime(true) - $insertBook;

        $findByPk = microtime(true);
        for($i = 1; $i <= 100; $i++) {
            $this->findByPk($i);
        }
        $findByPk = microtime(true) - $findByPk;

        $result = [
            'name' => $this->getName(),
            'memory' => memory_get_usage() - $memory,
            'time' => microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"],
            'insertAuthor' => $insertAuthor,
            'insertBook' => $insertBook,
            'findByPk' => $findByPk,
        ];
        return json_encode($result);
    }
}