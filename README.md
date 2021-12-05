# Интерфейс для управления FastRouter

## Описание
Интерфейс позволяет упростить использование готового компонента с сайта https://composer.org под названием `FastRouter`

## Установка
1. Скачать файлы
2. Поместить `Router.php` в папку с контроллерами
3. Поместить файл `RouterConfig.php` в папку с конфигами
4. Задать правила маршрутизации в файле `RouterConfig.php`
5. Задать **namespace** для контроллера в соответствии с вашими предпочтениями
6. Подключить **namespace** в автозагрузку

## Использование
1. Выполнить команду `composer require nikic/fast-route` или установить компонент `nikic/fast-route` другим способом
2. Создать экземпляр класса `new Router(path/to/RouterConfig.php);`
