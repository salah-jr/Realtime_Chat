@extends('layouts.app')

@section('content')
<div class="container main">
    <div class="row chat-row">
        <div class="col-md-3">
            <div class="users">
                <h2>Users</h2>
                <ul class="list-group list-chat-item">

                    @if ($users->count())
                        @foreach ($users as $user)
                        <a href="{{ route('message.conversation', $user->id) }}">
                            <div class="box">
                                <li class="chat-user-list">
                                        <div class="chat-image">
                                            {!!  makeImageFromName($user->name) !!}
                                            <i class="fa fa-circle user-status-icon" title="away"></i>
                                        </div>
                                        <div class="chat-name">
                                            {{ $user->name }}

                                        </div>
                                </li>
                            </div>
                        </a>
                        @endforeach
                    @endif

                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <h1>Messages</h1>

        </div>
    </div>
</div>
@endsection
