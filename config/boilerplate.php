<?php

return [
    'features' => [
        'api' => true,
    ],

    /**
     * -----------------------------------------------------------------------------------------------------------------
     * Serviceprovider parts configuration
     * -----------------------------------------------------------------------------------------------------------------
     *
     * Because of the Domain Driven Design approach we extended the default
     * service provider and added some custom configuration flags for loading resources. If the flag is configured
     * to be false. The serviceprovider will skip the loading of that resource
     *
     * boilerplate.serviceprovider.policies     = Configuration flag for loading authorization policies
     * boilerplate.serviceprovider.commands     = Configuration flag for loading commands related to the domain
     * boilerplate.serviceprovider.factories    = Configuration flag for loading specific database seeding factories
     * boilerplate.serviceprovider.migrations   = Configuration flag for loading database migrations for the domain
     * boilerplate.serviceprovider.translations = Configuration flag for loading domain related translations.
     */

    'serviceprovider' => [
        'policies' => true,
        'commands' => true,
        'factories' => true,
        'migrations' => true,
        'translations' => true,
    ]
];
