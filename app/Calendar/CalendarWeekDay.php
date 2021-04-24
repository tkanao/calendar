<?php
namespace App\Calendar;
use Carbon\Carbon;
use Yasumi\Yasumi;

class CalendarWeekDay {
    protected $carbon;
    private $holidays = null;
    protected $isHoliday = false;

    function __construct($date){
        $this->carbon = new Carbon($date);
        $year = $this->carbon->format("Y");
        $this->holidays = Yasumi::create("Japan", $year, "ja_JP");
    }
    
    // 祝日の読み込み
    function isHoliday($date){
        if(!$this->holidays)return false;
        return $this->holidays->isHoliday($date);
    }
    
    function getClassName(){
        $classNames = [ "day-" . strtolower($this->carbon->format("D")) ];
        // 祝日ならばholidayを与える
        if($this->isHoliday($this->carbon)){
            $classNames[] = "holiday";
            
        }
        // 今日ならばtodayを与える
        if ($this->carbon->isToday()){
            $classNames[] = "today";
        }
        
    
       return implode(" ", $classNames);
    }
    
    function render(){
        if($this->isHoliday($this->carbon)){
            foreach($this->holidays as $holiday){
                if($this->carbon->format("Y-m-d") == $holiday){
            $holidayName = $holiday->getName();
                }
            }
        }else{
            $holidayName = null;
        }

        return '<p class="day">' . $this->carbon->format("j") ." ". $holidayName.'</p>';
    }
    
    function getDay(){
        return $this->carbon->format("Y-m-d");
    }
}
