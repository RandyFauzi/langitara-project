@props(['title', 'value', 'icon' => null, 'trend' => null, 'bgIcon' => 'bg-rose-50', 'textIcon' => 'text-rose-600'])

<div
    class="bg-white overflow-hidden rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300">
    <div class="p-5">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="rounded-lg p-3 {{ $bgIcon ?? 'bg-rose-50' }}">
                    @if(isset($icon) && $icon)
                        {!! $icon !!}
                    @endif
                </div>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        {{ $title }}
                    </dt>
                    <dd>
                        <div class="text-2xl font-bold text-gray-900">
                            {{ $value }}
                        </div>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
    @if(isset($trend) && $trend)
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                {!! $trend !!}
            </div>
        </div>
    @endif
</div>