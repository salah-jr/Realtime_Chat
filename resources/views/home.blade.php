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
                                            <i class="fa fa-circle user-status-icon user-icon-{{ $user->id }}" title="away"></i>
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
            <p>Select A User To Begin Conversation.</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(function () {
             let user_id = "{{ auth()->user()->id }}";
             let ip_address = '127.0.0.1';
             let socket_port = '3000';

             let socket = io(ip_address + ':' + socket_port, {transports: ['websocket']});

            socket.on('connect', function(){
                socket.emit('user_connected', user_id);
            });

            socket.on('updateUserStatus', (data)=>{
                let $userStatusIcon = $('.user-status-icon');
                $userStatusIcon.removeClass('text-success');
                $userStatusIcon.attr('title', 'Away');
                console.log(data);
                $.each(data, function(key,val) {
                    if(val !== null && val !== 0){
                        console.log(key);
                        let $userIcon = $(".user-icon-"+key); //Getting user that is registered in socket users array "Connected"
                        $userIcon.addClass('text-success');
                        $userIcon.attr('title', 'Online');
                    }
                });
            });

         });
    </script>
@endpush
