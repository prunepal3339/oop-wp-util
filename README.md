## Object Oriented Utilities for working with WordPress in object-oriented way.
#### Features

### Dependency Injection Container

| Status | Features |
|---------|----------|
|✅| Constructor Injection |
|✅| Service Configuration (config/services.php) |
|✅| Parameter Injection |
|✅| Autowiring Support |

### PSR-4 Autoloader from Scratch.


### Hooks Abstraction (powered by Reflection)

* Explicitly configurable hooks.
* Reflection-powered discovered hooks.

### AJAX Abstraction
* List the methods you want to register as an AJAX callbacks, and you are good to go.
* Automatic registration of ajax callbacks via method naming conventions. (Optional)

### Admin Page Abstraction.
- You focus on the content, we take care of the structure.

Extend the `AbstractAdminPage` and define methods
 * view()
 * configure(),

 and your admin page is ready to view.

 ### Frontend Page Abstraction (TODO)

 ### Configuration Abstraction (EXPERIMENTAL)

 Ever wanted a unified API for reading/writing configuration whether it is stored in
 * In-memory Structures.
 * Options Table.
 * Entity Metadata Table.
 * File storage.
 * Cache storage.

 Then, this is for you.