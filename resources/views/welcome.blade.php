<x-app-layout :title="__('Welkom')">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-muted mb-3">
                    <x-heroicon-o-server class="icon text-bruin mr-1"/> {{ request()->ip() }}
                    <x-heroicon-o-chevron-right class="icon"/>
                    <x-heroicon-o-database class="icon text-bruin mr-1"/> {{ \Illuminate\Support\Facades\DB::getDefaultConnection() }}: {{ \Illuminate\Support\Facades\DB::connection()->getDatabaseName() }}
                    <x-heroicon-o-chevron-right class="icon"/>
                    <x-heroicon-o-code class="icon text-bruin mr-1"/> PHP: v{{ phpversion() }}
                    <x-heroicon-o-chevron-right class="icon"/>
                    <x-heroicon-o-cube class="icon text-bruin mr-1"/> Laravel v{{ Illuminate\Foundation\Application::VERSION }}
                </div>

                <div class="card shadow-sm">
                    <div class="card-body border-0">
                        <h3 class="text-bruin">Scouts boilerplate</h3>
                        <p class="text-bijna-zwart">
                            Deze boilerplate is gericht om snel een start te kunnen maken op hackatons
                            die betrekking hebben tot applicaties voor jeugdbewegingen. In deze boilerplate zitten enkele
                            standaard features zoals user management, authenticatie, api authenticatie en account settings.
                        </p>

                        <p class="mb-0">
                            <a href="https://laravel.com" class="text-decoration-none mr-3">Laravel docs</a>
                            <a href="https://laracasts.com" class="text-decoration-none mr-3">Laracasts</a>
                            <a href="https://forge.laravel.com" class="text-decoration-none mr-3">Forge</a>
                            <a href="https://vapor.laravel.com" class="text-decoration-none mr-3">Vapor</a>
                            <a href="https://blog.laravel.com" class="text-decoration-none mr-3">Nieuws</a>
                            <a href="https://github.com/Tjoosten/Scouts-boilerplate" class="text-decoration-none">Github</a>
                        </p>
                    </div>

                    <div class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-6">
                                    <div class="media">
                                        <x:heroicon-o-terminal class="icon text-donkergroen icon-lg mr-3"/>
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1 text-donkergroen">Development commands & debugging</h5>
                                            Laravel Telescope en debugbar is standaard geimplementeerd om het debugging van je applicatie te vergemakkelijken.
                                            Als ook kunt u nieuw controllers, request, etc aanmaken doormiddel van de artisan CLI
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="media">
                                        <x:heroicon-o-book-open class="icon text-donkergroen icon-lg mr-3"/>
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1 text-donkergroen">Documentatie</h5>
                                            De boilerplate is zo goed mogelijk gedocumenteerd in de bijhorende wiki. Die te vinden is in de repository.
                                            Let wel op de documentatie is echter nog niet volledig op dit moment.
                                        </div>
                                    </div>
                                </div
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row mb-1">
                                <div class="col-6">
                                    <div class="media">
                                        <x:heroicon-o-chat class="icon text-donkergroen icon-lg mr-3"/>
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1 text-donkergroen">Community</h5>
                                            Hebt u een probleem tijdens het ontwikkelen of wil je laten zien wat je hebt gebouwd met de boilerplate. Dat kan eenvoudig door middel
                                            van het disccussions tabblad in de github repository.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="media">
                                        <x:heroicon-o-cube class="icon text-donkergroen icon-lg mr-3"/>
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1 text-donkergroen">Laravel framework</h5>
                                            De scouts boilerplate is gebouwd op basis van het Laravel v{{ Illuminate\Foundation\Application::VERSION }} framework.
                                            Zodat u snel en gemakkelijk aan de slag kunt met 1 van de meest gebruikte PHP frameworks die er momenteel zijn.
                                        </div>
                                    </div>
                                </div
                            </div>
                        </li>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
