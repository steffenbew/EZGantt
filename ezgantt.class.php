<?php

/*
 * EZGanttBaseObject
 *
 * - base object for milestones, tasks and the project plan itself
 *
 */	
class EZGanttBaseObject
{
	protected $title, $start_date, $end_date, $safeTitle, $duration, $dateIsDynamic = false, $baseObject;
	
	function __construct($title, $start_date = NULL, $end_date = NULL)
	{
		$this->setTitle($title);
		if($start_date !== NULL && $end_date !== NULL)
		{
			$this->setStartDate($start_date);
			$this->setEndDate($end_date);
		}
		else
		{
			$this->dateIsDynamic(true);
		}
	}
	

	/* public methods */
	
	public function setTitle($title)
	{
		$this->title = $title;
		$this->safeTitle = $this->_safeTag($this->title);
		return $this;
	}
	
	public function getTitle()
	{
		return $this->title;
	}
	
	public function getSafeTitle()
	{
		return $this->safeTitle;
	}
	
	public function setStartDate($start_date)
	{
		$this->start_date = $this->_convertDateToTimestamp($start_date);
		
		if($this->dateIsDynamic() === TRUE)
		{
			# set start date to first day of the week
			$this->start_date = $this->getFirstDayOfWeek($this->start_date);
		}
	
		return $this;
	}
	
	public function getStartDate()
	{
		return $this->start_date;
	}
	
	public function setEndDate($end_date)
	{
		$this->end_date = $this->_convertDateToTimestamp($end_date);
		
		if($this->dateIsDynamic() === TRUE)
		{
			# set end date to last day of the week
			$this->end_date = $this->getLastDayOfWeek($this->end_date);
		}
	
		return $this;
	}
	
	public function getEndDate()
	{
		return $this->end_date;
	}
	
	public function getFirstWeek()
	{
		return (int) date('W', $this->getStartDate());
	}
	
	public function getLastWeek()
	{
		return (int) date('W', $this->getEndDate());
	}
	
	public function getDuration()
	{
		return $this->getEndDate() - $this->getStartDate();
	}
	
	public function getDurationInDays()
	{
		return floor($this->getDuration() / 60 / 60 / 24) + 1;
	}
	
	public function getDurationInWeeks()
	{
		return floor($this->getDurationInDays() / 7);
	}
	
	public function getFirstDayOfWeek($day)
	{
		$day_of_week = (int) date('N', $day);
		if($day_of_week !== 1)
		{
			$day = $day - ($day_of_week - 1) * 60 * 60 * 24;
			# make sure we got the exact midnight time
			$day = strtotime(date('Y-m-d', $day));
		}
		return $day;
	}
	
	public function getLastDayOfWeek($day)
	{
		$day_of_week = (int) date('N', $day);
		if($day_of_week !== 7)
		{
			$day = $day + (7 - $day_of_week) * 60 * 60 * 24;
			# make sure we got the exact midnight time
			$day = strtotime(date('Y-m-d', $day));
		}
		return $day;
	}


	/* protected methods */
	
	protected function dateIsDynamic($value = NULL)
	{
		if($value !== NULL)
		{
			$this->dateIsDynamic = (bool) $value;
			return $this;
		}
		return $this->dateIsDynamic;
	}
	
	protected function calcDurationInDays($start, $end)
	{
		return floor(($end - $start) / 60 / 60 / 24);
	}
	
	protected function sortByTitle(&$objects)
	{
		usort($objects, array("self", "_compareTitles"));
	}
	
	protected function setDateRange($object)
	{
		if($this->getStartDate() === NULL || $object->getStartDate() < $this->getStartDate())
		{
			$this->setStartDate($object->getStartDate());
		}
		if($this->getEndDate() === NULL || $object->getEndDate() > $this->getEndDate())
		{
			$this->setEndDate($object->getEndDate());
		}
	}
	
	protected function setBase(&$object)
	{
		$this->baseObject = $object;
		return $this;
	}
	
	protected function getBase()
	{
		return $this->baseObject;
	}
	
	
	/* private methods */
	
	private function _convertDateToTimestamp($date)
	{
		# if given value is already a valid timestamp, do nothing
		if(strtotime(date('Y-m-d H:i:s', (int) $date)) === $date)
		{
			return $date;
		}
		return strtotime($date);
	}
	
	private function _safeTag($str)
	{
		$replace	= '-';
		
		$str = strtolower(htmlentities($str, ENT_COMPAT, 'UTF-8'));
		$str = preg_replace('/&(.)(acute|cedil|circ|lig|grave|ring|tilde|uml);/', "$1", $str);

		$trans = array(
						'&\#\d+?;'				=> '',
						'&\S+?;'					=> '',
						'\s+'							=> $replace,
						'[^a-z0-9\-\._]'	=> '',
						$replace.'+'			=> $replace,
						$replace.'$'			=> $replace,
						'^'.$replace			=> $replace,
						'\.+$'						=> ''
						);

		$str = strip_tags($str);

		foreach ($trans AS $key => $val)
		{
			$str = preg_replace("#".$key."#i", $val, $str);
		}
		
		return trim(stripslashes(strtolower($str)));
	}
	
	private function _compareTitles($a, $b)
	{
		return strcmp($a->getTitle(), $b->getTitle());
	}
}

/*
 * EZGanttEventObject
 *
 * - can be used to create milestones and tasks
 * - is capable of having child objects of itself (when creating a task for a milestone)
 *
 */	
