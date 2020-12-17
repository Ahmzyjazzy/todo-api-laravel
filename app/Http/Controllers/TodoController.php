<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Todo;
use App\Http\Resources\Todo as TodoResource;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::paginate(10);
        return TodoResource::collection($todos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $todo = $request->isMethod('put') ? 
        Todo::findOrFail($request->todo_id) : new Todo; 

        $todo->id               =   $request->input('todo_id');
        $todo->created_by_id    =   $request->user()->id; //get user id from request  
        $todo->title            =   $request->input('title');
        $todo->description      =   $request->input('description');
        $todo->is_completed     =   0;   
        $todo->expired_at       =   $request->input('expired_at');

        if($todo->save()){
            return new TodoResource($todo);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $todo = Todo::findOrFail($id);
        return new TodoResource($todo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        
        if($todo->delete()){
            return new TodoResource($todo);
        }
    }

}
