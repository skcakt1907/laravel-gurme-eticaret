@component('emails.layout', ['title' => 'New Member'])
<h1 style="font-size:22px;margin:0 0 6px;">New Member Registration</h1>
<p style="font-size:15px;line-height:1.6;color:#374151;margin:0 0 18px;">A new customer has created an account on the website.</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;margin:0 0 18px;">
    <tr><td style="padding:4px 0;color:#6b7280;width:150px;">Full Name</td><td style="padding:4px 0;">{{ $user->name }}</td></tr>
    <tr><td style="padding:4px 0;color:#6b7280;">Email</td><td style="padding:4px 0;">{{ $user->email }}</td></tr>
    @if($user->phone)<tr><td style="padding:4px 0;color:#6b7280;">Phone</td><td style="padding:4px 0;">{{ $user->phone }}</td></tr>@endif
    <tr><td style="padding:4px 0;color:#6b7280;">Registered</td><td style="padding:4px 0;">{{ $user->created_at?->format('d.m.Y H:i') }}</td></tr>
</table>
@endcomponent
