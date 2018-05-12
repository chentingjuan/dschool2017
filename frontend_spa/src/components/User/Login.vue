<template lang="pug">
.container
  .row
    .col-md-8.col-md-offset-2
      .panel.panel-default
        .panel-heading 登入
        .panel-body
          form.form-horizontal(method='POST', action="{{ route('login') }}")
            | {{ csrf_field() }}
            form-group
              //- (class="{{ $errors->has('email') ? ' has-error' : '' }}")
              label.col-md-4.control-label(for='email') E-Mail
              .col-md-6
                input#email.form-control(type='email', name='email', required='', autofocus='')
                //- |                                 @if ($errors->has('email'))
                span.help-block
                  strong {{ $errors->first('email') }}
                //- |                                 @endif
            form-group
              //- (class="{{ $errors->has('password') ? ' has-error' : '' }}")
              label.col-md-4.control-label(for='password') 密碼
              .col-md-6
                input#password.form-control(type='password', name='password', required='')
                //- |                                 @if ($errors->has('password'))
                span.help-block
                  strong {{ $errors->first('password') }}
                //- |                                 @endif
            .form-group(style='display:none')
              .col-md-6.col-md-offset-4
                .checkbox
                  label
                    input(type='checkbox', name='remember', checked='')
                    |  保持登入
            .form-group
              br
              .col-md-6.col-md-offset-4
                button.btn.btn-primary.form-control(type='submit')
                  | 登入
                a.btn.btn-link.form-control
                  //- (href="{{ route('password.request') }}")
                  | 忘記密碼了嗎？
          hr
          p.text-center
            | 還沒有帳號嗎？  前往 
            a(href='/register') 註冊

</template>

<script>
export default {
  data: {
    user: "",
    password: ""
  }
}
</script>

<style>

</style>
