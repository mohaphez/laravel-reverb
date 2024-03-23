<x-layouts.app>
    @if($errors)
        @foreach($errors as $error)
            <x-alerts.error :message="$error" />
        @endforeach
    @endif
    <login-component></login-component>
</x-layouts.app>