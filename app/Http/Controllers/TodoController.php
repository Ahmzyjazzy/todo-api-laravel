<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Todo;
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
        $todos = Todo::where('user_id', auth()->user()->id)->paginate(10);
        return (TodoResource::collection($todos))
        ->response()
        ->setStatusCode(200);;
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
            'title' => 'required|string|max:255',
        ]);
        if ($validator->fails())
        {
            return response([
                'errors'=>$validator->errors()->all(),
                'status' => false,
                'data' => null
            ], 422);
        } 

        $todo = new Todo; 

        $todo->id               =   $request->input('todo_id');
        $todo->user_id          =   $request->user()->id; //get user id from request  
        $todo->title            =   $request->input('title');
        $todo->description      =   $request->input('description');
        $todo->is_completed     =   0;   
        $todo->slug             =   Str::slug($request->input('title'), '_');

        if($todo->save()){
            return (new TodoResource($todo))
            ->response()
            ->setStatusCode(201);
        }
    }

     /**
     * Update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'todo_id' => 'required|int',
        ]);
        if ($validator->fails())
        {
            return response([
                'errors'=>$validator->errors()->all(),
                'status' => false,
                'data' => null
            ], 422);
        } 

        $todo = Todo::where('user_id', auth()->user()->id)
                ->where('id', $request->input('todo_id'))->first();
        
        if($todo){
            
            $todo->id                   =   $request->input('todo_id');
            $todo->user_id              =   $request->user()->id; //get user id from request 

            if ($request->has('title')) {
                $todo->title            =   $request->input('title');
                $todo->slug             =   Str::slug($request->input('title'), '_');
            }
            if ($request->has('description')) {
                $todo->description      =   $request->input('description');
            }
            if ($request->has('is_completed')) {
                $validator = Validator::make($request->all(), [
                    'is_completed' => 'boolean',
                ]);
                if ($validator->fails())
                {
                    return response([
                        'errors'=>$validator->errors()->all(),
                        'status' => false,
                        'data' => null
                    ], 422);
                }
                $todo->is_completed            =   $request->input('is_completed');
            }  
    
            if($todo->save()){
                return (new TodoResource($todo))
                ->response()
                ->setStatusCode(200);
            }
        }
        
        return (new TodoResource($todo))
        ->response()
        ->setStatusCode(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $todo = Todo::where(['user_id' => auth()->user()->id, 'id' => $id])->first();
        if($todo){
            return (new TodoResource($todo))
            ->response()
            ->setStatusCode(200);
        }

        return (new TodoResource($todo))
        ->response()
        ->setStatusCode(403);        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = Todo::where(['user_id' => auth()->user()->id, 'id' => $id])->first();

        if($todo){
            if($todo->delete()){
                return (new TodoResource($todo))
                ->response()
                ->setStatusCode(200);
            }
        }

        return (new TodoResource($todo))
        ->response()
        ->setStatusCode(403); 
    }

}
