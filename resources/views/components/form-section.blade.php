<div {{ $attributes->merge(["class" => " md:grid md:grid-cols-3 md:gap-6"]) }}>
    <div class=" px-4 sm:px-0">
        <h3 class=" text-lg font-medium text-gray-900">
            {{ $title }}
        </h3>
        <p class=" mt-1 text-sm text-gray-600">
            {{ $description }}
        </p>

    </div>
    <div class=" mt-5 md:mt-0 md:col-span-2">
        <div class>
            {{-- div para el formulario --}}
            <div class=" px-4 p-6 bg-white shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                {{ $slot }}
            </div>
            {{-- div para los botones de accion --}}
            @isset($actions)
                <div class=" px-6 py-3 shadow bg-gray-100 flex justify-end items-center rounded-bl-md rounded-br-md">
                    {{ $actions }}
                </div>
            @endisset
        </div>
    </div>

</div>