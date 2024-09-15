<div style="margin-top: 8px; margin-bottom: 24px;">
    <div style="width: fit-content; margin: auto;">
        <x-heroicon-o-envelope style="width: 80px; height: 80px; text-align: center; color:black"/>
    </div>

    <h1 style="margin-bottom: 1rem; font-size: 1.875rem; line-height: 1.5; text-align: center; color: #000000;">@lang('teavel::auth.title.success')</h1>
    <p>@lang('teavel::auth.message.success_1')</p>

    <p style="margin-top: 16px">@lang('teavel::auth.message.success_2')</p>
    <a href="{{ route('register') }}" style="margin-top: 16px; display: block; text-align: center; text-decoration-line: underline;">@lang('teavel::auth.link.success_register')</a>
</div>
