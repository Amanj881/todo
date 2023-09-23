<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $taskLists = Task::latest()->get();

       return view('welcome',compact('taskLists'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {


        $task = [
            'task_name' => $request->task
        ];

        $taskResponse = Task::create($task);
         return response()->json(['success' => 'Task Added Successfully', 'task' => $taskResponse]);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $taskLists =$request->show_all == 0 ? Task::latest()->get() : Task::where('is_completed',0)->get();
        return response()->json(['taskLists'=>$taskLists]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       $update = Task::find($request->id);
       $update->update(['is_completed'=>$request->checked]);
       return response()->json(['update'=>$update]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $task = Task::find($id);

        $task->delete();

        return redirect()->back()
      ->with('success', 'Task deleted successfully');
    }
}
