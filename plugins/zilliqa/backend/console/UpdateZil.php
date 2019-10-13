<?php

namespace Zilliqa\Backend\Console;

use Illuminate\Console\Command;
use Zilliqa\Backend\Models\UserLending;
use Zilliqa\Backend\Models\Lending;
use RainLab\User\Models\User;
use DB;

class UpdateZil extends Command {

    /**
     * @var string The console command name.
     */
    protected $name = 'zilliqa:updatezil';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle() {
        $list = UserLending::where('is_update_bonus', 0)->get();
        $now = date_create(date('Y-m-d H:i:s'));
        if ($list) {
            foreach ($list as $item) {
                $userID = $item->user_id;
                $lendingID = $item->lending_id;
                $createdDate = date_create($item->created_at);
                $dateDiff = date_diff($createdDate, $now);
                $date = $dateDiff->format("%a");
                if($date >= 200){
                    //Get Lending
                    $lending = Lending::where('id', $lendingID)->first();
                    if ($lending) {
                        $bonusZil = $lending->bonus_zil;
                        $bonusZil = $lending->bonus_zil - ($lending->bonus_zil / 10);
                    }

                    //Update Daily for User
                    $user = User::find($userID);
                    if($user)
                    {
                        $totalZilliqa = $user->zilliqa_minimum + $bonusZil;
                        DB::table('users')->where('id',$userID)->update(['zilliqa_minimum' => $totalZilliqa]);
                        DB::table('zilliqa_backend_user_lending')
                            ->where('id', $item->id)
                            ->update(['is_update_bonus' => 1]);
                    }

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
