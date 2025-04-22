Click vào link để lấy lại mật khẩu: <a href="{{ $link = url('admin/password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
