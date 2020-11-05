<?PHP

class Route
{
    static function start()
    {
        $controller_name = 'Login';
        $action_name = 'index';

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        if ( !empty($routes[1]) )
        {
            $controller_name = $routes[1];
        }else{
            header("location: login/");
        }

        if ( !empty($routes[2]) )
        {
            $action_name = $routes[2];
        }
        $model_name = 'Model_'.$controller_name;
        $controller_name = 'Controller_'.$controller_name;
        $action_name = 'action_'.$action_name;


        $model_file = strtolower($model_name).'.php';
        $model_path = "application/models/".$model_file;

        if(file_exists($model_path))
        {
            include $model_path;
        }


        $controller_file = strtolower($controller_name).'.php';
        $controller_path = "application/controllers/".$controller_file;
        // echo $controller_path;

        if(file_exists($controller_path))
        {
            include $controller_path;
        }
        

        $full_controller_name = 'application\\controllers\\'.$controller_name;

        $controller = new $full_controller_name;
        $action = $action_name;

        if(method_exists($controller, $action))
        {
            $controller->$action();
        }
        

    }

    static function ErrorPage404()
    {
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/'.$routes[1].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'404');
    }

}



