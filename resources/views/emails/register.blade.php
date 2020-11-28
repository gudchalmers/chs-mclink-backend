@component('mail::message')
# Verify email for Minecraft account link
Copy paste the following command into Minecraft to verify: <strong>{{ $name }}</strong>

@component('mail::panel')
    /verify&nbsp;{{ $uuid }}
@endcomponent
If you have left the server you can just reconnect again:
>mc.chs.se<br><br>


You can ignore this mail if you if you didn't request this verification.

<strong>{{ config('app.name') }}</strong><br>
G.U.D.<br>
Chalmers Studentkår
@endcomponent
