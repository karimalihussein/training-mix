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

