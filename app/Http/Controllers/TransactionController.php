<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(!\Auth::user()->hasRole('admin') && !\Auth::user()->hasRole('manager') && !\Auth::user()->hasRole('editor') ){
            $posts = Transaction::orderBy('id', 'desc')->get();
        }else{
            $posts = Transaction::orderBy('id', 'desc')->get();
        }

        return view('admin.transactions.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate the field
        $data = request()->validate([
            'title' => 'required|max:255',
            'amount' => 'required',
            'date' => 'required'

        ]);

        $user = auth()->user();
        $post = new Transaction();

        $post->title = request('title');
        $post->amount = request('amount');
        $post->date = request('date');
        $post->userId = $user->id;

        $post->save();

        return redirect('/transactions')->with('success', 'Transaction Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $post = Transaction::find($id);
        return view('admin.transactions.show', ['post'=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Transaction::find($id);
        return view('admin/transactions/edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = request()->validate([
            'title' => 'required|max:255',
            'amount' => 'required',
            'date' => 'required'

        ]);

       
        $post = Transaction::findOrFail($id);

        $post->title = request('title');
        $post->amount = request('amount');
        $post->date = request('date');

        $post->save();

        return redirect('/transactions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        
        //find the post
        $post = Transaction::find($id);
        $post->delete();

        //redirect to posts
        return redirect('/transactions');
    }
}
