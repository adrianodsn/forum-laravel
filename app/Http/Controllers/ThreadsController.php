<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\{Thread, User};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ThreadsController extends Controller
{
    protected $thread;

    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $threads = $this->thread->orderBy('created_at', 'DESC')->paginate(15);
        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $user = User::find(1);
            $data = $request->all();
            $data['slug'] = Str::slug($data['title']);
            $user->threads()->create($data);
            return redirect()->route('threads.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
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
        return view('threads.edit', compact('thread'));
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
        try {
            $thread = $this->thread->findOrFail($id);
            $data = $request->all();
            $data['slug'] = Str::slug($data['title']);
            $thread->update($data);
            dd('Tópico editado com sucesso.');
        } catch (\Exception $e) {
            dd($e->getMessage());
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
            dd('Tópico excluído com sucesso.');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
