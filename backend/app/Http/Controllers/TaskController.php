<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function read() {
        return Task::with('lists')->get();
    }

    public function create(Request $request) {
        Task::create([
            'list_id' => $request->list_id,
            'task_name' => $request->task_name,
            'priority' => $request->priority,
            'status' => 'Belum selesai',
            'date' => $request->date
        ]);
    }

    public function update($id) {
        $task = Task::find($id);
        $task->update([
            'status' => 'Selesai'
        ]);
    }

    public function downdate($id) {
        $task = Task::find($id);
        $task->update([
            'status' => 'Belum selesai'
        ]);
    }

    public function delete($id) {
        $task = Task::find($id);
        $task->delete();
    }
}
