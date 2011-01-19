<?php

class EZGantt {

	private $title, $start_date, $end_date, $width, $safeTitle;

	private $events = array();

	function __construct($title = 'EZGantt', $start_date, $end_date, $width = '600')
	{
		$this->setTitle($title);
		$this->setStartDate($start_date);
		$this->setEndDate($end_date);
		$this->setWidth($width);
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
	
	private function _safeTag($str, $separator = 'dash', $lowercase = TRUE)
	{
		if ($separator == 'dash')
		{
			$search		= '_';
			$replace	= '-';
		}
		else
		{
			$search		= '-';
			$replace	= '_';
		}
		
        $str = strtolower(htmlentities($str, ENT_COMPAT, 'UTF-8'));
        $str = preg_replace('/&(.)(acute|cedil|circ|lig|grave|ring|tilde|uml);/', "$1", $str);

		$trans = array(
						'&\#\d+?;'				=> '',
						'&\S+?;'				=> '',
						'\s+'					=> $replace,
						'[^a-z0-9\-\._]'		=> '',
						$replace.'+'			=> $replace,
						$replace.'$'			=> $replace,
						'^'.$replace			=> $replace,
						'\.+$'					=> ''
					  );

		$str = strip_tags($str);

		foreach ($trans as $key => $val)
		{
			$str = preg_replace("#".$key."#i", $val, $str);
		}

		if ($lowercase === TRUE)
		{
			$str = strtolower($str);
		}
		
		return trim(stripslashes($str));
	}
	
	public function getTitle(){
	  return $this->title;
	}
	
	public function setTitle($title){
	  $this->safeTitle = $this->_safeTag($title);
	  $this->title = $title;
	}
	
	public function getSafeTitle(){
	  return $this->safeTitle;
	}
	
	public function getStartDate(){
	  return $this->start_date;
	}
	
	public function setStartDate($start_date){
	  $this->start_date = $start_date;
	}
	
	public function getEndDate(){
	  return $this->end_date;
	}
	
	public function setEndDate($end_date){
	  $this->end_date = $end_date;
	}
	
	public function getWidth(){
	  return $this->width;
	}
	
	public function setWidth($width){
	  $this->width = $width;
	}
	
	private function _convert_date($date)
	{
		return strtotime($date);
	}
	
	public function render()
	{
		$html = 'TEST';
		$this->_layout($html);
		echo $html;
		
		return $this->events;
	}
	
	private function _layout(&$html){
		$html = '<div id="ezgantt_' . $this->getSafeTitle() . '" style="width: ' . $this->getWidth() . 'px;"><h2 style="text-align: center; width: 100%;">' . $this->getTitle() . '</h2>' . $html . '</div>';		
	}
}