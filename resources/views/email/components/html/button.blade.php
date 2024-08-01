@props([
    'color' => 'primary',
    'align' => 'center',
])
<table class="action" align="{{ $align }}" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="{{ $align }}">
<table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="{{ $align }}">
<table width="67%" border="0" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
<a href="DUMMY_URL" class="button button-{{ $color }}" target="_blank" rel="noopener"><span class="button-text">{{ $slot }}</span>
<span><svg class="arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"></path></svg></span>
</a>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
