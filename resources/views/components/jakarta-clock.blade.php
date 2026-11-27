@props(['variant' => 'default'])

@php($jakartaNow = now('Asia/Jakarta'))

@if ($variant === 'virtulab')
    <span data-jakarta-clock class="vl-online" aria-label="Waktu saat ini di Jakarta">
        <span aria-hidden="true"></span>
        <time data-jakarta-time datetime="{{ $jakartaNow->toIso8601String() }}" class="tabular-nums">{{ $jakartaNow->format('H:i:s') }}</time>
        <abbr title="Waktu Indonesia Barat">WIB</abbr>
    </span>
@else
    <span data-jakarta-clock class="inline-flex shrink-0 items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs text-slate-700" aria-label="Waktu saat ini di Jakarta">
        <span class="size-2 rounded-full bg-blue-500" aria-hidden="true"></span>
        <time data-jakarta-time datetime="{{ $jakartaNow->toIso8601String() }}" class="font-semibold tabular-nums">{{ $jakartaNow->format('H:i:s') }}</time>
        <abbr class="font-medium text-slate-500 no-underline" title="Waktu Indonesia Barat">WIB</abbr>
    </span>
@endif
