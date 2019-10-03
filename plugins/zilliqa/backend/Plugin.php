<?php

namespace Zilliqa\Backend;

use Backend;
use System\Classes\PluginBase;
use BackendMenu;
use Event;
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
        $this->app->singleton('zilliqa:updatedaily', function() {
            return new \Zilliqa\Backend\Console\UpdateDaily;
        });

        $this->commands('zilliqa:updatedaily');
        
        $this->app->singleton('zilliqa:updatezil', function() {
            return new \Zilliqa\Backend\Console\UpdateZil;
        });

        $this->commands('zilliqa:updatezil');
        
        //Extend user Model
        UserModel::extend(function($model) {
            $model->hasMany['deposit'] = ['\Zilliqa\Backend\Models\HistoryDeposit', 'key' => 'user_id'];
            $model->hasMany['withdraw'] = ['\Zilliqa\Backend\Models\HistoryWithDraw', 'key' => 'user_id'];
            $model->belongsTo['country'] = ['\Zilliqa\Backend\Models\Country', 'key' => 'country_id'];
        });

        //Extend Form Fields
        UserController::extendFormFields(function($form, $model, $context) {
            if (!$model instanceof UserModel)
                return;
            //Remove Another Fields
            $form->removeField('groups');

            if (!$model->exists)
                return;


            $form->addTabFields([
                'user_code' => [
                    'label' => 'User Code',
                    'type' => 'text',
                    'tab' => 'rainlab.user::lang.user.account',
                    'span' => 'auto',
                    'readOnly' => true
                ],
                'is_block' => [
                    'label' => 'Block user',
                    'type' => 'switch',
                    'tab' => 'rainlab.user::lang.user.account',
                    'span' => 'auto',
                ],
                'country_id' => [
                    'label' => 'Country',
                    'type' => 'dropdown',
                    'tab' => 'rainlab.user::lang.user.account',
                    'span' => 'auto',
                ],
            ]);

            $form->addTabFields([
                'zil_address' => [
                    'label' => 'Zil Address',
                    'type' => 'text',
                    'tab' => 'Zilliqa',
                    'span' => 'auto',
                ],
                'eth_address' => [
                    'label' => 'Eth Address',
                    'type' => 'text',
                    'tab' => 'Zilliqa',
                    'span' => 'auto',
                ],
                'daily' => [
                    'label' => 'Daily',
                    'type' => 'text',
                    'tab' => 'Zilliqa',
                    'span' => 'auto',
                ],
                'commission' => [
                    'label' => 'Commission',
                    'type' => 'text',
                    'tab' => 'Zilliqa',
                    'span' => 'auto',
                ],
                'lending' => [
                    'label' => 'Lending',
                    'type' => 'text',
                    'tab' => 'Zilliqa',
                    'span' => 'auto',
                ],
                'zilliqa' => [
                    'label' => 'Zilliqa',
                    'type' => 'text',
                    'tab' => 'Zilliqa',
                    'span' => 'auto',
                ],
                'downline_member' => [
                    'label' => 'Downline Member',
                    'type' => 'text',
                    'tab' => 'Zilliqa',
                    'span' => 'auto',
                ]
            ]);

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

        Event::listen('backend.list.extendColumns', function($widget) {

            // Only for the User controller
            if (!$widget->getController() instanceof \RainLab\User\Controllers\Users) {
                return;
            }

            // Only for the User model
            if (!$widget->model instanceof \RainLab\User\Models\User) {
                return;
            }

            // Add an extra birthday column
            $widget->addColumns([
                'user_code' => [
                    'label' => 'User Code'
                ],
                'zil_address' => [
                    'label' => 'ZIL Address'
                ],
                'eth_address' => [
                    'label' => 'ETH Address'
                ],
                'daily' => [
                    'label' => 'Daily'
                ],
                'commission' => [
                    'label' => 'Commission'
                ],
                'lending' => [
                    'label' => 'Lending'
                ],
                'zilliqa' => [
                    'label' => 'Zilliqa'
                ]
            ]);

            // Remove a Surname column
            $widget->removeColumn('surname');
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
                    'country' => [
                        'label' => 'Country',
                        'icon' => 'icon-sitemap',
                        'url' => Backend::url('zilliqa/backend/country'),
                        'permissions' => ['zilliqa.backend.*'],
                        'group' => 'Zilliqa',
                    ],
                    'bonusdaily' => [
                        'label' => 'Bonus Daily',
                        'icon' => 'icon-money',
                        'url' => Backend::url('zilliqa/backend/bonusdaily'),
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

    public function registerSettings() {
        return [
            'settings' => [
                'label' => 'Settings Zilliqa',
                'description' => 'Settings Zilliqa',
                'category' => 'Zilliqa',
                'icon' => 'icon-cogs',
                'class' => 'Zilliqa\Backend\Models\Setting',
                'order' => 500,
                'permissions' => ['*']
            ]
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

    public function registerSchedule($schedule)
    {
        $schedule->command('zilliqa:updatedaily')->dailyAt('01:00');
        $schedule->command('zilliqa:updatezil')->dailyAt('01:00');
    }
}
