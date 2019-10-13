<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);



/**
 * Пример работы с библиотеками календаря и почты.
 *
 * @author Andrii Biriev, a@konservs.com
 *
 * @copyright www.konservs.com
 */

require_once( __DIR__ .'/libraries/calendar/calendar.php');
require_once( __DIR__ .'/libraries/email/email.php');

date_default_timezone_set('Europe/Kiev');

echo('Создаём календарь...<br>');
$calendar=new BCalendar();
$calendar->createEvent(
	new DateTime('2019-12-12 23:00'),
	new DateTime('2019-12-12 23:30'),
	'Название события',
	'Описание события',
	'Записки Консерваторов',
	'noreply@konservs.com',
	'25, улица Комарова, Черновцы');
echo('Отправляем email...<br>');

$email=new TEmail();
$email->from_email='info@padilo.pro';
$email->from_name='От "Записок Консерваторов"';
$email->to_email='padilo300@gmail.com';
$email->subject='Письмо с календарём';
$email->body('text/html','<p>Письмо в HTML с вложениями.</p>');
$email->attachdata('text/calendar','event.ics',$calendar->print_icalendar());
$result=$email->send();

echo(($result?'Email успешно отправлен.':'Ошибка отправки email!').'<br>');
