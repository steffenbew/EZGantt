<?php

class EZGantt {

	private $title, $start_date, $end_date, $safeTitle, $duration;

	private $events = array();

	function __construct($title = 'EZGantt')
	{
		$this->setTitle($title);
	}
	
	public function add_milestone($name, $start_date, $end_date, $category = NULL)
	{
	
		$start_date	= $this->_convert_date($start_date);
		$end_date	= $this->_convert_date($end_date);

		if(!$this->getStartDate() || $start_date < $this->getStartDate())
		{
			$this->setStartDate($start_date);
		}
		if($end_date > $this->getEndDate())
		{
			$this->setEndDate($end_date);
		}
		
	
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
									'name'		=> $name,
									'start'		=> $start_date,
									'end'		=> $end_date,
									'duration'	=> $this->_get_duration_in_days($start_date, $end_date) 
								)
							)
			);
		}
		else
		{
			$this->events[$found]['items'][] = array(
					'name'      => $name,
					'start'     => $start_date,
					'end'       => $end_date,
					'duration'  => $this->_get_duration_in_days($start_date, $end_date)
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
	  if(isset($this->end_date)){
	    $this->duration = $this->getEndDate() - $this->getStartDate();
	  }
	}
	
	public function getEndDate(){
	  return $this->end_date;
	}
	
	public function setEndDate($end_date){
	  $this->end_date = $end_date;
	  if(isset($this->start_date)){
	    $this->duration = $this->end_date - $this->start_date;
	  }
	}
	
	public function getDuration(){
	  return $this->duration; // Add another day?
	}
	
	public function getDurationInDays(){
	  return ceil($this->duration / 60 / 60 / 24);
	}
	
	public function getDurationInWeeks(){
		return $this->getDurationInDays() / 7;
	}
	
	private function _convert_date($date)
	{
		return strtotime($date);
	}
	
	private function _get_duration_in_days($start, $end){
	  return ceil(($end - $start) / 60 / 60 / 24);
	}
	
	public function render()
	{
		$html = '';
                foreach($this->events as $event_category){
                    $html .= '<h3>' . $event_category['title'] . '</h3>';
                    foreach($event_category['items'] as $item){
                        $html .= $this->_addEventLine($item['name'], $item['start'], $item['duration']);
                    }
                }
		
		$this->_layout($html);
		return $html;
	}
	
	private function _layout(&$html){
		$html = '<div id="ezgantt_' . $this->getSafeTitle() . '"><h2>' . $this->getTitle() . '</h2>' . $html . '</div>';		
	}
	
	private function _addEventLine($title, $start, $duration){
      $margin = number_format(($this->_get_duration_in_days($this->getStartDate(), $start) / $this->getDurationInDays()) * 100, 2);
	  $width = number_format(($duration / $this->getDurationInDays()) * 100, 2);
	  $html = '<div class="ezgantt_row"><div class="sidebar_title">' . $title . '</div><div class="event_wrapper"><div class="event" style="margin-left:' . $margin . '%; width:' . $width . '%;">' . $duration . ' days</div></div></div>';
	  return $html;
	}
}