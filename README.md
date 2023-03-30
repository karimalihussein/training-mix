# Laravel Concepts

This document provides an overview of some important concepts in Laravel, a popular PHP web application framework.

### Middleware

Middleware functions run before a request hits the router. The handle() method contains the main logic of the middleware, while the terminate() method contains the "clean up" logic just before the app is shut down. The Kernel is responsible for passing the request to the router through middleware. The Kernel bootstrap the application by setting up:

- Environment Variables
- Configuration
- Exception Handling
- Registering Facades and Service Providers

### Service Container and Service Providers 
The service container is a powerful tool for managing class dependencies and performing dependency injection. The service container is used throughout Laravel to resolve dependencies for your controllers, routes, queue jobs, and more. The service container is also responsible for resolving middleware and registering facades.

Service Providers are classes that instruct Laravel on how to instantiate a Service/Class. The register() method is where we define our class binding, and the boot() method is called after all Services are registered. We need to put our Service Provider in the provider array in the app config file to activate it. Otherwise, Laravel will automatically resolve the Service on its own using the 'Automatic Resolution feature.

### Facades

In Laravel, a facade is a design pattern that provides a simple and static interface to a complex system, allowing developers to access its functionality without having to understand its underlying implementation. Facades provide a convenient way to access Laravel's various components, such as the database, caching, and session systems, without having to manually instantiate and configure them. Facades are "static proxies" to underlying classes in the service container, providing the benefit of a terse, expressive syntax while maintaining more testability and flexibility than traditional static methods.

### Contracts

Contracts are interfaces that define the core services provided by the framework. They serve as a set of guidelines for how various parts of the framework should interact with each other. Contracts are not bound to a single implementation. For example, the Illuminate\Contracts\Mail\Mailer contract may be implemented by the Illuminate\Mail\Mailer class, which uses Swift Mailer to send e-mail messages, or by the Illuminate\Mail\SendmailMailer class, which uses the native PHP mail() function to send messages.

### Eloquent ORM

Eloquent is the Laravel ORM (Object Relational Mapper). It provides a beautiful, simple ActiveRecord implementation for working with your database. Each database table has a corresponding "Model" which is used to interact with that table. Models allow you to query for data in your tables, as well as insert new records into the table.

### Artisan CLI

Artisan is the command-line interface included with Laravel. It provides a number of helpful commands that can assist you while you build your application. All of the Artisan commands are stored in the app/Console/Commands directory. You may create your own commands and place them in this directory as well. To see a list of all available Artisan commands, you may use the list command:

```bash
php artisan list
```

### Routing

Routing is the process of matching an incoming HTTP request to a route and then executing the route's associated controller action. Routes are defined in the routes/web.php file. These routes are assigned to controllers which receive the incoming request and perform the necessary actions. The routes/web.php file defines routes that are for your web interface. These routes are assigned the web middleware group, which provides features like session state and CSRF protection. The routes/api.php file defines routes that are for your API. These routes are assigned the api middleware group, which provides features like rate limiting.

Route groups can help us to effectively organise our API routes. We can either use the array syntax or the method syntax to define a route group. We can add URL prefix, route name prefix, namespace and middleware to a route group. The where() method is useful to add matching constraint to URL parameters.

# Laravel Exceptions and Error Handling

### Exceptions
Exceptions are a way to handle errors in our application. We can throw exceptions in our code to indicate that something went wrong. We can also catch exceptions to handle them gracefully. Laravel provides a number of exception classes that we can use to throw exceptions. We can also create our own exception classes to handle specific errors in our application.

- Creating custom exception classes in our app
can ensure consistent API responses for error
handling.

- The report() method is responsible for
reporting or logging the exception.

- The render() method is responsible to send the
error back to the HTTP client.

- The abort() helper function is a quick way
to send back an error response.

- The report() helper function calls the report()
method in the specified exception class.

### Events
Events are a way to decouple our application. We can use events to trigger actions in our application. For example, we can use events to trigger an email to be sent when a user is created. Events are defined in the app/Events directory. We can use the event:generate command to generate an event class.

### Listeners
Listeners are classes that handle events. Listeners are defined in the app/Listeners directory. We can use the event:generate command to generate a listener class.

## Unit Testing
 Unit tests are used to test individual units of code. For example, we can test a function to ensure that it returns the correct value. Unit tests are defined in the tests/Unit directory. We can use the make:test command to generate a unit test class.

 - The setUp() method is called before each test
 - The tearDown() method is called after each test

