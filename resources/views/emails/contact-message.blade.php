@component('emails.layout', ['title' => 'Contact Message'])
<h1 style="font-size:22px;margin:0 0 6px;">New Contact Message</h1>
<p style="font-size:15px;line-height:1.6;color:#374151;margin:0 0 18px;">A new message was received from the website contact form.</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;margin:0 0 18px;">
    <tr><td style="padding:4px 0;color:#6b7280;width:120px;">Full Name</td><td style="padding:4px 0;">{{ $contactMessage->name }}</td></tr>
    @if($contactMessage->email)<tr><td style="padding:4px 0;color:#6b7280;">Email</td><td style="padding:4px 0;">{{ $contactMessage->email }}</td></tr>@endif
    @if($contactMessage->phone)<tr><td style="padding:4px 0;color:#6b7280;">Phone</td><td style="padding:4px 0;">{{ $contactMessage->phone }}</td></tr>@endif
    @if($contactMessage->subject)<tr><td style="padding:4px 0;color:#6b7280;">Subject</td><td style="padding:4px 0;">{{ $contactMessage->subject }}</td></tr>@endif
</table>

<div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;padding:16px 18px;font-size:14px;line-height:1.7;color:#374151;white-space:pre-line;">{{ $contactMessage->message }}</div>
@endcomponent
