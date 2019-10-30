<?php

namespace Zilliqa\Backend\Console;

use Illuminate\Console\Command;
use Zilliqa\Backend\Models\Setting;

class UpdateETH extends Command {

    /**
     * @var string The console command name.
     */
    protected $name = 'zilliqa:updateeth';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle() {
        $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest';
        $parameters = [
            'symbol' => 'ETH',
            'convert' => 'USD'
        ];

        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: 356f5656-a581-4220-8f3d-4f6b411fbe02'
        ];
        $qs = http_build_query($parameters); // query string encode the parameters
        $request = "{$url}?{$qs}"; // create the request URL


        $curl = curl_init(); // Get cURL resource
        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request, // set the request URL
            CURLOPT_HTTPHEADER => $headers, // set the headers 
            CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response        
        $response = json_decode($response);
        if ($response && $response->data) {
            $data = $response->data->ETH;
            $quote = $data->quote->USD;
            $price = $quote->price;
            Setting::set('eth', round($price, 3));
        }
        curl_close($curl); // Close request
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