### Feature Testing
Feature tests are used to test the application as a whole. For example, we can test that a user can login to the application. Feature tests are defined in the tests/Feature directory. We can use the make:test command to generate a feature test class.

## End to End Testing
End to end tests are used to test the application as a whole. For example, we can test that a user can login to the application. End to end tests are defined in the tests/Browser directory. We can use the make:test command to generate an end to end test class.

- Unit testing is the notion of testing the
smallest units/building blocks in our app i.e.
functions. If the building blocks are working,
then the app should work. (this is not
necessarily true)

- Feature testing focuses on the feature and
outcome rather than the individual functions.
It is more reliable than unit testing but slower.

- End-to-end testing mocks the end
users' behavior and has the highest reliability.
However, E2E is very hard to implement and
very slow.

### Composer Script
Composer scripts are a way to run custom commands when we run composer commands. We can define our custom commands in the composer.json file. We can use the composer run-script command to run our custom commands.


### Test Driven Development (TDD)

Test Driven Development is a software development process that relies on the repetition of a very short development cycle: requirements are turned into very specific test cases, then the software is improved to pass the new tests. This is opposed to software development that allows software to be added that is not proven to meet requirements.
- Test Driven Development (TDD) is the
idea of writing test first and write the code
later.

- In standard TDD, we would write the
bare minimum code to pass our test and
refactor our code as we progress to the
more advanced tests.


### Form Requests
Form requests are a way to validate incoming HTTP requests. Form requests are defined in the app/Http/Requests directory. We can use the make:request command to generate a form request class.

### Validators 
Validators are a way to validate incoming HTTP requests. We can use the Validator facade to validate incoming HTTP requests. We can also create our own validator classes to handle specific validation rules in our application.

### Form Requests vs Validators

- Validator is an alternative way to validate
input data other than using the Request
class.

- Validator has the benefit of providing us
a lot of helper functions to work with
validation.

- Validator is not tied to the HTTP request and can be used in other contexts.

### Config 
Config files are used to store all of the configuration options for our application. Config files are stored in the config directory. We can use the config() helper function to access the values in our config files.

###  Throttle and Rate limiting
Throttling is a way to limit the number of requests that can be made to a particular endpoint. We can use the ThrottleRequests middleware to throttle requests to our application. We can also use the ThrottleRequests middleware to rate limit requests to our application.

- Throttle means to limit the number of operations in
a given period of time.

- The throttle middleware in Laravel helps to mitigate
Denial-of-Service (DoS) attacks from malicious user.

- We can define named Rate Limiter in Route Service
Provider.

- We can pass in the rate limiting config directly to the
throttle middleware if we prefer not to use the named
Rate Limiter.


### Signed Route
Signed routes are a way to prevent URL manipulation. Signed routes are useful for routes that contain sensitive information. We can use the signed middleware to sign routes in our application. We can also use the signature middleware to validate signed routes in our application.

- We can use signed routes to protect
our routes from unwanted modification.

- We use URL::temporarySignedRoute() to
create a link with expiration, while
URL::signedRoute() to create a permanent
protected link.

- Laravel uses salted sha25é6 to hash the
route as a measure to prevent modification.


### Websockets

- Websocket (WS) is a communication protocol to
transmit data between computers, where it is
commonly used in realtime apps.

- In contrast to HTTP, WS persists and maintains its
connection with the server, so the subsequent data
transmission will be lightning fast.

- There are 2 common WS app patterns. PubSub
and RPC.

- PubSub involves 1 server that broadcasts
messages to multiple clients. Commonly seen

in financial apps where there is a need to stream
realtime price data.

- RPC is very similar to HTTP, where the client will
send a request and expect a reply from the server.
RPC can be used in messaging apps.

Takeaways

- Pusher, Ably, Laravel Websockets, Soketi and Laravel
Echo Server are websocket servers that are supported by
Laravel.

- Laravel Websockets is a wonderful open-source drop-
in replacement for Pusher.

- Laravel uses the PubSub websocket pattern to publish
real-time app Events.

- We need to setup a queue driver for Laravel
to broadcast websocket events.

- The BroadcastServiceProvider should be enabled in the
app config.

- Laravel Websockets exposed a debugging dashboard
for our websocket connections.


