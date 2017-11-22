<?php

namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use \App\Model\admin\Section as SectionModel;
use \App\Model\admin\Novel as NovelModel;

class Section extends BaseController
{
    //章节添加
    public function add(Request $request)
    {
        $status = NovelModel::where('id',request('id'))
            ->get(['status'])->toArray();
        $status = $status[0]['status'];
        if($status==1)
            return back()->with('msg','已完结,不能上传新章节');
        if(!NovelModel::change(request('id')))
            return back()->with('msg','你没有权限修改');
        $novel_id = $request->get('id');
        $section = $request->get('section');

        return view('admin/novel/addSection',['novel_id'=>$novel_id,'sections'=>$section]);
    }

    public function doAdd(Request $request)
    {
        if(!NovelModel::change(request('novel_id')))
            return back()->with('msg','你没有权限修改');
        $input = $request->all();
        //2.上传路径
        $destination = 'storage/novel/sections/'.$input['novel_id'].'/';
        //如果都通过，转存
        $newName = 'Section'.($input['sections']+1).'.txt';
        if($file = $request->file('address'))
        {
            //上传的是章节文件
            //1.允许类型
            $allow_extensions = ['txt','doc'];
            //3.获取文件类型
            $extension = $file->getClientOriginalExtension();
            //4.最大
            $max = 4*1024*1024;
            $fileSize = $file->getClientSize();
            if(!in_array($extension,$allow_extensions)){
                return back()->with('msg','上传类型不符');
            }
            if($fileSize>=$max){
                return back()->with('msg','文件过大');
            }
            if(Storage::disk('public')->put($destination,$file))
            {
                $input['address'] = $destination.'/'.$newName;
                //添加进章节表
                $res1 = SectionModel::create($input);
                //更新小说表
                $novel = NovelModel::find(1);
                $novel->sections +=1;
                if($res1 && $novel->save())
                {
                    return Redirect('admin/novel/info');
                }

            }
        }else{
            //如果不是文件，转存成文件
            if(!is_dir($destination))
            {
                mkdir($destination,0777,true);
            }
            $res2 = file_put_contents($destination.'/'.$newName,$input['content']);
            $input['address'] = $destination;
            //添加进章节表
            $res1 = SectionModel::create($input);
            //更新小说表
            $novel = NovelModel::find($input['novel_id']);
            $novel->sections +=1;
            $novel->status = $input['status'];
            if($res2 && $res1 && ($novel->save()))
            {
                return Redirect('admin/novel/lists');
            }
        }
        die();
    }

}
