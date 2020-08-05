<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\{Channel, Thread, User};
use App\Http\Requests\ThreadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ThreadController extends Controller
{
    protected $thread;
    protected $channel;

    public function __construct(Thread $thread, Channel $channel)
    {
        $this->thread = $thread;
        $this->channel = $channel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->authorize('threads/index');

        // if (Gate::denies('access-index-thread')) {
        //     dd('Não tenho permissão');
        // }

        $channelSlug = $request->channel;

        if ($channelSlug) {
            $threads = $this->channel->whereSlug($channelSlug)->first()->threads()->paginate(15);
        } else {
            $threads = $this->thread->orderBy('created_at', 'DESC')->paginate(15);
        }

        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Channel $channel)
    {
        return view(
            'threads.create',
            ['channels' => $channel->orderBy('name')->get()]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ThreadRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThreadRequest $request)
    {
        try {
            $user = User::find(1);
            $data = $request->all();
            $data['slug'] = Str::slug($data['title']);
            $thread = $user->threads()->create($data);
            flash('Tópico criado.')->success();
            return redirect()->route('threads.show', $thread->slug);
        } catch (\Exception $e) {
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar sua requisição.';
            flash($message)->warning();
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $thread = $this->thread->whereSlug($slug)->first();

        if (!$thread) {
            return redirect()->route('threads.index');
        }

        return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $thread = $this->thread->findOrFail($id);
        $this->authorize('update', $thread);
        return view('threads.edit', compact('thread'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ThreadRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ThreadRequest $request, $id)
    {
        try {
            $thread = $this->thread->findOrFail($id);
            $data = $request->all();
            $data['slug'] = Str::slug($data['title']);
            $thread->update($data);
            flash('Tópico editado.')->success();
            return redirect()->route('threads.show', $thread->slug);
        } catch (\Exception $e) {
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar sua requisição.';
            flash($message)->warning();
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $thread = $this->thread->findOrFail($id);
            $thread->delete();
            flash('Tópico excluído.')->success();
            return redirect()->route('threads.index');
        } catch (\Exception $e) {
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar sua requisição.';
            flash($message)->warning();
            return redirect()->back();
        }
    }
}
