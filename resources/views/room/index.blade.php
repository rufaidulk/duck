<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Duck') . ' | Chat' }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/reset.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/chat-box.css') }}" rel="stylesheet" type="text/css">

</head>
<body>

<div id="frame">
    <div id="sidepanel">
        <div id="profile">
            <div class="wrap">
                <img id="profile-img" src="http://emilcarlsson.se/assets/mikeross.png" class="online" alt="" />
                <p>{{ $username }}</p>
            </div>
        </div>
        <div id="search">
            <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
            <input type="text" placeholder="Search contacts..." />
        </div>
        <div id="contacts">
            <ul>
            @php 
                $activeChat = 'active';
            @endphp
            @foreach($rooms as $room)
                <li class="contact {{ $activeChat }}" data-room="{{ $room->room_id }}" 
                    data-room_type="{{ $room->type }}" onclick="switchRoom(this)">
                    <div class="wrap">
                        <span class="contact-status online"></span>
                        <img src="http://emilcarlsson.se/assets/louislitt.png" alt="" />
                        <div class="meta">
                            <p class="name">
                                {{ ucfirst($room->name) }}
                            </p>
                            <p class="preview">{{ $room->message }}</p>
                        </div>
                    </div>
                </li>
            @php 
                $activeChat = '';
            @endphp
            @endforeach
            </ul>
        </div>
        <div id="bottom-bar">
            <button id="addcontact"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Add contact</span></button>
            <button id="settings"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Settings</span></button>
        </div>
    </div>
    <div class="content">
        <div class="contact-profile">
            <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
            <p>Harvey Specter</p>
        </div>
        <div class="messages">
            <ul id="chat-message-body" style="padding-bottom: 18px;display: block;">
                <!-- <li class="sent">
                    <p>
                        How the hell am I supposed to get a jury to believe you when I am not even sure that I do?!
                    </p>
                </li>
                <li class="replies">
                    <p>
                        <span class="reply-user">sdfsd</span>
                        When you're backed against the wall, break the god damn thing down.
                    </p>
                </li> -->
                <!-- <div align="right">
                    <img class="chat-box-img" src="{{ asset('storage/index.jpg') }}" alt="" />
                </div>
                <div align="left">
                    <img class="chat-box-img" src="http://emilcarlsson.se/assets/louislitt.png" alt="" />
                </div> -->
            </ul>
        </div>
        <div class="message-input">
            <div class="wrap">
            <input id="chat-message-input" type="text" placeholder="Write your message..." />
            <form method="post" id="upload_form" action="{{ route('room.store') }}" enctype="multipart/form-data">
                <input type="hidden" id="csrf-token" value="{{ csrf_token() }}">
                <input type="file" id="chat-file-input" name="chat_file" style="display:none">
                <i id="chat-file-input-selector" class="fa fa-paperclip attachment" aria-hidden="true"></i>
            </form>
            <button class="submit">
                <i class="fa fa-paper-plane" aria-hidden="true"></i>
            </button>
            </div>
        </div>
    </div>
</div>

<input id="room-show-url" type="hidden" value="{{ url('room/') }}">
<input id="session-user-name" type="hidden" value="{{ $username }}">
<input id="session-user-id" type="hidden" value="{{ $userId }}">
<input id="storage-path" type="hidden" value="{{ asset('chats/') . '/' }}">

    <script type="text/javascript" src="{{ asset('js/chat.js') }}"></script>
    <script type="text/javascript">
    
        $(".messages").animate({ scrollTop: $(document).height() }, "fast");

        $("#profile-img").click(function() {
            $("#status-options").toggleClass("active");
        });

        $(".expand-button").click(function() {
          $("#profile").toggleClass("expanded");
            $("#contacts").toggleClass("expanded");
        });

        $("#status-options ul li").click(function() {
            $("#profile-img").removeClass();
            $("#status-online").removeClass("active");
            $("#status-away").removeClass("active");
            $("#status-busy").removeClass("active");
            $("#status-offline").removeClass("active");
            $(this).addClass("active");
            
            if($("#status-online").hasClass("active")) {
                $("#profile-img").addClass("online");
            } else if ($("#status-away").hasClass("active")) {
                $("#profile-img").addClass("away");
            } else if ($("#status-busy").hasClass("active")) {
                $("#profile-img").addClass("busy");
            } else if ($("#status-offline").hasClass("active")) {
                $("#profile-img").addClass("offline");
            } else {
                $("#profile-img").removeClass();
            };
            
            $("#status-options").removeClass("active");
        });

        // function newMessage() {
        //     message = $(".message-input input").val();
        //     if($.trim(message) == '') {
        //         return false;
        //     }
        //     $('<li class="sent"><img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>' + message + '</p></li>').appendTo($('.messages ul'));
        //     $('.message-input input').val(null);
        //     $('.contact.active .preview').html('<span>You: </span>' + message);
        //     $(".messages").animate({ scrollTop: $(document).height() }, "fast");
        // };

        // $('.submit').click(function() {
        //   newMessage();
        // });

        // $(window).on('keydown', function(e) {
        //     if (e.which == 13) {
        //         handleNewMessage();
        //         return false;
        //     }
        // });

    </script>

</body>
</html>
