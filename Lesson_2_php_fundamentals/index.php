<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    ini_set('display_errors', 1);
    
    //1
    $name = 'Алексей';
    $age = '29';
    
    echo "Меня зовут $name <br>";
    echo "Мне $age лет <br>";
    unset($name, $age);
    
    //2
    define('CITY', 'Dzerjinsk');
    if(CITY !== null){
        echo CITY;
    }
    define('CITY', 'Emerald City');
    
    //3
    $book = ['tittle' => 'JAVA', 'author' => 'Mett', 'pages' => 200];
    echo 'Недавно я прочитал книгу '.$book['tittle'].', написанную автором '.$book['author'].', я осилил все '.$book['pages'].' страниц, мне она очень понравилась.<br>';
    
    //4
    $book1 = array('tittle' => 'JAVA', 'author' => 'Mett', 'pages' => 200);
    $book2 = array('tittle' => 'JavaScript', 'author' => 'Tom', 'pages' => 100);
    $books = array($book1, $book2);
  		  
   
    echo 'Недавно я прочитал книги '.$books[1]['tittle'].' и '.$books[0]['tittle'].', написанные соответственно авторами '.$books[0]['author'].' и '.$books[1]['author'].', я осилил в сумме '.($books[0]['pages']+$books[1]['pages']).' страниц, не ожидал от себя подобного.';
    
  ?>