@extends('layouts.app')

@section('public')
@endsection

@section('content')
<div class="min-h-screen flex items-center justify-center bg-white dark:bg-gray-900 px-4 py-12">
    <div class="max-w-7xl w-full grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

        {{-- Lado esquerdo: texto e ações --}}
        <div class="space-y-8 md:pl-4" data-aos="fade-left">
            <div class="space-y-4">
                <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white leading-tight">
                    Bem-vindo ao <span class="text-blue-400 dark:text-blue-400">Visita Aí</span>
                </h1>
                @if ($local)
                    <p class="text-blue-600 dark:text-blue-400 text-lg font-medium">
                        {{ $local->loc_cidade }}/{{ $local->loc_estado }}
                    </p>
                @endif
                <p class="text-gray-600 dark:text-gray-400 text-base leading-relaxed max-w-md">
                    Sistema de apoio à vigilância epidemiológica municipal.<br>
                    Acompanhe, consulte e controle visitas de forma ágil e segura.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('login') }}" data-aos="fade-left"
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow transition group">
                    <svg class="h-5 w-5 transform transition-transform duration-200 group-hover:-translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Acesso de Agentes e Gestores
                </a>

                <a href="{{ route('consulta.index') }}" data-aos="fade-left"
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-900 dark:text-white font-semibold rounded-lg shadow transition group">
                    <svg class="h-5 w-5 transform transition-transform duration-200 group-hover:-translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" />
                    </svg>
                    Consulta Pública
                </a>
            </div>

            <p class="text-xs text-gray-400 dark:text-gray-500 mt-6" data-aos="fade-left">
                &copy; {{ date('Y') }} Visita Aí · Desenvolvido por <a href="https://www.linkedin.com/in/bernardovivianvieira" target="_blank" class="text-gray-600 hover:text-gray-700 dark:text-gray-400">Bernardo Vivian Vieira</a>
            </p>
        </div>

        {{-- Lado direito: ilustração SVG --}}
        <div class="hidden md:flex justify-center" data-aos="fade-left">
            <div class="w-full max-w-md">
                <div class="w-full h-auto overflow-hidden">
                    {{-- SVG aqui --}}
                    @include('components.welcome-illustration')
                </div>
            </div>
        </div>

    </div>
</div>

<!-- AOS JS -->
 <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true
    });
</script>
@endsection