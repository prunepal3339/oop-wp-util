<?php
/**
 * Plugin Name: WordPress OOP Utility
 * Plugin Description: Utility Classes for working with WordPress in OOP way.
 */
function WPOOPUtilAutoloader($class)
{
    $prefix = "WPOOPUtil\\";
    // base directory for the namespace prefix
    $base_dir = __DIR__ . "/core/";

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file =
        $base_dir .
        str_replace("\\", DIRECTORY_SEPARATOR, $relative_class) .
        ".php";
    if (file_exists($file)) {
        require_once $file;
    } else {
        var_dump("Error: " . $file . " not autoloaded!");
        exit();
    }
}
spl_autoload_register("WPOOPUtilAutoloader");

/* ---- BOOTSTRAPPING DEPENDENCY INJECTION CONTAINER ----- */
use WPOOPUtil\DependencyInjection\{
    Container,
    ContainerConfigurator,
    ServiceConfigPathLoader
};
$container = new Container();
$configurator = new ContainerConfigurator($container);
$pathLoader = new ServiceConfigPathLoader();
$serviceConfigFiles = $pathLoader->getServiceConfigFiles();
$configurator->configure($serviceConfigFiles);
/* END OF DEPENDENCY INJECTION CONTAINER */