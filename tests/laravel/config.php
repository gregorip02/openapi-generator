<?php

return [
    'outputpath' => resource_path('openapi.yml'),

    'wildcards' => [
        '/^\/?api\/*/'
    ],

    'template' => [
        /**
         * @required
         * This string MUST be the semantic version number of the OpenAPI Specification
         * version that the OpenAPI document uses. The openapi field SHOULD be
         * used by tooling specifications and clients to interpret the OpenAPI
         * document. This is not related to the API info.version string.
         *
         * @see https://swagger.io/specification/#versions
         */
        'openapi' => '3.0.1',
        /**
         * @required
         * An array of Server Objects, which provide connectivity information to
         * a target server. If the servers property is not provided, or is an
         * empty array, the default value would be a Server Object with a url
         * value of /.
         *
         * @see https://swagger.io/specification/#server-object
         */
        'servers' => [
            [
                'url' => 'http://api.petstore.com/',
                'description' => 'Pet store production server'
            ],
            [
                'url' => 'http://dev.petstore.com/',
                'description' => 'Pet store development server'
            ]
        ],
        /**
         * @required
         * Provides metadata about the API. The metadata MAY be used by tooling
         * as required.
         *
         * @see https://swagger.io/specification/#info-object
         */
        'info' => [
            /**
             * @required
             * The title of the API.
             */
            'title' => 'Sample Pet Store App',
            /**
             * @required
             * The version of the OpenAPI document (which is distinct from the
             * OpenAPI Specification version or the API implementation version).
             */
            'version' => '1.0.0',
            /**
             * @optional
             * A short description of the API.
             */
            'description' => 'This is a sample server for a pet store.',
            /**
             * @optional
             * A URL to the Terms of Service for the API. MUST be in the format
             * of a URL.
             */
            'termsOfService' => 'http://petstore.com/terms/',
            /**
             * @optional
             * The contact information for the exposed API.
             */
            'contact' => [
                'url' => 'http://petstore.com/support',
                'name' => 'API Support',
                'email' => 'support@petstore.com',
            ],
        ],
    ]
];
