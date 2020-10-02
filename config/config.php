<?php

return [
    /**
     * The output directory where your YAML document will be created.
     */
    'outputpath' => resource_path('openapi.yml'),

    /**
     * Wildcards allow you to document a specific group of routes without having
     * to expose everything to your YAML file.
     */
    'wildcards' => [
        '/^\/?api\/*/'
    ],

    /**
     * The base skeleton with the default OpenAPI specification that will include
     * your final document, do not refrain from adding more attributes or removing
     * optional attributes that you do not consider important.
     *
     * @see https://swagger.io/specification/#schema
     */
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
                'description' => 'Production server'
            ],
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
            'title' => 'My awesome petstore api',
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
