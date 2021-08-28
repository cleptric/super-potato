<?php

return [
    /**
     * The name of your organization, like VACC Austria
     */
    'name' => null,
    /**
     * The link to the website of your org
     */
    'website' => null,
    /**
     * The link to your imprint
     */
    'imprint_link' => null,
    /**
     * The link to your privacy policy
     */
    'privacy_policy' => null,
    /**
     * TBD
     */
    'auth_callback' => function () {
        /**
         * TBD 
         */
        return true;
    },
    /**
     * TBD
     */
    'airports' => [
        [
            /**
             * Name of the airport
             */
            'name' => 'Wien Schwechat',
            /**
             * ICAO of the airport
             */
            'icao' => 'LOWW',
            /**
             * undocumented 
             */
            'controller_prefix' => [],
            /**
             * ATIS callsing, as in the VATSIM data feed - https://data.vatsim.net/v3/vatsim-data.json
             */
            'atis_callsign' => 'LOWW_ATIS',
            /**
             * TBD 
             */
            'atis_regex' => [
                'atis_letter' => '/(?<=INFORMATION )[A-Z](?= )/s',
                'depature_runway' => '/(?<=DEPARTURE RUNWAY )(\d\d AND \d\d|\d\d)(?= )/s',
                'arrival_runway' => '/(?<=ARRIVAL RUNWAY )(\d\d)(?= )|(?<=LANDING RUNWAY )(\d\d AND \d\d)(?= )/s',
                'transition_level' => '/(?<=TRANSITION LEVEL )(\d\d|\d\d\d)(?= )/s',
                'time' => '/(?<=AT TIME )\d\d\d\d(?= )/s',
            ],
            'runways_closed' => true,
            'trigger_missed_approaches' => true,
            'runways' => [
                '11/29' => [
                    '11' => [
                        /**
                         * The true heading of the runway.
                         */
                        'true_heading' => 115,
                        /**
                         * undocumented 
                         */
                        'designator' => '11'
                    ],
                    '29' => [
                        
                    ],
                ],
            ],
            'atis'
        ]
    ],
];