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
 * Осуществляем проверку  на  наличие доступа
 * у текущего пользователя для редактирования
 * тестов указанной задачи.
 */

Security::CheckAccessPermissions(
	PERMISSION::ADMINISTRATOR | PERMISSION::TEACHER_MANAGE_PROBLEMS,
	true
);

/*
 * Осуществляем различные проверки
 * безопасности, а  также  очищаем
 * данные от возможного  вредонос-
 * ного содержимого.
 */

isset($_GET['id']) or Security::ThrowError("404");
isset($_GET['pid']) or Security::ThrowError("input");

$_GET['id'] = abs((int)$_GET['id']);
$_GET['pid'] = abs((int)$_GET['pid']);

/*
 * Запрашиваем доступ к глобальным переменным
 */

global $database;

/*
 * Производим удаление указанного теста
 */

// Формируем запрос на удаление данных из БД
$query_str = sprintf("
	DELETE FROM
	  `spm_problems_tests`
	WHERE
	  `id` = '%s'
	LIMIT
	  1
	;
", $_GET['id']);

// Выполняем запрос
$database->query($query_str);

/*
 * Перенаправляем пользователя  на  страницу
 * редактирования тестов к указанной задаче.
 */

// Перезаписываем заголовок
header(
	'location: ' . _SPM_ . 'index.php/problems/edit/tests/?id=' . $_GET['pid'],
	true
);

// Завершаем работу экземпляра веб-приложения
exit;