<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Subtask;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Routing\Controller as BaseController;

class SubtaskController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function search(Request $request)
    {
        $search = $request->input('search');
        if ($search) {
            $subtask = Subtask::with('task')->where('task_id', 'like', '%' . $search . '%')->get();
        } else {
            $subtask = Subtask::all();
        }
        return  response()->json($subtask);
    }

    public function showAllSubtask()
    {
        return response()->json(Subtask::with('task')->orderBy("id", "desc")->get());
    }

    public function showTaskId($task_id)
    {
        return response()->json(Subtask::with('task')->where('task_id', 'like', '%' . $task_id . '%')->get());
    }

    public function registerSubtask(Request $request)
    {
        $this->validate($request, [
            'subtasktitle' => 'required|max:35',
            'subtaskdescription' => 'required|max:50',
        ]);
        $subtask = new Subtask;
        $subtask->subtasktitle = $request->subtasktitle;
        $subtask->subtaskdescription = $request->subtaskdescription;
        $subtask->task_id = $request->task_id;

        $subtask->save();
        
        return response()->json($subtask);
    }

    public function showSubtask($id)
    {
        return response()->json(Subtask::find($id));
    }

    public function updateSubtask($id, Request $request)
    {
        $subtask = Subtask::find($id);
        $subtask->subtasktitle = $request->subtasktitle;
        $subtask->subtaskdescription = $request->subtaskdescription;

        $subtask->save();

        return response()->json($subtask);
    }

    public function updateSubtaskStatus($id, Request $request)
    {
        $subtask = Subtask::find($id);
        $subtask->subtaskstatus = $request->subtaskstatus;

        $subtask->save();

        return response()->json($subtask);
    }

    public function deleteSubtask($id)
    {
        $user = Subtask::find($id);
        $user->delete();
        return response()->json("deletado com sucesso", 200);
    }
}
