<?php
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('tasks');
});

// バリデーション処理
Route::post('/task', function (Request $request){
    $validator = Validator::make($request->all(),[
        'name' => 'required|max:255',
    ]);

    if($validator->fails()){
        return redirect('/')
        ->withInput()
        ->withErrors($validator);

    }
    // タスク作成処理
    $task = new Task;
    $task->name = $request->name;
    $task->save();

    return redirect('/');
});

Route::get('/', function(){
    $tasks = Task::orderBy('created_at','asc')->get();

    return view('tasks',[
        'tasks' => $tasks
    ]);
});

Route::delete('/task/{task}', function(Task $task){
    $task->delete();

    return redirect('/');
});