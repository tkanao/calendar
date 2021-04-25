@extends('layouts.layout')

@section('title', 'カレンダー')

@section('content')
    <div class="container">
        <!--予定の入力にエラーがあれば表示-->
        <form action="{{ action('CalendarController@update') }}" method="post" enctype="multipart/form-data">
            @if (count($errors) > 0)
                <ul>
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            @endif
            @csrf 
        <!--カレンダー表示    -->
        <div class="row justify-content-center">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header text-center">
                        <a class="btn btn-outline-secondary float-left" href="{{ url('calendar/create/?date=' . $calendar->getPreviousMonth()) }}">前の月</a>
                        <span>{{ $calendar->getTitle() }}</span>
                        <a class="btn btn-outline-secondary float-right" href="{{ url('calendar/create/?date=' . $calendar->getNextMonth()) }}">次の月</a>
                    </div>
                    <div class="card-body">
                        {!! $calendar->render() !!}
                    </div>
                </div>
            </div>
        </div>    
        
        <!--予定の入力-->
            <div class="card mt-5 mb-5">
                <div class="card-header text-center">
                    予定入力
                </div>
                <div class="card-body event">
                    <div class="row justify-content-center">
                        <div class="col-md-4 text-center">日付</div>
                        <div class="col-md-8">
                            <input type="date" class="form-control" name="date">                    
                        </div>    
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4 text-center">タイトル</div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="title">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4 text-center">内容</div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="memo">
                        </div>
                    </div>
                    <br>
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-primary float-right" value="入力">
                </div>
            </div>
        </form>    
    </div>
@endsection
