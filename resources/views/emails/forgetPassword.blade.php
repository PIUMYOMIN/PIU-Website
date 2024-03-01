<h3>Hello {{ $user->name }},</h3> <br />

You are receiving this email because we received a password reset request for your account. If you wasn't you, please kindly ignore this mail.

Please click the following link to reset your password:
{{ url('reset-password/'.$token) }}