<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Room extends Model
{
    const TYPE_PRIVATE = 1;
    const TYPE_PUBLIC = 2;

    public function getRoomsByUser($user_id)
    {
        $latestChats = $this->getLatestChats();
        $publicRooms = $this->getPublicRoomsByUser($latestChats, $user_id);
        $privateRoomIds = $this->getPrivateRoomIdsByUser($user_id);

        $rooms = DB::table('room_users')
                            ->leftJoin('users', 'users.id', '=', 'room_users.user_id')
                            ->joinSub($latestChats, 'latest_chats', function($join) {
                                $join->on('latest_chats.room_id', '=', 'room_users.room_id');
                            })
                            ->leftJoin('rooms', 'rooms.id', '=', 'room_users.room_id')
                            ->select(['room_users.room_id', 'users.name', 'latest_chats.message', 
                                'rooms.type'])
                            ->whereIn('room_users.room_id', $privateRoomIds)
                            ->where('room_users.user_id', '!=', $user_id)
                            ->union($publicRooms)
                            ->get();
        
        return $rooms;
    }

    private function getLatestChats()
    {
        $chatByMaxId = DB::table('chats')
                        ->select(['room_id', DB::raw('Max(id) as max_id')])
                        ->groupBy('room_id');

        return DB::table('chats')
                    ->joinSub($chatByMaxId, 'chat_by_max_id', function($join) {
                        $join->on('chat_by_max_id.max_id', '=', 'chats.id');
                    })
                    ->select(['chats.room_id', 'chats.message']);
    }

    private function getPublicRoomsByUser($latestChats, $user_id)
    {
        return DB::table('rooms')
                    ->join('room_users', function($join) use ($user_id) {
                        $join->on('room_users.room_id', '=', 'rooms.id')
                            ->where('room_users.user_id', $user_id);
                    })
                    ->joinSub($latestChats, 'latest_chats', function($join) {
                        $join->on('latest_chats.room_id', '=', 'rooms.id');
                    })
                    ->select(['rooms.id as room_id', 'name', 'latest_chats.message', 'rooms.type'])
                    ->where('type', self::TYPE_PUBLIC);
    }

    private function getPrivateRoomIdsByUser($user_id)
    {
        return DB::table('room_users')
                    ->join('rooms', function($join){
                        $join->on('rooms.id', '=', 'room_users.room_id')
                            ->where('rooms.type', self::TYPE_PRIVATE);
                    })
                    ->where('room_users.user_id', $user_id)
                    ->groupBy('room_users.room_id')
                    ->get(['room_id'])->pluck('room_id')->toArray();
    }

}
