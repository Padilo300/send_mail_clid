<?php
/**
 * Библиотека для работы с событиями календаря
 *
 * @author Andrii Biriev, a@konservs.com
 *
 * @copyright www.konservs.com
 */

class BCalendarEvent{
	public $created;
	public $modified;
	public $dtstart;
	public $dtend;
	public $summary;
	public $description;
	public $organizer_name;
	public $organizer_email;
	public $location;
	/**
	 * 
	 */
	public function __construct(){
		$this->created=new DateTime();
		$this->modified=new DateTime();
		}
	}