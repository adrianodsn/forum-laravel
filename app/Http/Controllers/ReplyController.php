<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use App\Thread;

class ReplyController extends Controller
{
    public function store(ReplyRequest $request)
    {
        try {
            $thread = Thread::find($request->thread_id);
            $data = $request->all();
            $data['user_id'] = 1;
            flash('Resposta registrada.')->success();
            $thread->replies()->create($data);
        } catch (\Exception $e) {
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar sua requisição.';
            flash($message)->warning();
        }

        return redirect()->back();
    }
}
