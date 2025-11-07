<?php

//use GuzzleHttp\Psr7\Response;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
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



// class Task
// {
//   public function __construct(
//     public int $id,
//     public string $title,
//     public string $description,
//     public ?string $long_description,
//     public bool $completed,
//     public string $created_at,
//     public string $updated_at
//   ) {
//   }
// }

// $tasks = [
//   new Task(
//     1,
//     'Buy groceries',
//     'Task 1 description',
//     'Task 1 long description',
//     false,
//     '2023-03-01 12:00:00',
//     '2023-03-01 12:00:00'
//   ),
//   new Task(
//     2,
//     'Sell old stuff',
//     'Task 2 description',
//     null,
//     false,
//     '2023-03-02 12:00:00',
//     '2023-03-02 12:00:00'
//   ),
//   new Task(
//     3,
//     'Learn programming',
//     'Task 3 description',
//     'Task 3 long description',
//     true,
//     '2023-03-03 12:00:00',
//     '2023-03-03 12:00:00'
//   ),
//   new Task(
//     4,
//     'Take dogs for a walk',
//     'Task 4 description',
//     null,
//     false,
//     '2023-03-04 12:00:00',
//     '2023-03-04 12:00:00'
//   ),
// ];









Route::get('/', function () {
  return redirect()->route('tasks.index');
});



Route::get('/tasks', function () {
  return view('index', [
    'tasks' => Task::latest()->paginate(10)
    //optional to get only compeletd task
    //'tasks' => \App\Models\Task::latest()->where('completed',true)->get()
  ]);
})->name('tasks.index');


Route::view('/tasks/create', 'create')
  ->name('tasks.create');

Route::get('/tasks/{task}', function (Task $task) {
  return view('show', [
    'task' => $task
  ]);
})->name('tasks.show');


Route::get('/tasks/{task}/edit', function (Task $task) {
  return view('edit', [
    'task' => $task
  ]);
})->name('tasks.edit');





Route::post('/tasks', function (TaskRequest $request) {

  // $data = $request->validated();
  // $task = new Task();
  // $task->title = $data['title'];
  // $task->description = $data['description'];
  // $task->long_description = $data['long_description'];

  // $task->save();

  $task = Task::create($request->validated());

  return redirect()->route(route: 'tasks.show', parameters: ['task' => $task->id])
    ->with(key: 'success', value: 'Task created successfully');
})->name(name: 'tasks.store');




Route::put('/tasks/{task}', function (Task $task, TaskRequest $request) {
  // $data = $request->validated();
  // $task->title = $data['title'];
  // $task->description = $data['description'];
  // $task->long_description = $data['long_description'];

  // $task->save();

  $task->update($request->validated());

  return redirect()->route(route: 'tasks.show', parameters: ['task' => $task->id])
    ->with(key: 'success', value: 'Task updated successfully');
})->name(name: 'tasks.update');

Route::delete('/task/{task}', function (Task $task) {
  $task->delete();

  return redirect()->route(route: 'tasks.index')
    ->with(key: 'success', value: 'Task deleted successfully!');
})->name('task.destory');

Route::fallback(function () {
  return 'still got somewhere!';
});


Route::put('task/{id}/toogle-complete', function(Task $task) {
  $task->completed = !$task->completed;
  $task->save();

  return redirect()->back()->with('success', 'Task update successfully!');
});


Route::put('task/{task}/toggle-complete', function(Task $task) {
    $task->toggleComplete();

    return redirect()->back()->with('success', 'Task updated successfully!');
})->name('tasks.toggle-complete');