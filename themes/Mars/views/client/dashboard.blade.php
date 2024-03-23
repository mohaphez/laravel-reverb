<x-layouts.app>

    <x-layouts.dashboard>
        <map-component id="{{travel()->first()?->tracking_code}}"></map-component>
    </x-layouts.dashboard>

</x-layouts.app>