<?php

/*
 * ███████╗██╗███╗   ███╗██████╗ ██╗     ███████╗██████╗ ███╗   ███╗
 * ██╔════╝██║████╗ ████║██╔══██╗██║     ██╔════╝██╔══██╗████╗ ████║
 * ███████╗██║██╔████╔██║██████╔╝██║     █████╗  ██████╔╝██╔████╔██║
 * ╚════██║██║██║╚██╔╝██║██╔═══╝ ██║     ██╔══╝  ██╔═══╝ ██║╚██╔╝██║
 * ███████║██║██║ ╚═╝ ██║██║     ███████╗███████╗██║     ██║ ╚═╝ ██║
 * ╚══════╝╚═╝╚═╝     ╚═╝╚═╝     ╚══════╝╚══════╝╚═╝     ╚═╝     ╚═╝
 *
 * SimplePM WebApp is a part of software product "Automated
 * verification system for programming tasks "SimplePM".
 *
 * Copyright (C) 2016-2018 Yurij Kadirov
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 *
 * GNU Affero General Public License applied only to source code of
 * this program. More licensing information hosted on project's website.
 *
 * Visit website for more details: https://spm.sirkadirov.com/
 */

/*
 * Явно указываем, требуется ли отображение ошибок
 * в графическом интерфейсе веб-приложения.
 *
 * Для release все значения необходимо изменить на
 * 0, ведь получение сведений об ошибках некоторыми
 * пользователями может повлечь за собой непредвиденные
 * ранее последствия.
 *
 * На этапе тестирования должны быть указаны
 * соответствующие значения для аргументов
 * вызываемых методов.
 */

ini_set('error_reporting', E_ALL); // 0 for release, E_ALL for debug
ini_set('display_errors', 1); // 0 for release, 1 for debug
ini_set('display_startup_errors', 1); // 0 for release, 1 for debug

/*
 * Производим настройки параметов сессий
 */

session_set_cookie_params(3600 * 24 * 2);


/*
 * В находящемся ниже разделе производим
 * конфигурацию некоторых модулей PHP.
 */

mb_internal_encoding('UTF-8');

/*
 * Указание временной зоны для правильного
 * расчёта и учёта времени.
 *
 * Если данный параметр не настроен или
 * настроен не правильно, могут возникнуть
 * проблемы при проведении уроков и соревнований,
 * учёт пользовательского времени online станет
 * не корректным, а веб-приложение может
 * испытывать некоторые трудности в работе.
 *
 * Важно установить этот параметр аналогично
 * установленному на серевере баз данных MySQL.
 */

date_default_timezone_set('Europe/Kiev');

/*
 * Далее нам необходимо уточнить пути к
 * некоторым важным объектам, что мы
 * делаем с использованием функции define.
 */

define("_SPM_configuration_", "./_configuration/", false); // путь к папке с конфигурациями
define("_SPM_includes_", "./_includes/", false); // путь к папке с include-ами

define("_SPM_template_", "./_template/", false); // путь к папке шаблона
define("_SPM_modules_", "./_modules/", false); // путь к папке модулей

define("_SPM_commands_", "./_commands/", false); // путь к папке комманд
define("_SPM_services_", "./_services/", false); // путь к папке сервисов
define("_SPM_views_", "./_views/", false); // путь к папке с видами

/*
 * Производим включение необходимых
 * заголовочных файлов и PHP файлов
 * для последующего их использования.
 */

// Файл исходного кода содержащий глобальные функции
include _SPM_includes_ . "System/GlobalFunctions.inc";

// Класс для работы с конфигурациями
include _SPM_includes_ . "System/Configuration.inc";

/*
 * Инициализируем хранилище конфигурации
 * веб-приложения.
 */

$_CONFIG = new Configuration();

/*
 * Инициализируем константу, содержащую
 * полный путь к веб-приложению (HTTP).
 */

define("_SPM_", @$_CONFIG->getWebappConfig()["site_base_url"]);

/*
 * Определяем дополнительные константы,
 * которые зависят от константы _SPM_.
 */

