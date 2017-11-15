<?php

namespace App\Model\admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class BaseModel extends Model
{
    public static function uploadPic($input,$file,$path)
    {
        //2.允许上传格式
        $allow_extensions = ['jpg','jpeg','png','gif'];
        //3.上传路径
        $date = date('Y/md');
        $destination = $path.'/'.$date;
        //4.获取文件类型
        $extension = $file->getClientOriginalExtension();
        //判断文件类型
        if(!in_array($extension,$allow_extensions))
        {
            return back()->with('msg','图片上传类型错误');
        }
        $fileSize = $file->getClientSize();
        $maxSize = 4*1024*1024;
        if($fileSize>$maxSize)
        {
            return back()->with('msg','图片过大请处理后上传');
        }
        $ad = Storage::disk('public')->put($destination,$file);
        //添加全部数据
        $input['pic'] = 'storage/'.$ad;
        return $input;
    }
    //删除目录
    public static function dropDir($dir)
    {
        if(is_dir($dir))
        {
            $handle = opendir($dir);
            while($file=readdir($handle))
            {
                if($file='.'||$file='..')
                {
                    continue;
                }
                if(is_file($dir.'/'.$file))
                {
                    unlink($dir.'/'.$file);
                }
                else
                {
                    self::dropDir($dir.'/'.$file);
                }
            }
            rmdir($dir);
            closedir($handle);
        }else{
            unlink($dir);
        }
    }
    //手动分页
    /*
     * Create myPage
     *
     * @param array $res
     * @param int $per
     * @param string $path
     */
    public static function myPage($res,$per=3,$path='./')
    {
        //总数
        $total = count($res);
        //当前页
        $currentPage = (int)isset($_GET['page'])?$_GET['page']:1;
        //获取当前页的数组
        $collection = array_slice($res, ($currentPage-1)*$per,$per);
        //实例化分页类
        $page = new LengthAwarePaginator($collection,$total,$per,$currentPage,['path'=>$path]);
        return $page;
    }
}