<x-app-layout :title="__('Welkom')">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="jumbotron jumbotron-welcome border-0 shadow-sm">
                    <h3 class="title">{{ config('app.name')  }} - {{ __('Hackaton Starter') }}</h3>
                    <p class="lead">{{ __('A hackaton starter boilerplate for Laravel projects and scouting.')  }}</p>

                    <a href="" class="btn btn-github mr-1">
                        Github
                    </a>

                    <a href="" class="btn btn-laravel">
                        Laravel {{ __('documentatie') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
