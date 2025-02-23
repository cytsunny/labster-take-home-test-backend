<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserMessage;
use App\Jobs\ProcessMessage;

class UserMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'testing index';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'message' => 'required'
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'message' => 'Invalid input',
            ], 400);
        };

        $user = User::firstOrCreate(
            ['email' => $request->input('email')],
            ['name' => '', 'password' => '']
        );

        $userMessage = UserMessage::create([
            'user_id' => $user->id,
            'message' => $request->input('message'),
            'status' => 'pending',
        ]);

        ProcessMessage::dispatch($userMessage);
        return $userMessage;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
