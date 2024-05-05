<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Http\Resources\MessageResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Message::all();
        return $this->customeResponse(MessageResource::collection( $messages), "All Retrieve  Messages Success", 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MessageRequest $request)
    {
        try {
            DB::beginTransaction();
            $message = Message::create([
                'client_name'                 => $request->client_name,
                'client_email'                => $request->client_email,
                'message_subject'             => $request->message_subject,
                'message_description'         => $request->message_description,

            ]);
            DB::commit();

            return $this->customeResponse(new MessageResource($message),'the Message created successfully',201);


        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return $this->customeResponse(null,' the Message not created',500);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    { try {
        return $this->customeResponse(new MessageResource($message), 'ok', 200);
    } catch (\Throwable $th) {
        Log::debug($th);
        return $this->customeResponse(null, 'Not Found', 404);
    }

    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        try {
            $message ->delete();
            return $this->customeResponse('', 'Message  deleted successfully', 200);
        } catch (\Throwable $th) {
            Log::debug($th);
            return $this->customeResponse(null, 'Not Found', 404);
        }
    }
}
