<?php

namespace App\Packages\Logger\Traits;

trait Form 
{
    /**
     * @var $validationRules
     */
    private $validationRules = [
        'name' => 'required|unique:entity_methods|max:25',
        'endpoint' => 'required|unique:entity_methods|max:255',
    ];

    private $form = [
        'limit' => [
            'name' => 'limit',
            'options' => [
                '5' => 5,
                '10' => 10,
                '15' => 15
            ]
        ],
        'sortby' => [
            'name' => 'sortby',
            'options' => [
                'created_at'    => 'Дате создания',
                'avg_time_exec' => 'Среднему времени выполнения запроса',
                'max_time_exec' => 'Максимальному времени выполнения запроса',
                'min_time_exec' => 'Минимальному времени выполнения запроса'
            ]
        ],
        'sortdir' => [
            'name' => 'sortdir',
            'options' => [
                'desc' => 'Убывания',
                'asc' => 'Возрастания',
            ]
        ]
    ];
}