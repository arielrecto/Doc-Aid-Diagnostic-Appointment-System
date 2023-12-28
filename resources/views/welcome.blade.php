<x-app-layout>
    <div class="m-0 p-0 w-full min-h-screen flex flex-col">
        <x-landing-page.header :carousels="$carousels"/>
        <x-landing-page.services :services="$services" />
        <x-landing-page.about/>
        <x-landing-page.contact />
        <x-landing-page.footer/>
    </div>

     @push('js')
        <script>
            AOS.init({
                offset: 200,
                duration: 800,
                easing: 'ease-in-quad',
                delay: 100,
            });
        </script>
    @endpush -
</x-app-layout>
