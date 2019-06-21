<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Task;
use Validator;
use Auth;
use App\Http\Controllers\Controller;



class TasksController extends Controller
{
   //クラスが呼ばれたら最初に実行する処理
   public function __construct(){
       $this->middleware('auth');
   }    
    
    
    
   //登録処理関数
   public function store(Request $request) {



   // Eloquentモデル
   $task = new Task;
   $task->user_id = Auth::user()->id;
   $task->task = $request->task;
   $task->deadline = $request->deadline;
   $task->comment = $request->comment;
   $task->save();

       // 最新のDB情報を取得して返す
       $tasks = Task::where('user_id',Auth::user()->id)
                   ->orderBy('deadline', 'asc')
                   ->get();
       return $tasks;
   }

   //表示処理関数
   public function index() {
   $tasks = Task::where('user_id',Auth::user()->id)
               ->orderBy('deadline', 'asc')
               ->get();   
        return $tasks;
   }



   //削除処理関数
   public function destroy($task_id) {
       $task = Task::where('user_id',Auth::user()->id)->find($task_id);
       $task->delete();
       // 最新のDB情報を取得して返す
       $tasks = Task::where('user_id',Auth::user()->id)
               ->orderBy('deadline', 'asc')
               ->get();
       return $tasks;
   }   



   
}
