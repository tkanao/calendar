@extends('layouts.layout')

@section('title', 'カレンダー')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>カレンダー</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header text-center">
                        <a class="btn btn-outline-secondary float-left" href="{{ url('admin/book/create/?date=' . $calendar->getPreviousMonth()) }}">前の月</a>
                        <span>{{ $calendar->getTitle() }}</span>
                        <a class="btn btn-outline-secondary float-right" href="{{ url('admin/book/create/?date=' . $calendar->getNextMonth()) }}">次の月</a>
                    </div>
                    <div class="card-body">
                        {!! $calendar->render() !!}
                    </div>
                </div>
            </div>
        </div>        
    </div>
@endsection
