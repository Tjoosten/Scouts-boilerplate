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
                            <a href="" class="mr-3">Laravel docs</a>
                            <a href="" class="mr-3">Laracasts</a>
                            <a href="" class="mr-3">Forge</a>
                            <a href="" class="mr-3">Nieuws</a>
                            <a href="">Github</a>
                        </p>
                    </div>

                    <div class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-6">
                                    <div class="media">
                                        <x:heroicon-o-terminal class="icon text-donkergroen icon-lg mr-3"/>
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1 text-donkergroen">Media heading</h5>
                                            Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="media">
                                        <x:heroicon-o-book-open class="icon text-donkergroen icon-lg mr-3"/>
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1 text-donkergroen">Media heading</h5>
                                            Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                                        </div>
                                    </div>
                                </div
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-6">
                                    <div class="media">
                                        <x:heroicon-o-chat class="icon text-donkergroen icon-lg mr-3"/>
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1 text-donkergroen">Media heading</h5>
                                            Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="media">
                                        <x:heroicon-o-cube class="icon text-donkergroen icon-lg mr-3"/>
                                        <div class="media-body">
                                            <h5 class="mt-0 mb-1 text-donkergroen">Media heading</h5>
                                            Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
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
