<?php
/**
 * Ѕиблиотека дл€ работы с календарЄм в формате iCalendar
 *
 * @author Andrii Biriev, a@konservs.com
 *
 * @copyright www.konservs.com
 */

require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'event.php');

class BCalendar{
	public $events;
	/**
	 * ‘ункци€, добавл€юща€ событие
	 */
	public function addEvent($event){
		$this->events[]=$event;
		}
	/**
	 * јналогична предыдущей, но нам не надо создавать объект.
	 */
	public function createEvent($dtstart,$dtend,$summary,$description='',$organizer_name='',$organizer_email='',$location=''){
		$event=new BCalendarEvent();
		$event->dtstart=$dtstart;
		$event->dtend=$dtend;
		$event->summary=$summary;
		$event->description=$description;
		$event->organizer_name=$organizer_name;
		$event->organizer_email=$organizer_email;
		$event->location=$location;
		$this->addEvent($event);
		}
	/**
	 * ѕечать календар€ в формате iCalendar
	 */
	public function print_icalendar(){
		$data='';
		$data.='BEGIN:VCALENDAR'.PHP_EOL;
		$data.='PRODID:-//Brilliant//Brilliant Mailer 1.0.0//EN'.PHP_EOL;
		$data.='VERSION:2.0'.PHP_EOL;
		$data.='CALSCALE:GREGORIAN'.PHP_EOL;
		$data.='METHOD:REQUEST'.PHP_EOL;

		foreach($this->events as $event){
			$data.='BEGIN:VEVENT'.PHP_EOL;
			//Event start
			$dtstart_utc=clone $event->dtstart;
			$dtstart_utc->setTimezone(new DateTimeZone('UTC'));
			$data.='DTSTART:'.$dtstart_utc->format('Ymd\THis\Z').PHP_EOL;
			//
			$dtend_utc=clone $event->dtend;
			$dtend_utc->setTimezone(new DateTimeZone('UTC'));
			$data.='DTEND:'.$dtend_utc->format('Ymd\THis\Z').PHP_EOL;
			//Date/Time stamp. Looks like current date/time...
			$dtstamp_utc=clone $event->created;
			$dtstamp_utc->setTimezone(new DateTimeZone('UTC'));
			$data.='DTSTAMP:'.$dtstamp_utc->format('Ymd\THis\Z').PHP_EOL;
			//Organizer
			$organizer=$event->organizer_name.':mailto:'.$event->organizer_email;

			$data.='ORGANIZER;CN='.$organizer.PHP_EOL;
			//$data.='UID:71h5j8f8vk8aktimaqjirqeo0c@google.com'.PHP_EOL;
			//$data.='ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE;CN=Maksym Kutyshenko;X-NUM-GUESTS=0:mailto:mkutyshenko@gmail.com';

			//
			$dtcreated_utc=clone $event->created;
			$dtcreated_utc->setTimezone(new DateTimeZone('UTC'));
			$data.='CREATED:'.$dtcreated_utc->format('Ymd\THis\Z').PHP_EOL;
			//
			$data.='DESCRIPTION:'.$event->description.PHP_EOL;
			//
			$dtmodified_utc=clone $event->modified;
			$dtmodified_utc->setTimezone(new DateTimeZone('UTC'));
			$data.='LAST-MODIFIED:'.$dtmodified_utc->format('Ymd\THis\Z').PHP_EOL;
			//
			$data.='LOCATION:'.$event->location.PHP_EOL;
			$data.='SEQUENCE:0'.PHP_EOL;
			$data.='STATUS:CONFIRMED'.PHP_EOL;
			$data.='SUMMARY:'.$event->summary.PHP_EOL;
			$data.='TRANSP:OPAQUE'.PHP_EOL;
			$data.='END:VEVENT'.PHP_EOL;
			}
		$data.='END:VCALENDAR'.PHP_EOL;
		return $data;
		}
	}
