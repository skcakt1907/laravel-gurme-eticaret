@component('emails.layout', ['title' => 'Trade Request'])
<h1 style="font-size:22px;margin:0 0 6px;">New Trade / Wholesale Request</h1>
<p style="font-size:15px;line-height:1.6;color:#374151;margin:0 0 18px;">A new order request was submitted from the website. Please get back to the customer.</p>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;margin:0 0 18px;">
    <tr><td style="padding:4px 0;color:#6b7280;width:150px;">Full Name</td><td style="padding:4px 0;">{{ $appointment->name }}</td></tr>
    <tr><td style="padding:4px 0;color:#6b7280;">Phone</td><td style="padding:4px 0;">{{ $appointment->phone }}</td></tr>
    @if($appointment->email)<tr><td style="padding:4px 0;color:#6b7280;">Email</td><td style="padding:4px 0;">{{ $appointment->email }}</td></tr>@endif
    @if($appointment->date)<tr><td style="padding:4px 0;color:#6b7280;">Requested Date</td><td style="padding:4px 0;">{{ $appointment->date }}</td></tr>@endif
    <tr><td style="padding:4px 0;color:#6b7280;">Received</td><td style="padding:4px 0;">{{ $appointment->created_at?->format('d.m.Y H:i') }}</td></tr>
</table>

@if($appointment->note)
<div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;padding:16px 18px;font-size:14px;line-height:1.7;color:#374151;white-space:pre-line;">{{ $appointment->note }}</div>
@endif
@endcomponent
