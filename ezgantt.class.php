<?php

class EZGantt {

	private $title, $start_date, $end_date, $width;

	private $events = array();

	function __construct($title = 'EZGantt', $start_date, $end_date, $width = '600')
	{
		$this->title		= $title;
		$this->start_date	= $start_date;
		$this->end_date		= $end_date;
		$this->width		= $width;
	}
	
	public function add_milestone($name, $start_date, $end_date, $category = NULL)
	{
	
		$start_date	= $this->_convert_date($start_date);
		$end_date	= $this->_convert_date($end_date);
		
	
		$found = NULL;

		foreach($this->events AS $key => $event)
		{
			if($event['title'] == $category)
			{
				$found = $key;
				break;
			}
		}
		
		if($found === NULL)
		{
			$this->events[] = array(
				'title'	=> $category,
				'items'	=> array(
								array(
									'name'	=> $name,
									'start'	=> $start_date,
									'end'	=> $end_date
								)
							)
			);
		}
		else
		{
			$this->events[$found]['items'][] = array(
					'name'	=> $name,
					'start'	=> $start_date,
					'end'	=> $end_date
					);
		}
		


	}
	
	
	private function _convert_date($date)
	{
		return strtotime($date);
	}
	
	
	public function render()
	{
		return $this->events;
	}
	
}