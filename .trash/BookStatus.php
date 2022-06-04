<?php

namespace App\Enums;


enum BookStatus: int
{
        case WANT_TO_READ = 1;
        case READING = 2;
        case READ = 3;

        public function presentTense(): string
        {
                return match($this)
                {
                        self::WANT_TO_READ  => 'Want To Read',
                        self::READING       => 'is reading',
                        self::READ          => 'Read'
                };
        }
}



// $attributes = ['title'  => 'Book Title', 'status' => BookStatus::READING->value];



class Book
{
        public $attributes = [

                'title'         => 'Book Title',
                'status'        => 3

        ];
}

// var_dump((new Book())->attributes['status']);

// $book = new Book();

// // var_dump(BookStatus::from($book->attributes['status'])); // return an error for not valid status from enum class if the status is not exists

// // var_dump(BookStatus::tryFrom($book->attributes['status'])); // return null if status isnt valid

// $response =  [
//         'title'    => 'Book title',
//         'status'   => BookStatus::tryFrom($book->attributes['status'])
// ];

// var_dump(json_encode($response));


$enum = BookStatus::tryFrom(3)->presentTense();

var_dump($enum);
