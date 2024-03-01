Hello {{ $user->name }},

You are receiving this email because we received a password reset request for your account.

Please click the following link to reset your password:
{{ url('reset-password/'.$token) }}