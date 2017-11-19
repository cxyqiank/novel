<?php

namespace App\Model\admin;

use Illuminate\Support\Facades\DB;


class Novel extends BaseModel
{

    protected $fillable = ['name', 'pic', 'author', 'desc', 'status', 'sections'];
    public function hot()
    {
        return $this->hasOne(hot::class,'novel_id','id');
    }

    //首页
    public static function index()
    {
        $data['novels'] = Hot::with('Novel')->orderBy('collectors','desc')->take(10)->get();
        $sql = 'SELECT count(n.name) nums,n.author,count(h.visitors) vs,count(h.collectors) cs 
FROM novels n LEFT JOIN hots h ON n.id = h.novel_id GROUP BY n.author ORDER BY cs desc LIMIT 10';
        $data['authors'] = DB::select($sql);
        return $data;
    }
    //添加
    public static function add($input, $file)
    {
        $input = Novel::upFile($input, $file);
        //获得分类
        $cart_name = Cart::where('id',$input['cart_id'])
            ->select('name')
            ->get()
            ->toArray();
        $input['cart_name'] = $cart_name[0]['name'];
        $input['status'] = $input['sections'] =0;
        unset($input['_token']);
        //添加进小说表
        $res1 = Novel::create($input);

        //更新热度表默认值

        $hot['novel_id'] = $res1->getKey();
        $hot['visitors']= $hot['collectors'] = 0;
        $res2 =Hot::create($hot);
        //更新关系表
        $res3 = Novel_cart::add($res1->getKey(),$input['cart_name']);
        if ($res1 &&$res2 &&$res3) {
            return true;
        } else {
            return false;
        }
    }
    //修改
    public static function edit($input)
    {
        unset($input['_token'], $input['cart_id']);
        $pic = Novel::where('id', $input['id'])->get(['pic'])->toArray();
        if (isset($input['pic'])) {
            $res = unlink($pic[0]['pic']);
            $input = Novel::upFile($input['pic'], $input);
            unset($input['address']);
            if ($res) {
                return Novel::where('id', $input['id'])->update($input);
            } else {
                return false;
            }
        } else {
            $input['pic'] = $pic[0]['pic'];
            return Novel::where('id', $input['id'])->update($input);
        }
    }
    //删除
    public static function del($input)
    {
        $id = $input['id'];
        $novel = Novel::find($id);
        $res1 = $novel->delete();
        //删除图片
        $arr = $novel->toArray();
        $res2 = unlink($arr['pic']);
        //删除全部章节内容
        $res3 = Section::delAll($id);
        //更新热度表
        $res4 = Hot::del($id);
        if ($res1 && $res2 && $res3 && $res4) {
            return true;
        } else {
            return false;
        }
    }
    //查询列表
    public function lists()
    {

        $data = self::paginate(3);
        return $data;
    }
    //查询详细信息
    public static function info($id)
    {
        $data = self::where('id',$id)
            ->get()
            ->toArray();
        $data = $data[0];
        $data['hots'] = self::find($id)->hot()
            ->get(['visitors','collectors'])
            ->toArray();
        $data['hots'] = $data['hots'][0];
        $data['cname'] = Cart::info($id);
        return $data;
    }
    //上传文件
    public static function upFile($input, $file)
    {
        $path = '/uploads/novelPic/'.date('Y/md');
        //文件上传
        $input = BaseModel::uploadPic($input, $file, $path);
        //添加全部数据
        return $input;
    }
    public static function show($ad)
    {
        $file = trim($ad);
        $content = file_get_contents($file)?:false;
        if(!$content)
        {
            return '404 NOT FOUND';
        }
        return $content;
    }
}
