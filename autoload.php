<?php
function myAutoloads($classname)
{
    if (file_exists(__DIR__ . '/controllers/' . $classname . '.php'))
        require __DIR__ . '/controllers/' . $classname . '.php';
    else if (file_exists(__DIR__ . '/Models/' . $classname . '.php'))
        require __DIR__ . '/Models/' . $classname . '.php';
    else if (file_exists(__DIR__ . '/base/' . $classname . '.php'))
        require __DIR__ . '/base/' . $classname . '.php';
    else if (file_exists(__DIR__ . '/Class/' . $classname . '.php'))
        require __DIR__ . '/Class/' . $classname . '.php';
    else if (file_exists(__DIR__ . '/admin_panel/' . $classname . '.php'))
        require __DIR__ . '/admin_panel/' . $classname . '.php';
    else {
        $classparts = explode('\\', $classname);
        $classparts[0] = __DIR__;
        $path = implode(DIRECTORY_SEPARATOR, $classparts) . '.php';
        if (file_exists($path))
            require $path;
    }
}

    spl_autoload_register('myAutoloads');
    require __DIR__ . '/vendor/autoload.php';