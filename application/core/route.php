<?PHP

/*
 ласс-маршрутизатор дл¤ определени¤ запрашиваемой страницы.
> цепл¤ет классы контроллеров и моделей;
> создает экземпл¤ры контролеров страниц и вызывает действи¤ этих контроллеров.
*/
class Route
{
    static function start()
    {
        // контроллер и действие по умолчанию
        $controller_name = 'Main';
        $action_name = 'index';

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        // получаем им¤ контроллера
        if ( !empty($routes[2]) )
        {
            $controller_name = $routes[2];
        }

        // получаем им¤ экшена
        if ( !empty($routes[3]) )
        {
            $action_name = $routes[3];
        }

        // добавляем префиксы
        $model_name = 'Model_'.$controller_name;
        $controller_name = 'Controller_'.$controller_name;
        $action_name = 'action_'.$action_name;


//        echo "Model: $model_name <br>";
//        echo "Controller: $controller_name <br>";
//        echo "Action: $action_name <br>";


        // подцепл¤ем файл с классом модели (файла модели может и не быть)

        $model_file = strtolower($model_name).'.php';
        $model_path = "application/models/".$model_file;

        if(file_exists($model_path))
        {
            include "application/models/".$model_file;
        }

        // подцепл¤ем файл с классом контроллера
        $controller_file = strtolower($controller_name).'.php';
        $controller_path = "application/controllers/".$controller_file;

        if(file_exists($controller_path))
        {
            include "application/controllers/".$controller_file;
        }
        else
        {
            /*
            правильно было бы кинуть здесь исключение,
            но дл¤ упрощени¤ сразу сделаем редирект на страницу 404
            */
            Route::ErrorPage404();
        }

        // создаем контроллер
        $controller = new $controller_name;
        $action = $action_name;

        if(method_exists($controller, $action))
        {
            // вызываем действие контроллера
            $controller->$action();
        }
        else
        {
            // здесь также разумнее было бы кинуть исключение
            Route::ErrorPage404();
        }

    }

    function ErrorPage404()
    {
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/'.$routes[1].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'404');
    }

}




?>