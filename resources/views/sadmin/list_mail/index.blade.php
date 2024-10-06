@extends('layouts.app')
@section('title')
{{ __('messages.send_mail.list_mail') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            @include('layouts.errors')
            <div class="d-flex justify-content-between align-items-end mb-5">
                <h1>{{ __('messages.send_mail.list_mail') }}</h1>
            </div>
            <div class="card">
                <div class="card-body">
                    <livewire:list-mail-table/>
                </div>
            </div>
        </div>
    </div>
@endsection
