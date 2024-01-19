<x-mail::message>
# Password Recovery Code

<span style="font-size: 16px; font-weight:500;">Hello! {{ $user_name }}</span>

You are receiving this email because a password recovery request was made for your account.

Your recovery code is:

<x-mail::panel>
<span style="font-size: 24px; font-weight: bold;">{{ $recoveryCode }}</span>
</x-mail::panel>


This code will expire in {{ $expiration }} minutes.

If you did not request a password recovery, no further action is required.

Thank you for using our services!

Best regards,<br/>
<span style="font-size: 16px; font-weight:500;">{{ config('app.name') }}</span>
</x-mail::message>
