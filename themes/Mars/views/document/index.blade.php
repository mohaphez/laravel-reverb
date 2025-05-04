<x-layouts.app>

    <x-layouts.dashboard>
        <editor-component 
            document-id="{{ $documentId ?? '1' }}"
            :initial-content="{{ json_encode(auth()->user()->description ?? '') }}"
        ></editor-component>
    </x-layouts.dashboard>

</x-layouts.app>