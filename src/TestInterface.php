<?php

namespace BigShark\ORMBenchmark;

interface TestInterface
{
    function initialization();

    function getName();

    function authorInsertion($firstName, $lastName);
    function authorInsertionTest($firstName, $lastName);

    function bookInsertion($title, $ISBN, $author);
    function bookInsertionTest($title, $ISBN, $author);

    function findByPk($id);
    function findByPkTest($id);
}