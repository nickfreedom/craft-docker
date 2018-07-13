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
                    $signalTypesAndUnits = [];

                    foreach ($entry->getFieldValue('signalTypesAndUnits')->all() as $block) {
                         $signalTypesAndUnits[$block->targetSignal] = [
                             'type' => $block->type->handle,
                             'baseUnit' => $block->baseUnit,
                             'convertTo' => $block->convertTo    
                         ];
                    }

                    $signalTransforms = [];

                    foreach ($entry->getFieldValue('signalTransforms')->all() as $block) {
                        $targetSignal = $block->targetSignal;
                        
                        if (empty($signalTransforms[$targetSignal])) {
                            $signalTransforms[$targetSignal] = [];
                        }

                        $signalTransform = [
                            'type' => $block->type->handle,
                        ];

                        switch ($block->type->handle) {
                            case 'round':
                                $signalTransform['precision'] = $block->precision;
                                break;
                        }

                        $signalTransforms[$targetSignal][] = $signalTransform;
                    }

                    return [
                        'title' => $entry->title,
                        'lastUpdate' => $entry->dateUpdated->format('Y-m-d H:i:s'),
                        'serialNumber' => $entry->getFieldValue('serialNumber'),
                        'key' => $entry->getFieldValue('key'),
                        'lastRecording' => $entry->getFieldValue('lastRecording'),
                        'allowRemoteControl' => $entry->getFieldValue('allowRemoteControl'),
                        'signalTypesAndUnits' => $signalTypesAndUnits,
                        'signalTransforms' => $signalTransforms
                    ];
                },
            ];
        },

    ]
];
