<x-pulse::card :cols="$cols" :rows="$rows" :class="$class">
    <x-pulse::card-header
        name="About Application"
        details="php artisan about">
        <x-slot:icon>
            <x-icons.laravel/>
        </x-slot:icon>
    </x-pulse::card-header>

    <x-pulse::scroll :expand="$expand" wire:poll.5s="">
        <div class="space-y-2">
            @foreach($data as $title => $section)
                <section class="text-sm">
                    <h1 class="text-green-500 capitalize font-semibold text-base mb-0.5 border-b dark:border-b-gray-700">{{ Str::of($title)->replace('_', ' ') }}</h1>
                    <div class="space-y-1">
                        @foreach($section as $key => $value)
                            <div class="flex justify-between dark:text-gray-300">
                                <div
                                    class="capitalize">{{ Str::of($key)->replace('_', ' ')->replace('php', 'PHP')->replace('url', 'URL') }}</div>
                                <div>
                                    @if(is_array($value))
                                        {{ implode(', ', $value) }}
                                    @elseif(is_bool($value))
                                        {{ $value ? 'true' : 'false' }}
                                    @else
                                        {{ $value }}
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>
    </x-pulse::scroll>
</x-pulse::card>

@assets
<script src="https://cdn.tailwindcss.com"></script>
@endassets
