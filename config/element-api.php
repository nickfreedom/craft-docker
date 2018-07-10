<?php

use craft\elements\Entry;
use craft\helpers\UrlHelper;

return [
    'endpoints' => [
        'devices' => [
            'elementType' => Entry::class,
            'criteria' => ['section' => 'devices'],
            'transformer' => function(Entry $entry) {
                return [
                    'title' => $entry->title,
                    'detailUrl' => "/device/{$entry->id}",
                    'serialNumber' => $entry->getFieldValue('serialNumber'),
                    'key' => $entry->getFieldValue('key'),
                    'lastUpdate' => $entry->dateUpdated->format('Y-m-d H:i:s')
                ];
            },
        ],
        'devices/<entryId:\d+>' => function($entryId) {
            return [
                'elementType' => Entry::class,
                'criteria' => ['id' => $entryId],
                'one' => true,
                'transformer' => function(Entry $entry) {
                    return [
                        'title' => $entry->title,
                        'lastUpdate' => $entry->dateUpdated->format('Y-m-d H:i:s'),
                        'serialNumber' => $entry->getFieldValue('serialNumber'),
                        'key' => $entry->getFieldValue('key'),
                        'lastRecording' => $entry->getFieldValue('lastRecording')
                    ];
                },
            ];
        },

    ]
];
