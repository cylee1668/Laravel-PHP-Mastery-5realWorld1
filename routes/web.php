<?php

//use GuzzleHttp\Psr7\Response;

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
    'tasks' => Task::latest()->get()
    //optional to get only compeletd task
    //'tasks' => \App\Models\Task::latest()->where('completed',true)->get()
  ]);
})->name('tasks.index');


Route::view('/tasks/create', 'create')
  ->name('tasks.create');

Route::get('/tasks/{id}', function ($id) {
  return view('show', [
    'task' => Task::findOrFail($id)
  ]);
})->name('tasks.show');


Route::get('/tasks/{id}/edit', function ($id) {
  return view('edit', [
    'task' => Task::findOrFail($id)
  ]);
})->name('tasks.edit');


Route::post('/tasks', function (Request $request) {
  $data = $request->validate([
    'title' => 'required|max:255',
    'description' => 'required',
    'long_description' => 'required',
  ]);

  $task = new Task();
  $task->title = $data['title'];
  $task->description = $data['description'];
  $task->long_description = $data['long_description'];

  $task->save();

  return redirect()->route(route: 'tasks.show', parameters: ['id' => $task->id])
    ->with(key: 'success', value: 'Task created successfully');
    
})->name(name: 'tasks.store');


Route::put('/tasks/{id}', function ($id, Request $request) {
  $data = $request->validate([
    'title' => 'required|max:255',
    'description' => 'required',
    'long_description' => 'required',
  ]);

  $task = Task::findOrFail($id);
  $task->title = $data['title'];
  $task->description = $data['description'];
  $task->long_description = $data['long_description'];

  $task->save();

  return redirect()->route(route: 'tasks.show', parameters: ['id' => $task->id])
    ->with(key: 'success', value: 'Task updated successfully');
    
})->name(name: 'tasks.update');

////Before seciton 19 using this below ///
// Route::get('/tasks', function () use ($tasks) {
//     return view('index', [
//         'tasks' => $tasks
//     ]);
// })->name('tasks.index');

// Route::get('/tasks/{id}', function ($id) use($tasks) {
//     $task = collect($tasks)->firstWhere('id', $id);

//     if(!$task){
//       abort(Response::HTTP_NOT_FOUND);
//     }

//     return view('show', ['task' => $task]);
// })->name('tasks.show');
////Before seciton 19 using this above ///





// Route::get('/hello', function () {
//     return 'Hello';
// })->name('hello');

// Route::get('/hallo', function () {
//     return redirect()->route('hello');
// });

// Route::get('/greet/{name}', function ($name) {
//     return 'Hello ' . $name . '!';
// });

Route::fallback(function () {
  return 'still got somewhere!';
});
