<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Task;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Routing\Controller as BaseController;

class TaskController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function showAllTaskLate()
    {
        $today = today()->format('Y-m-d');

        return response()->json(Task::with('subtasks')->Where('taskfinishdate', '<', $today)->orderBy("id", "desc")->get());
    }

    public function showAllTaskToday()
    {
        $today = today()->format('Y-m-d');

        return response()->json(Task::with('subtasks')->Where('taskfinishdate', '=', $today)->orderBy("id", "desc")->get());
    }

    public function showAllTask()
    {
        return response()->json(Task::with('subtasks')->orderBy("id", "desc")->get());
    }

    public function copyTask($id, Request $request)
    {
        $task = Task::find($id);

        $this->validate($request, [
            'tasktitle' => 'required|max:30',
            'taskdescription' => 'required|max:50',
            'taskfinishdate' => 'required',
        ]);

        $task = new Task;
        $task->tasktitle = $request->tasktitle;
        $task->taskdescription = $request->taskdescription;
        $task->taskfinishdate = $request->taskfinishdate;
        $task->users_id = $request->users_id;

        $task->save();

        return response()->json($task);
    }

    public function registerTask(Request $request)
    {

        $this->validate($request, [
            'tasktitle' => 'required|max:30',
            'taskdescription' => 'required|max:50',
            'taskfinishdate' => 'required',
        ]);

        $task = new Task;
        $task->tasktitle = $request->tasktitle;
        $task->taskdescription = $request->taskdescription;
        $task->taskfinishdate = $request->taskfinishdate;
        $task->users_id = $request->users_id;

        $task->save();
        return response()->json($task);
    }

    public function showTask($id)
    {
        return response()->json(Task::with('subtasks')->find($id));
    }

    public function updateTask($id, Request $request)
    {
        $task = Task::find($id);
        $task->tasktitle = $request->tasktitle;
        $task->taskdescription = $request->taskdescription;

        $task->save();

        return response()->json($task);
    }

    public function updateTaskStatus($id, Request $request)
    {
        $task = Task::find($id);
        $task->taskstatus = $request->taskstatus;

        $task->save();

        return response()->json($task);
    }

    public function updateDate($id, Request $request)
    {
        $task = Task::find($id);
        $task->taskfinishdate = $request->taskfinishdate;

        $task->save();

        return response()->json($task);
    }

    public function deleteTask($id)
    {
        $user = Task::find($id);
        $user->delete();
        return response()->json("deletado com sucesso", 200);
    }
}
