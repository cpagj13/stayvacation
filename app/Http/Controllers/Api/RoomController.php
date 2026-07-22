<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        return response()->json(Room::with('category')->get());
    }

    public function show(Room $room)
    {
        return response()->json($room->load('category'));
    }
}