define("_SPM_media_", _SPM_ . "_media/", false); // путь к папке с медиафайлами
define("_SPM_assets_", _SPM_media_ . "_assets/", false); // путь к папке с ресурсами

/*
 * Производим включение необходимых
 * заголовочных файлов и PHP файлов
 * для последующего их использования.
 */

// Класс для работы со стилями отображения
include _SPM_includes_ . "Template/LayoutManager.inc";

// Класс для работы с изображениями
include _SPM_includes_ . "Additional/SimpleImage.inc";

/*
 * Включения, отвечающие за безопасность
 * при работе веб-приложения.
 */

// Хранит уровни доступа к сервисам системы
include _SPM_includes_ . "Security/Permissions.inc";

// Отвечает за безопасность запросов
include _SPM_includes_ . "Security/Security.inc";

/*
 * Классы и трейты для работы
 * с пользовательскими данными.
 */

include _SPM_includes_ . "UserInformation/UserInfo.inc";
include _SPM_includes_ . "UserInformation/SessionUser.inc";

/*
 * Инициализируем сессию
 */

@session_start();

/*
 * Производим включение файлов исходного кода,
 * которые содержат описание классов, трейтов
 * и прочих важных частей группы оффициантов.
 */

// Базовый трейт для работы с оффициантами
include _SPM_includes_ . "Waiters/Waiter.inc";

// Класс для работы с коммандами
include _SPM_includes_ . "Waiters/SystemWaiter.inc";

// Класс для работы с сервисами
include _SPM_includes_ . "Waiters/ClientWaiter.inc";

/*
 * Производим ключение файла исходного кода,
 * в котором происходит попытка подключения
 * к базе данных системы.
 */

include _SPM_includes_ . "System/Database.inc";

// Запрашиваем доступ к глобальным переменным
global $database;

/*
 * Производим включение файла класса поддерживаемых
 * системой проверки решений языков программирования
 * и инициализируем новую переменную, хранящую объект
 * этого типа.
 */

include _SPM_includes_ . "System/SupportedProgrammingLanguages.inc";

$supported_programming_languages = new SupportedProgrammingLanguages($database);

/*
 * Раздел включения ServiceHelper-ов.
 */

include _SPM_includes_ . "ServiceHelpers/Olymp.inc";

/*
 * Для обеспечения безоасности производим
 * очистку GET и POST данных от небезопасных
 * символов, которые могут привести к поломке
 * всей backend-части данного веб-приложения.
 */

// Создаём новый объект типа Security
$_SECURITY = new Security($database);

// Производим очистку GET запросов
$_SECURITY->ClearGET();

// Производим очистку POST запросов
$_SECURITY->ClearPOST();

/*
 * Секция вызова автозагрузочных функций,
 * таких как различные проверки безопасности,
 * переадресации на подсистемы урока или
 * соревнования, и так далее.
 */

// Производим включение требуемого класса
include _SPM_includes_ . "Checkers/Checkers.inc";

// Проверка пользователя на существование
Checkers::CheckUserExists();

// Проверка пользовательской сессии
Checkers::CheckUserSession();

// Проверка связанного соревнования
Checkers::CheckOlympiadExists();

/*
 * Обработка запросов на выполнение операций
 */

// Инициализируем переменную официанта
$_SYSTEM_WAITER = new SystemWaiter();

// Запскаем коммандный сервис на выполнение (по запросу)
$_SYSTEM_WAITER->RunCommand(
    $_SYSTEM_WAITER->GetRequestedCommandName()
);

/*
 * Обработка запросов на отображение сервисов
 */

// Инициализируем переменную официанта
$_CLIENT_WAITER = new ClientWaiter();

// Запскаем сервис на выполнение
if (!$_CLIENT_WAITER->RunService($_CLIENT_WAITER->GetRequestedServiceName()))
    Security::ThrowError("404");

/*
 * Для обеспечения стабильностти работы необходимо
 * закрывать некоторые открытые ранее соединения.
 *
 * В приведённом ниже блоке кода мы как раз таки
 * этим и занимаемся.
 *
 * Следующие действия не являются обязательными,
 * но правила есть правила, и нарушать их мы не будем.
 */

$database->close();