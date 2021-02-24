# remove_hook

This has been created to solve a problem using ```remove_filter()``` and ```remove_action()``` when they have been registered via classes in plugins. When someone uses ```[$this, 'my_method']``` you must pass the same instance of the class for them to be removed. 

This single function can be used to remove actions and filters based using any instance or name of the class being used. 

If you wish to use this in your code, you are better off just copying the function from ```src/remove_hook.php``` and including in your codebase.

## DOESNT NOT WORK IF YOU USE A LAMBDA AS YOUR CALLBACK. 
