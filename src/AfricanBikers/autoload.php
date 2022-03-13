<?php

spl_autoload_register(function ($class){
    var_dump($class);
    require($class.".php");
});