<?php
return [
    #Begin NewsAPI Keys
    'newsapi' => [
        'token' => env("NEWS_API_TOKEN", "2ddcdffa5b5644dc8358e92812caa5fc")
    ],
    #End NewsAPI Keys
    
    #Begin GuardianNewsAPI Keys
    'guardiannews' => [
        'token' => env("GUARDIAN_NEWS_TOKEN", "a9666688-6347-4e79-aa86-d6448f193010"),
        'url' => env("GUARDIAN_NEWS_URL", "https://content.guardianapis.com")
    ]
    #End GuardianNewsAPI Keys
    
];
