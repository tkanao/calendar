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

    // accountにaccount_idを作成
    $account = Account::where('user_id', Auth::User()->id)->first();
    if ($account === null) {
       $account = new Account();
       $account->user_id =  Auth::User()->id;
       $account->save();}

    return view('calendar.create', ["calendar" => $calendar, "account" => $account]);
       
    }
    
    public function update(Request $request) {
        $this->validate($request, Account::$rules);
        
        // データの保存
        $account = new Account;
        // $account->user_id = Account::where('user_id', Auth::User()->id)->first();
        $form = $request->all();
        unset($form['_token']);
        $account->fill($form);
        $account->save();
        
        return redirect('calendar/create');
    }
}
