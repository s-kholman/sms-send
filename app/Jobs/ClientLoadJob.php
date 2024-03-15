<?php

namespace App\Jobs;

use App\Actions\StoreClient;
use App\Actions\ValidateClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ClientLoadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $chunk;
    private $user_id;

    /**
     * Create a new job instance.
     */
    public function __construct(array $chunk, int $user_id)
    {
        $this->chunk = $chunk;
        $this->user_id= $user_id;
    }

    /**
     * Execute the job.
     */
    public function handle(ValidateClient $validateClient, StoreClient $storeClient): void
    {
        foreach ($this->chunk as $clients){

            $client = explode(',', $clients);

                if (count($client) >= 3){
                    $validate = $validateClient(
                        [
                            'phone' => $client[0],
                            'birth' => $client[2],
                            //'clientFullName' => iconv("OEM866", "UTF-8", $data[1])
                            'clientFullName' => $client[1]
                        ]);

                    if($validate <> false){
                        $storeClient($validate, $this->user_id);
                    }
                }
            }
            //fclose($file);

        }

}
