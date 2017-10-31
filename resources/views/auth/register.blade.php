@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                
                <h4>D-school@NTU 註冊(@{{registerMode=='student'?'學生':'一般'}})</h4>
                    
                <div class="row">
                    <div class="col-sm-12">
                        <div class="btn-group">
                            <div class="btn" :class="{'btn-primary':registerMode=='student'}"@click="registerMode='student'">我是學生</div>  
                            <div class="btn" :class="{'btn-primary':registerMode=='normal'}" @click="registerMode='normal'">我是社會人士</div>
                        </div>
                    </div>
                </div>
                    
                    
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}" style="display: none">
                            <label for="type" class="col-md-4 control-label">類別</label>

                            <div class="col-md-6">
                                <input id="type" class="form-control" name="type" required v-model="registerMode">

                                @if ($errors->has('type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">姓名</label>

                            <div class="col-md-6">
                                <input id="name" type="text" placeholder="王小朋" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email"  :placeholder="registerMode=='student'?'example@ntu.edu.tw':'example@gmail.com'" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">電話</label>

                            <div class="col-md-6">
                                <input id="phone" type="phone" class="form-control"  placeholder="09xxxxxxxx / 02xxxxxxxx" name="phone" value="{{ old('phone') }}" required>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <div class="form-group{{ $errors->has('school') ? ' has-error' : '' }}" v-if="registerMode=='normal'" >
                            <label for="agency" class="col-md-4 control-label">服務單位</label>

                            <div class="col-md-6">
                                <input placeholder="沒有則填寫(無)" id="agency" type="agency" class="form-control" name="agency" value="{{ old('agency') }}" :required="registerMode=='normal'?'required':''">

                                @if ($errors->has('agency'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('agency') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('school') ? ' has-error' : '' }}" v-if="registerMode=='student'" >
                            <label for="school" class="col-md-4 control-label">學校與學院</label>

                            <div class="col-md-6">
                                <input  placeholder="國立臺灣大學" id="school" type="school" class="form-control" name="school" value="{{ old('school') }}"  :required="registerMode=='student'?'required':''" list="schoolData">
                                <datalist id="schoolData">
                                    <option :value="sc" v-for="sc in schoolData">
                                </datalist>

                                @if ($errors->has('school'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('school') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('department') ? ' has-error' : '' }}" v-if="registerMode=='student'" >
                            <label for="department" class="col-md-4 control-label">系級</label>

                            <div class="col-md-6">
                                <input placeholder="電機工程學系" id="department" type="department" class="form-control" name="department" value="{{ old('department') }}" :required="registerMode=='student'?'required':''">

                                @if ($errors->has('department'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('department') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('student_id') ? ' has-error' : '' }}" v-if="registerMode=='student'" >
                            <label for="student_id" class="col-md-4 control-label">學號</label>

                            <div class="col-md-6">
                                <input id="student_id" type="student_id" class="form-control" name="student_id" value="{{ old('student_id') }}" :required="registerMode=='student'?'required':''">

                                @if ($errors->has('student_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('student_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">密碼</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">確認密碼</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary form-control">
                                    註冊
                                </button>
                            </div>
                        </div>

                        <hr>
                        <p class="text-center">已經有帳號嗎？  前往 <a href="/login">登入</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
