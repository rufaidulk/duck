/**
 * Chat js
 * @param  {[type]} identifier [description]
 * @return {[type]}            [description]
 */
const PRIVATE_ROOM = 1;
const PUBLIC_ROOM = 2;

let currentRoomId;

initCurrentRoomChat();

function initCurrentRoomChat()
{
    let roomId = $(".active").data().room;
    currentRoomId = roomId;
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



