# Middleware are functions that run before the request hits the router.
 The handle() method contains the main logic
 of the middleware, while the terminate()
 method contains the "clean up" logic just
 before the app is shut down.
 The Kernel is responsible to pass the request
 to the router through middleware.
 The Kernel bootstrap the application by
 setting up:
   - Environment Variable
   -  Configuration
   - Exception Handling
   - Register façade and Service Provider

# Service Container and Service Provider
The service container is a powerful tool for managing class dependencies and performing dependency injection. The service container is used throughout Laravel to resolve dependencies for your controllers, routes, queue jobs, and more. The service container is also responsible for resolving middleware and registering facades.
 Service Providers are classes that instruct
 Laravel on how to instantiate a Service/Class.
 The register() method is where define our
 class binding.
 The boot() method is called after all Services
 are registered.
 We need to put our Service Provider in the
 'provider' array in the app config file to activate
 it. Otherwise Laravel will automatically resolve
 the Service on its own using the 'Automatic
 Resolution feature.

# Facades: In Laravel, a facade is a design pattern that provides a simple and static interface to a complex system, allowing developers to access its functionality without having to understand its underlying implementation. Facades provide a convenient way to access Laravel's various components, such as the database, caching, and session systems, without having to manually instantiate and configure them.

Route group can help us to effectively organise
our API routes.
We can either use the array syntax or the method
syntax to define a route group.
We can add URL prefix, route name prefix,
namespace and middleware to a route group.
The where() method is useful to add matching
constraint to URL parameters.

