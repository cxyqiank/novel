<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MsgController extends Controller
{
    //展示留言
    public function index()
    {
        $msgs = DB::table('msgs')->get();
        return view('msg.index',['msgs'=>$msgs]);
    }
    //发布留言
    public function add()
    {
        return view('msg/add');
    }
    //留言入库
    public function addPost()
    {
        //获取数据
        $title = $_POST['title'];
        $content = $_POST['content'];
        $data = [
            'title'=>$title,
            'content'=>$content
        ];
        //入库
        if(DB::table('msgs')->insert($data))
        {
             return "<script>alert('添加成功')</script>".redirect('/msg/index');
        }

    }
    //删除留言
    public function del($id)
    {
        return DB::table('msgs')->where('id',$id)->delete() ?"<script>alert('成功')</script>".redirect('/msg/index'):'失败';
    }
    //修改留言
    public function up($id)
    {
        if(empty($_POST))
        {
            //根据id查数据
            $msg = DB::table('msgs')->where('id',$id)->first();
            return view('msg/update',['msg'=>$msg]);
        }
        else
        {
            //提交表单修改后修改内容
            $data = [
                'title'=>$_POST['title'],
                'content'=>$_POST['content']
            ];
            if(DB::table('msgs')->where('id',$id)->update($data))
            {
                return redirect('/msg/index');
            }
            else
            {
                return 'update';
            }
        }

    }
}
