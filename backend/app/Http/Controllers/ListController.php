<?php

namespace App\Http\Controllers;

use App\Models\Lists;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function read() {
        return Lists::all();
    }

    public function readDetail($id) {
        return Lists::find($id)->with('tasks')->get();
    }

    public function create(Request $request) {
        Lists::create([
            'list_name' => $request->list_name
        ]);
    }

    public function update(Request $request, $id) {
        $task = Lists::find($id);
        $task->update([
            'list_name' => $request->list_name
        ]);
    }

    public function delete($id) {
        $task = Lists::findOrFail($id);
        $task->delete();
    }
}
