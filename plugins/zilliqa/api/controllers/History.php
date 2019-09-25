<?php namespace Zilliqa\API\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * History Back-end Controller
 */
class History extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Zilliqa.API', 'api', 'history');
    }
}
