@if (isset($data))
    <script>
        window.filamentData = @js($data);

        // console.log(window.location.pathname == '/admin/login');
    document.addEventListener('DOMContentLoaded', function() {
        if(window.location.pathname == '/admin/login'){
        document.querySelector('select').addEventListener('change', function(event) {
            if(event.target.id == 'data.cabang_id')
            {
                localStorage.setItem('cabang_id', event.target.value);
                document.cookie = `cabang_id=${event.target.value}; path=/`;
            }
        });
        }

        const meta = document.createElement('meta');
        meta.name = 'cabang_id';
        meta.content = localStorage.getItem('cabang_id');
        // Append the meta tag to the head
        document.head.appendChild(meta);
    });

    </script>
@endif

@foreach ($assets as $asset)
    @if (! $asset->isLoadedOnRequest())
        {{ $asset->getHtml() }}
    @endif
@endforeach

<style>
    :root {
        @foreach ($cssVariables ?? [] as $cssVariableName => $cssVariableValue) --{{ $cssVariableName }}:{{ $cssVariableValue }}; @endforeach
    }
</style>
