/**
 * Chat js
 * @param  {[type]} identifier [description]
 * @return {[type]}            [description]
 */
const PRIVATE_ROOM = 1;
const PUBLIC_ROOM = 2;
const USER_NAME = $("#session-user-name").val();

let currentRoomId;
let currentRoomType;

initCurrentRoomChat();

function initCurrentRoomChat()
{
    let roomId = $(".active").data().room;
    currentRoomId = roomId;
    currentRoomType = $(".active").data().room_type;
    fetchRoomChat(roomId);
}

function switchRoom(identifier)
{
    let roomId = $(identifier).data().room;
    if (currentRoomId == roomId) {
        return;
    }

    let currentRoom = $(".active");
    $(currentRoom).removeClass('active');
    $(identifier).addClass('active');

    fetchRoomChat(roomId);
}

function fetchRoomChat(roomId)
{
    $.ajax({
        url : $("#room-show-url").val() + '/' + roomId,
        type : 'GET',
        success : fetchRoomChatSuccessHandler
    })
}

function fetchRoomChatSuccessHandler(response)
{
    if (response.chats === undefined || response.chats.data.length <= 0) {
        return;
    }

    let chatHtmlBody = '';
    response.chats.data.sort((a, b) => (a.id > b.id) ? 1 : -1);

    for (let [key, chat] of Object.entries(response.chats.data)) 
    {
        let messageType = 'sent';
        let senderName = senderLabel = '';
        
        if (response.room_type == PUBLIC_ROOM) {
            senderName = chat.sender_name;
        }

        if (response.user_id != chat.sender_id) {
            messageType = 'replies'; 
            senderLabel = '<span class="reply-user">' + senderName + '</span>';
        }

        chatHtmlBody += '<li class="' + messageType + '">' +
            '<p>' + senderLabel + chat.message + '</p>' +
            '</li>';
    }
    
    if (currentRoomId != response.room_id) {
        $("#chat-message-body").html('');
        currentRoomId = response.room_id;
        currentRoomType = response.room_type;
    }

    $("#chat-message-body").prepend(chatHtmlBody);
    if (response.chats.to < response.chats.total) {
        $(".messages").on("scroll", function() {
            chatBoxScrollEventHandler(response);
        });
    }
    else {console.log("no even");
        $(".messages").off("scroll");
    }
}

function chatBoxScrollEventHandler(res)
{
    let position = $(".messages").scrollTop();

    if (position == 0)
    {
        $.ajax({
            url : res.chats.next_page_url,
            type : 'GET',
            success : fetchRoomChatSuccessHandler
        })
    }
}

/**
 * Socket
 */
const chatMessageInput = document.getElementById('chat-message-input');
const socket = new WebSocket("ws://localhost:8080/socket/jfsdifjeofjsdijfoe8uwjfspdofjsdfjsod");
socket.binaryType = "arraybuffer";

socket.onopen = function (event) {
    console.log('connected');
}

socket.onmessage = function (event) {
    console.log("New message from server");
    console.log(event.data);
    if (event.data === "") {
        return;
    }

    res = JSON.parse(event.data);
    
    if (currentRoomId == res.roomId) {
        addRecievedMessageToCurrentChatRoom(res.message, res.type, res.name);
    }
    else {
        addRecievedMessageToRoomPreview(res.roomId, res.message, res.name);
    }
}

socket.onerror = function (event) {
    console.log("Socket error " + event);
}

socket.onclose = function (event) {
    console.log("Socket connection closed");
}

$('.submit').click(function() {
    handleNewMessage();
});

//enter key
$(window).on('keydown', function(e) {
    if (e.which == 13) {
        handleNewMessage();
        return false;
    }
});

function handleNewMessage()
{
    const message = chatMessageInput.value;
    console.log('new message' + message);
    if($.trim(message) == '') {
        return false;
    }

    const payload = {
       roomId : currentRoomId,
       type : currentRoomType,
       name : USER_NAME,
       message : message 
    };

    socket.send(JSON.stringify(payload));
    addSentMessageToCurrentChatRoom(message);
}

function addSentMessageToCurrentChatRoom(message) 
{
    $('<li class="sent"><p>' + message + '</p></li>').appendTo($('.messages ul'));
    $('.message-input input').val(null);
    $('.contact.active .preview').html('<span>You: </span>' + message);
    $(".messages").animate({ scrollTop: $(document).height() }, "fast");
}

function addRecievedMessageToCurrentChatRoom(message, type, name)
{
    senderLabel = '';
    if (type == PUBLIC_ROOM) {
        senderLabel = '<span class="reply-user">' + name + '</span>';    
    }
    
    let html = '<li class="replies">' +
            '<p>' + senderLabel + message + '</p>' +
            '</li>';

    $(html).appendTo($('.messages ul'));
    $('.message-input input').val(null);
    $('.contact.active .preview').html('<span>' + name + ': </span>' + message);
    $(".messages").animate({ scrollTop: $(document).height() }, "fast");
}

function addRecievedMessageToRoomPreview(roomId, message, name)
{
    $("#contacts ul li").each(function(i, inputObj) {
        if ($(inputObj).data().room == roomId) {
            $(inputObj).find(".preview").html('<span>' + name + ': </span>' + message);
        }
    });
}
