<?php
    spl_autoload_register(function (string $className){
        // echo $className.'<br>';
        require_once '../src/'.str_replace('\\', '/', $className).'.php';
    });

    $isRouteFound = false;
    $route = $_GET['route'] ?? '';
    $routes = require 'routes.php';
    foreach($routes as $pattern => $controllerAndAction){
        preg_match($pattern, $route, $matches);
        if (!empty($matches)){
            $isRouteFound = true;
            break;
        }
    }
    if (!$isRouteFound){
        echo 'Страница не найдена!';
        return;
    }
    unset($matches[0]);
    $controllerName = $controllerAndAction[0];
    $actionName = $controllerAndAction[1];

    $controller = new $controllerName();
    $controller->$actionName(...$matches);

    // require '../src/MyProject/Models/Users/User.php';
    // require '../src/MyProject/Models/Articles/Article.php';
    // $user = new MyProject\Models\Users\User('Sasha');
    // $article = new MyProject\Models\Articles\Article('Title', 'Text', $user);
    // var_dump($article);
?>