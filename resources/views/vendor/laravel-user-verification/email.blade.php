歡迎註冊成為台大D-school的會員：

請按此連結驗證您的帳號<a href="{{ $link = route('email-verification.check', $user->verification_token) . '?email=' . urlencode($user->email) }}">{{ $link }}</a>
