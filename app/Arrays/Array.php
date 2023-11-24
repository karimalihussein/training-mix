<?php

declare(strict_types=1);

// Array Destructuring in PHP
$params = [10, 20, 30];
[$a, $b, $c] = $params;
// var_dump($a, $b, $c);

// Array Destructuring with keys
$params = [
    'name' => 'John',
    'age' => 30,
    'city' => 'New York',
];

['name' => $name, 'age' => $age, 'city' => $city] = $params;
// var_dump($name, $age, $city);

// Array Destructuring with keys and default values
$params = [
    'name' => 'John',
    'age' => 30,
    'city' => 'New York',
];
['name' => $name, 'age' => $age, 'city' => $city, 'country' => $country] = $params + ['country' => 'USA'];

$names = ['John', 'Jane', 'Jack'];
// dd($names[0], $names[1], $names[2]);

$people = [
    ['id' => 1, 'first_name' => 'John', 'last_name' => 'Doe', 'age' => 30],
    ['id' => 2, 'first_name' => 'Jane', 'last_name' => 'Doe', 'age' => 25],
    ['id' => 3, 'first_name' => 'Jack', 'last_name' => 'Doe', 'age' => 20],
    ['id' => 4, 'first_name' => 'Jill', 'last_name' => 'Doe', 'age' => 18],
    ['id' => 5, 'first_name' => 'Jenny', 'last_name' => 'Doe', 'age' => 15],
];

// $people = array_map(function ($person) {
//     return [
//         'id' => $person['id'],
//         'name' => $person['first_name'] . ' ' . $person['last_name'],
//         'age' => $person['age'],
//     ];
// }, $people);

// $people = array_map(function($person, $index,$number) {
//     var_dump($number);die;
//     return [
//         'id' => $person['id'],
//         'name' => $person['first_name'] . ' ' . $person['last_name'],
//         'age' => $person['age'],
//         'index' => $index,
//     ];
// }, $people, array_keys($people), [10,20,30,40,50]);

// print_r($people);

class Item
{
    protected $cost;

    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    public function getCost()
    {
        return $this->cost;
    }
}

class Cart
{
    protected $items = [];

    public function addItem(Item $item)
    {
        $this->items[] = $item;

        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function total()
    {
        return array_sum(array_map(function ($item) {
            return $item->getCost();
        }, $this->getItems()));
    }
}

$item1 = (new Item())->setCost(10);
$item2 = (new Item())->setCost(20);
$item3 = (new Item())->setCost(30);

$cart = (new Cart())
    ->addItem($item1)
    ->addItem($item2)
    ->addItem($item3);

// echo $cart->total();

// how to use array filter
$users = [
    ['username' => 'alex', 'score' => 0],
    ['username' => 'ahmed', 'score' => 0],
    ['username' => 'ali', 'score' => 50],
    ['username' => 'ramy', 'score' => 50],
];

// remove users with score 0
$users = array_filter($users, function ($user) {
    return $user['score'] > 0; // here must return true or false
});

// print_r($users);

$scores = [
    10,
    20,
    30,
    40,
    null,
    'karim',
    50,
    [111],
    false,
    10.20,
    date('Y-m-d'),
    -10,

];

// get only integers
$scores = array_filter($scores, function ($score) {
    return is_int($score);
});

// print_r($scores);
