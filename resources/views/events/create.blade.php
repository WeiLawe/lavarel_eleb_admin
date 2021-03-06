@extends('layouts.default')
@section('title','添加抽奖活动')
    @section('content')
        <form action="{{route('events.store')}}" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <label>抽奖活动标题名:</label>
                <div class="row">
                    <div class="col-sm-3">
                        <input type="text" name="title" class="form-control" placeholder="抽奖活动标题" value="{{old('title')}}">
                    </div>
                </div>
            </div>

            <div class="form-group">


                        <label>抽奖活动内容:</label>
                        <script id="ue-container" name="detail"  type="text/plain">{!! old('detail') !!}</script>


            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-2">
                        <label>抽奖报名开始时间:</label>
                        <input type="date" name="signup_start" class="form-control" value="{{old('signup_start')}}">
                    </div>
                    <div class="col-sm-2">
                        <label>抽奖报名结束时间:</label>
                        <input type="date" name="signup_end" class="form-control" value="{{old('signup_end')}}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-2">
                        <label>开奖时间:</label>
                        <input type="date" name="prize_date" class="form-control" value="{{old('prize_date')}}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-2">
                        <label>抽奖限制人数:</label>
                        <input type="number" name="signup_num" class="form-control" value="{{old('signup_num')}}">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-default">确认添加</button>

        </form>
        @stop
@section('js')

    <!-- ueditor-mz 配置文件 -->
    <script type="text/javascript" src="{{asset('ueditor/ueditor.config.js')}}"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="{{asset('ueditor/ueditor.all.js')}}"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('ue-container');
        ue.ready(function(){
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });
    </script>

    @stop