<?php
use App\Task;
use Illuminate\Http\Request;

/**
    The web middleware includes is defined on
    the HTTP kernel and it includes session_state, csrf Protect, etc
**/
Route::group(['middleware'=>['web']], function(){
    /**

    Display all tasks

    */
    Route::get('/', function(){
        $tasks = Task::orderBy('created_at', 'asc')->get();
        return view('tasks', [
            'tasks'=>$tasks
        ]);
    });

    /**
    Add a new task
    */
    Route::post('/task', function(Request $request){
        // do some validation
        $validator = Validator::make($request->all(),[
            'name'=>'required|max:225',
        ]);

        if($validator->fails()){
            return redirect('/')
                ->withInput()
                ->withErrors($validator);

        }

        //create task if validation passes
        $task = new Task;
        $task->name = $request->name;
        $task->save();

        return redirect('/');

    });


    /**
    Delete an existing task
    */
    Route::delete('/task/{id}', function($id){
        Task::findOrFail($id)->delete();
        return redirect('/');
    });
});

