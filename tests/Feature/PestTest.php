<?php


beforeAll(fn() => var_dump('beforeAll'));
beforeEach(fn() => var_dump('beforeEach'));
afterEach(fn() => var_dump('afterEach'));
afterAll(fn() => var_dump('afterAll'));


test('test 1', fn() => var_dump('test 1'));