<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'companyAuthorization']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = (new Room)->getRoomsByUser(Auth::id());
        $username = Auth::user()->name;
        $userId = Auth::id();

        return view('room.index', compact('rooms', 'username', 'userId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'chat_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
         ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }
        
        $file = $request->file('chat_file');
        $fileName = Str::orderedUuid()->toString() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('chats/' . $request->room_id, $fileName);

        return response()->json([
            'status' => 'success',
            'file_name' => $fileName
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        $chats = Chat::where('room_id', $room->id)
                    ->leftJoin('users', 'users.id', '=', 'chats.sender_id')
                    ->select(['chats.id', 'sender_id', 'users.name as sender_name', 'message', 'media_type'])
                    ->orderBy('id', 'desc')
                    ->paginate(10);
        
        $response['user_id'] = Auth::id();
        $response['room_id'] = $room->id;
        $response['room_type'] = $room->type;
        $response['chats'] = $chats;

        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
