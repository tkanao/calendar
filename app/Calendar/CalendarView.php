<?php
namespace App\Calendar;

use Carbon\Carbon;
use Yasumi\Yasumi;
use App\Account;
use App\Calendar\CalendarWeekDay;

class CalendarView {
    private $carbon;
    
    function __construct($date){
        $this->carbon = new Carbon($date);
    }
    
    // タイトル
    public function getTitle(){
        return $this->carbon->format('Y年 n月');
    }
            
    // 次の月
    public function getNextMonth(){
        return $this->carbon->copy()->addMonthsNoOverflow()->format('Y-m');
    }
    
    // 前の月
    public function getPreviousMonth(){
        return $this->carbon->copy()->subMonthsNoOverflow()->format('Y-m');
    }
    
    // カレンダーを出力
    function render(){
        // カレンダーのテーブル
        $html = [];
        $html[] = '<div class="calendar">';
        $html[] = '<table class="table" width="100%">';
        $html[] = '<thead>';
        $html[] = '<tr>';
        $html[] = '<th width="14%">日</th>';
        $html[] = '<th width="14%">月</th>';
        $html[] = '<th width="14%">火</th>';
        $html[] = '<th width="14%">水</th>';
        $html[] = '<th width="14%">木</th>';
        $html[] = '<th width="14%">金</th>';
        $html[] = '<th width="14%">土</th>';
        $html[] = '</tr>';
        $html[] = '</thead>';
        
        $html[] = '<tbody>';
        
        $weeks = $this->getWeeks();
        
        foreach($weeks as $week){
            $html[] = '<tr class="'.$week->getClassName().'">';
            $days = $week->getDays();
            
            foreach($days as $day){
                $html[] = '<td class="'.$day->getClassName().'">';
                // カレンダーの日付を表示する
                $html[] = $day->render();
                
                    // $html[] = '<div>';
                    
                            // $dayがBlanckdayでなければ収支を表示する
                            // if(get_class($day) == 'App\Calendar\CalendarWeekDay'){
                                // カレンダーと同じ日の収入メモをを取得する
                                // $day_incomes = $this->getTransaction($day, 'income');
                                // $day_income_memos = $this->getMemo($day, 'income');
                                
                                // カレンダーと同じ日の支出メモをを取得する
                                // $day_outcomes = $this->getTransaction($day, 'outcome');
                                // $day_outcome_memos = $this->getMemo($day, 'outcome');
                                
                                // foreach((array)$day_incomes as $day_income) {
                                //     if ($day_income !== 0) {
                                //     $html[] = '<div class="income tool">';
                                //         $html[] = $day_income. "円";
                                //             $html[] = '<div class="description">';
                                //                 foreach($day_income_memos as $day_income_memo) {
                                //                     if ($day_income !== 0) {
                                //                     $html[] = $day_income_memo->memo .'<br>';}
                                //                 }
                                //             $html[] = '</div>';
                                //     $html[] = '</div>';}
                                // }

                                // foreach((array)$day_outcomes as $day_outcome) {
                                //     if ($day_outcome !== 0) {
                                //     $html[] = '<div class="outcome tool">';
                                //     $html[] = $day_outcome. "円";
                                //         $html[] = '<div class="description">';
                                //             foreach($day_outcome_memos as $day_outcome_memo) {
                                //                 if ($day_outcome !== 0) {
                                //                 $html[] = $day_outcome_memo->memo. '<br>';}
                                //             }
                                //         $html[] = '</div>';
                                //     $html[] = '</div>';}
                                // }
                                
                            // }
                            
                    $html[] = '</div>'; 
                $html[] = '</td>';}
            $html[] = '</tr>';
        }
        
        $html[] = '</tbody>';
        
        $html[] = '</table>';
        $html[] = '</div>';
        
        return implode("", $html);
    }    
    
    // private function getTransaction($day, $transactionType) {
    //     return Transaction::where('date', $day->getDay())
    //         ->where('transaction_type', $transactionType)
    //         ->orderBy('created_at')->get()
    //         ->pluck('amount')->sum();
    // }
    
    // private function getMemo($day, $transactionType) {
    //     return Transaction::where('date', $day->getDay())
    //         ->where('transaction_type', $transactionType)
    //         ->orderBy('created_at')->get();
    // }
    
    // 週の情報を取得する関数を作成
    protected function getWeeks(){
        $weeks = [];
        
        // 初日
        $firstDay = $this->carbon->copy()->firstOfMonth();
        
        // 月末日
        $lastDay = $this->carbon->copy()->lastOfMonth();
        
        // １週目
        $week = new CalendarWeek($firstDay->copy());
        $weeks[] = $week;

        // 週の始めを日曜日に設定
        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        // 作業用の日
        $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
        
        // 月末までループさせる
        while($tmpDay->lte($lastDay)){
            // 週カレンダーViewを作成する
            $week = new CalendarWeek($tmpDay, count($weeks));
            $weeks[] = $week;
            
            // 次の週=+7日する
            $tmpDay->addDay(7);
        }
        
        return $weeks;
    }
    
	

}