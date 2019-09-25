<?php

namespace Zilliqa\Backend;

use Backend;
use System\Classes\PluginBase;
use BackendMenu;
use RainLab\User\Models\User as UserModel;
use RainLab\User\Controllers\Users as UserController;

/**
 * Backend Plugin Information File
 */
class Plugin extends PluginBase {

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails() {
        return [
            'name' => 'Backend',
            'description' => 'No description provided yet...',
            'author' => 'Zilliqa',
            'icon' => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register() {
        BackendMenu::registerContextSidenavPartial('Zilliqa.Backend', 'backend', '~/plugins/zilliqa/backend/partials/_sidenav.htm');
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot() {
        //Extend user Model
        UserModel::extend(function($model) {
            $model->hasMany['deposit'] = ['\Zilliqa\Backend\Models\HistoryDeposit', 'key' => 'user_id'];
            $model->hasMany['withdraw'] = ['\Zilliqa\Backend\Models\HistoryWithDraw', 'key' => 'user_id'];                        
        });
        
        //Extend Form Fields
        UserController::extendFormFields(function($form, $model, $context) {
            if (!$model instanceof UserModel)
                return;
            //Remove Another Fields
            $form->removeField('groups');

            if (!$model->exists)
                return;

            //Add tab fields
            $form->addTabFields([
                'deposit' => [
                    'label' => 'Information',
                    'type' => 'partial',
                    'path' => '$/rainlab/user/controllers/users/_deposit.htm',
                    'tab' => 'History Deposit'
                ],
                'withdraw' => [
                    'label' => 'Information',
                    'type' => 'partial',
                    'path' => '$/rainlab/user/controllers/users/_withdraw.htm',
                    'tab' => 'History WithDraw'
                ]
            ]);
            
        });
        
        UserModel::saving(function($model) {
            if (!$model->id) {                
                $model->user_code = $this->getRandomCode();
                $model->attributes['is_activated'] = true;                
            }
        });
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents() {
        return []; // Remove this line to activate

        return [
            'Zilliqa\Backend\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions() {
        return []; // Remove this line to activate

        return [
            'zilliqa.backend.some_permission' => [
                'tab' => 'Backend',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation() {
        return [
            'backend' => [
                'label' => 'Zilliqa',
                'url' => Backend::url('zilliqa/backend/lending'),
                'icon' => 'icon-btc',
                'permissions' => ['zilliqa.backend.*'],
                'order' => 500,
                'sideMenu' => [
                    'lending' => [
                        'label' => 'Lending Package',
                        'icon' => 'icon-sitemap',
                        'url' => Backend::url('zilliqa/backend/lending'),
                        'permissions' => ['zilliqa.backend.*'],
                        'group' => 'Zilliqa',
                    ],
                    'historydeposit' => [
                        'label' => 'History Deposit',
                        'icon' => 'icon-history',
                        'url' => Backend::url('zilliqa/backend/historydeposit'),
                        'permissions' => ['zilliqa.backend.*'],
                        'group' => 'History',
                    ],
                    'withdraw' => [
                        'label' => 'History WithDraw',
                        'icon' => 'icon-history',
                        'url' => Backend::url('zilliqa/backend/withdraw'),
                        'permissions' => ['zilliqa.backend.*'],
                        'group' => 'History',
                    ],
                    'presenter' => [
                        'label' => 'Commission',
                        'icon' => 'icon-users',
                        'url' => Backend::url('zilliqa/backend/presenter'),
                        'permissions' => ['zilliqa.backend.*'],
                        'group' => 'Commission',
                    ]
                ]
            ],
        ];
    }
    
    private function getRandomCode($length = 6) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
