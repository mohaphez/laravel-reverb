<x-layouts.app>

    <x-layouts.dashboard>
        @if(is_driver())
          <requestDetails-component  id="{{auth()->id()}}"/>
        @else
          <requestButton-component></requestButton-component>
        @endif
    </x-layouts.dashboard>

</x-layouts.app>