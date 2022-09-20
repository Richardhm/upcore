<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{asset('storage/logo-grande.png')}}" class="logo" alt="Accert">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
