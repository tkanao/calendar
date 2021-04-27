<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Yasumi\Yasumi;
use App\Account;
use App\Calendar\CalendarView;

class CalendarController extends Controller
{
    public function create(Request $request)
    {
    // クエリーのdateを受け取る
    $date = $request->input("date");
    // 取得できない時は現在を指定する
    if(!$date)$date = date('Y-m', strtotime('now'));

    // カレンダーに渡す
    $calendar = new CalendarView($date);
    
    return view('calendar.create', ["calendar" => $calendar]);
       
    }
    
    public function update(Request $request) {
        $this->validate($request, Account::$rules);

        // データの保存
        $account = new Account;
        if ($account->user_id === null) {
            $account->user_id = Auth::User()->id;
            $account->user_name = Auth::User()->name;
        } 
        $form = $request->all();
        unset($form['_token']);
        $account->fill($form);
        
        $account->save();
        
        return redirect('calendar/create');
    }
}
