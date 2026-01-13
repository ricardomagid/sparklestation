<?php
// Order: Credits, Tracks of Destiny, Advanced Trace, Path Maths, Enemy Math

return [
    'base_costs' => [
        'trace0' => [
            'credits' => 2000,
            'enemy' => [2 => [2, 2]], // 2-star enemy material: [4 star char quantity, 5 star char quantity]
        ],
        'trace1' => [
            'credits' => 4000,
            'advanced_trace' => 1,
            'path' => [2 => [2, 3]],
        ],
        'trace2' => [
            'credits' => 4000,
            'path' => [2 => [2, 3]],
            'enemy' => [2 => [4, 6]],
        ],
        'trace3' => [
            'credits' => 8000,
            'path' => [3 => [2, 3]],
            'enemy' => [3 => [2, 3]],
        ],
        'trace4' => [
            'credits' => 8000,
            'path' => [3 => [2, 3]],
            'enemy' => [3 => [2, 3]],
        ],
        'trace5' => [
            'credits' => 16000,
            'tracks_of_destiny' => 1,
            'advanced_trace' => 1,
            'path' => [3 => [4, 5]],
        ],
        'trace6' => [
            'credits' => 16000,
            'path' => [3 => [4, 5]],
            'enemy' => [3 => [3, 4]],
        ],
        'trace7' => [
            'credits' => 36000,
            'path' => [4 => [2, 3]],
            'enemy' => [4 => [2, 3]],
        ],
        'trace8' => [
            'credits' => 36000,
            'path' => [4 => [2, 3]],
            'enemy' => [4 => [2, 3]],
        ],
        'trace9' => [
            'credits' => 128000,
            'tracks_of_destiny' => 1,
            'advanced_trace' => 1,
            'path' => [4 => [6, 8]],
        ],
        'trace10' => [
            'credits' => 128000,
            'path' => [4 => [6, 8]],
            'enemy' => [4 => [6, 8]],
        ],
        'trace11' => [
            'credits' => 128000,
            'path' => [4 => [6, 8]],
            'enemy' => [4 => [6, 8]],
        ],
        'trace12' => [
            'credits' => 128000,
            'path' => [4 => [6, 8]],
            'enemy' => [4 => [6, 8]],
        ],
    ],
    'ability_upgrade_costs' => [
        // Upgrade costs: array key = target level
        'ability2' => [
            'credits' => 2000,
            'enemy' => [
                2 => [2, 3]
            ]
        ],
        'ability3' => [
            'credits' => 4000,
            'path' => [
                2 => [2, 3]
            ],
            'enemy' => [
                2 => [4, 6]
            ]
        ],
        'ability4' => [
            'credits' => 8000,
            'path' => [
                3 => [2, 3]
            ],
            'enemy' => [
                3 => [2, 3]
            ]
        ],
        'ability5' => [
            'credits' => 16000,
            'path' => [
                3 => [4, 5]
            ],
            'enemy' => [
                3 => [3, 4]
            ]
        ],
        'ability6' => [
            'credits' => 24000,
            'path' => [
                3 => [6, 7]
            ],
            'enemy' => [
                3 => [5, 6]
            ]
        ],
        'ability7' => [
            'credits' => 36000,
            'path' => [
                4 => [2, 3]
            ],
            'enemy' => [
                4 => [2, 3]
            ]
        ],
        'ability8' => [
            'credits' => 64000,
            'advanced_trace' => 1,
            'path' => [
                4 => [4, 5]
            ],
            'enemy' => [
                4 => [3, 4]
            ]
        ],
        'ability9' => [
            'credits' => 128000,
            'advanced_trace' => 1,
            'path' => [
                4 => [6, 8]
            ]
        ],
        'ability10' => [
            'credits' => 240000,
            'tracks_of_destiny' => 1,
            'advanced_trace' => 1,
            'path' => [
                4 => [11, 14]
            ]
        ],
        // Basic attack: level N upgrade uses cost[N+1], except final upgrade
        'basic_max' => [
            'credits' => 128000,
            'path' => [
                4 => [6, 8]
            ],
            'enemy' => [
                4 => [3, 4]
            ]
        ]
    ],

    
    'creditMultiplier' => [
        0 => 1.0,
        1 => 1.25
    ]
];