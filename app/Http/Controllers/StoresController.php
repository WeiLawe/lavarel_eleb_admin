<?php

namespace App\Http\Controllers;

use App\Cat;
use App\Handlers\ImageUploadHandler;
use App\Store;
use App\Store_info;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    //添加店铺
    public function create(){
        $cats=Cat::all();
        return view('stores.create',compact('cats'));
    }

    //店铺保存
    public function store(Request $request,Store_info $store_info){
        //验证店铺
        $this->validate($request,
            [
                'name'=>'required',
                'telephone'=>'required|digits:11',
                'password'=>'required|min:6|confirmed',
                'cat_id'=>'required',
            ],
            [
                'name.required'=>'店铺名不能为空!',
                'telephone.required'=>'电话号码不能为空!',
                'telephone.digits'=>'请填写合法的电话号码!',
                'password.required'=>'密码不能为空!',
                'password.min'=>'密码不能低于6位!',
                'password.confirmed'=>'前后两次密码输入不一致!',
                'cat_id.required'=>'分类不能为空!'
            ]);

        //保存上传logo
        $uploder= new ImageUploadHandler();
        $res=$uploder->save($request->store_img,'Store/img',0);
        if($res){
            $fileName=$res['path'];
        }else{
            $fileName='';
        }

        //添加保存
        Store::create(
            [
                'name'=>$request->name,
                'telephone'=>$request->telephone,
                'password'=>bcrypt($request->password),
                'detail'=>$request->detail,
                'cat_id'=>$request->cat_id,
            ]);
        Store_info::create(
            [
                'store_id'=>$request->store_id,
                'store_img'=>$fileName,

            ]
            );

        session()->flash('success','添加商铺成功');
        return redirect()->route('stores.index');
    }

    //显示商铺列表
    public function index(Request $request)
    {
        $cats=Cat::all();
        //检查是否有keywords参数,有,需要搜索,没有 不需要搜索
        $keywords = $request->keywords;
        if($keywords){
            $store_infos = Store_info::where("store_id","{$keywords}")->paginate(10);
        }else{
            $store_infos = Store_info::paginate(10);
        }
        return view('stores.index',compact('store_infos','keywords','cats'));

    }
}