class EZGanttEventObject extends EZGanttBaseObject
{
	private $link, $completed = FALSE, $tasks = array();
	
	public function setLink($link)
	{
		$this->link = $link;
		return $this;
	}
	
	public function getLink()
	{
		return $this->link;
	}
	
	public function isCompleted($value = NULL)
	{
		if($value !== NULL) {
			$this->completed = (bool) $value;
			return $this;
		}
		return $this->completed;
	}
	
	public function addTask($title, $start_date, $end_date, $link, $completed = FALSE)
	{
		$task = new EZGanttEventObject($title, $start_date, $end_date);
		$task->setLink($link)->isCompleted($completed)->setBase($this->getBase());
		array_push($this->tasks, $task);
		
		# dynamically set start and end date if no static date range was set
		if($this->dateIsDynamic() === TRUE)
		{
			$this->setDateRange($task);
		}
		if($this->getBase()->dateIsDynamic() === TRUE)
		{
			$this->getBase()->setDateRange($task);
		}
		
		return $this;
	}
	
	public function getTasks()
	{
		$this->sortByTitle($this->tasks);
		return $this->tasks;
	}

}


/*
 * EZGantt
 *
 * - the main class
 * - generates the project plan html
 *
 */	
class EZGantt extends EZGanttBaseObject
{
	private $milestones = array();
	
	
	/* public methods */	
	
	public function addMilestone($title, $start_date = NULL, $end_date = NULL, $link = NULL, $completed = FALSE)
	{
		$milestone = new EZGanttEventObject($title, $start_date, $end_date);
		$milestone->setLink($link)->isCompleted($completed)->setBase($this);
		array_push($this->milestones, $milestone);
		
		# dynamically set start and end date if no static date range was set
		if($this->dateIsDynamic() === TRUE)
		{
			$this->setDateRange($milestone);
		}
		
		return $milestone;
	}
	
	public function getMilestones()
	{
		$this->sortByTitle($this->milestones);
		return $this->milestones;
	}
	
	public function render()
	{
		$html = '';

		foreach($this->getMilestones() AS $milestone)
		{
			$html .= $this->_renderMilestone($milestone);
		}
		
		$this->_layout($html);
		return $html;
	}
	
	public function getMarginForToday()
	{
		if($this->getStartDate() < time() && $this->getEndDate() > time())
		{
			return number_format((floor(($this->calcDurationInDays($this->getStartDate(), time()) / $this->getDurationInDays()) * 100 * 100) / 100), 2, '.', '');		
		}
		return -1;
	}
	
	
	/* private methods */
	
	private function _layout(&$html)
	{
		$html = '<div class="ezgantt" id="ezgantt_' . $this->getSafeTitle() . '"><h2>' . $this->getTitle() . '</h2>' . $html . '</div>';		
	}
	
	private function _renderMilestone($milestone)
	{
		$status= $milestone->isCompleted() === TRUE ? 'completed' : ($milestone->getStartDate() > time() ? 'open' : 'active');
		$html  = '<div class="ezgantt_milestone ' . $status . '">';
		$html .= '<h3><a href="' . $milestone->getLink() . '">' . $milestone->getTitle() . '</a></h3>';
		$html .= $this->_renderWeeks($milestone);
		foreach($milestone->getTasks() AS $task)
		{
			$html .= $this->_renderTask($task);
		}
		$html .= '</div>';
		
		return $html;
	}
	
	private function _renderWeeks($milestone)
	{		
		$html = '<div class="ezgantt_weeks"><table><tr>';
		for($i = 0, $week = $this->getFirstWeek(); $i < $this->getDurationInWeeks(); $week++, $i++)
		{
			# determine if the current week is within the milestones date range
			$weekStartDate	= $this->getFirstDayOfWeek($this->getStartDate() + (60 * 60 * 24 * 7) * $i);
			$weekEndDate		= $this->getLastDayOfWeek($weekStartDate);

			$status = $this->getFirstDayOfWeek($milestone->getStartDate()) <= $weekStartDate && $this->getLastDayOfWeek($milestone->getEndDate()) >= $weekEndDate ? 'active' : '';

			$html	 .= '<td class="week week_'.$week.' '.$status.'">KW '.$week.'</td>';			
			$week		= $week === 52 ? 0 : $week;
		}
		$html .= '</tr></table></div>';

		return $html;
	}
	
	private function _renderTask($task)
	{
		$margin = number_format((floor(($this->calcDurationInDays($this->getStartDate(), $task->getStartDate()) / $this->getDurationInDays()) * 100 * 100) / 100), 2, '.', '');
		$width 	= number_format((floor(($task->getDurationInDays() / $this->getDurationInDays()) * 100 * 100) / 100), 2, '.', '');
		
		$status	= $task->isCompleted() === TRUE ? 'completed' : ($task->getStartDate() > time() ? 'open' : 'active');

		$html		= '<div class="ezgantt_row ' . $status . '">';
		$html	 .= 	'<div class="ezgantt_task_title">';
		$html	 .= 		'<a href="' . $task->getLink() . '" title="' . $task->getTitle() . '">' . $task->getTitle() . '</a>';
		$html	 .= 		'</div>';
		$html	 .= 	'<div class="ezgantt_task_wrapper">';
		$html	 .= 		'<a href="' . $task->getLink() . '" title="' . $task->getTitle() . '" class="ezgantt_task" style="margin-left:' . $margin . '%; width:' . $width . '%;"></a>';
		$html	 .= 	'</div>';
		$html	 .= '</div>';
	
		return $html;
	}
}