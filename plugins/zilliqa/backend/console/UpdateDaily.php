<?php

namespace Zilliqa\Backend\Console;

use Illuminate\Console\Command;
use Zilliqa\Backend\Models\BonusDaily;
use RainLab\User\Models\User;

class UpdateDaily extends Command {

    /**
     * @var string The console command name.
     */
    protected $name = 'zilliqa:updatedaily';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle() {
        $list = BonusDaily::get();
        if ($list) {
            foreach ($list as $item) {
                $userID = $item->user_id;
                $bonusDaily = $item->daily;

                //Update Daily for User
                $user = User::find($userID);
                {
                    $user->daily = $user->daily + $bonusDaily;
                    $user->save();
                }
            }
        }
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments() {
        return [
        ];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions() {
        return [];
    }

}
