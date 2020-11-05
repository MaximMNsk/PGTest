# PGTest
## Выполнено согласно требованиям ТЗ
### Описание
* Затрачено около 20 часов на разработку, функциональное тестирование, рефакторинг.
* Выполнял с некоторыми отклонениями от PSR (PHP-FIG) осознанно.
* Бэк проекта реализован как MVC-приложение, фронт - как клиент. Для фронта целесообразнее было бы использовать Vue. 
* Настройки проекта хранятся в корне в config.php .
* Установка - как стандартное веб-приложение. Создаем виртуальный хост. index.php должен быть в корне. Приложение должно быть доступно по адресу: `http://yourvirtual.host`
### Логика работы приложения
####Для пользователя:
При запуске приложения пользователь попадает на страницу входа в приложение
На первой странице пользователь получает либо форму, заполненную данными сотрудника, которого нужно отработать, либо пустую форму и соответствующее оповещение  
Обработка данных сотрудника происходит согласно требованиям ТЗ
После сохранения работы, пользоателю предоставляется возможность работы с данными следующего сотрудника
####Внутренняя логика:
>Авторизация. 
При авторизации пользователя происходит открытие серверной сессии, в рамках которой работает пользователь. Если пользователь не проходит авторизацию, ситсема редиректит его на страницу авторизации.
>Работа с данными. 
Для каждой БД реализована отдельная модель, через которую происходит работа с данными. 
>>Получение данных. 
После авторизации, приложение перенаправляет пользователя в форму для работы с данными. Форма через AJAX-объект обращается к контроллеру get. По умолчанию, get отдает либо данные об одном сотруднике, либо ответ о том, что сотрудников в системе нет. Инфо отображается пользователю в виде popup сообщения. 
Выбор сотрудников происходит исходя из того, что у сотрудников в БД CRM нет идентификатора. Сравнение данных из двух баз может привести к катастрофической нагрузке на ресурсы при кратном увеличении записей в БД.
>>Сохранение данных. 
Происходит через метод set post-запросом. На сервере происходит валидация данных отдельной моделью.