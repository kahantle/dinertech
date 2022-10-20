<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MenuItem;

class stockUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update stocks of items';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $categoryList = MenuItem::all();
        foreach ($categoryList as $key => $category) {

            if ($category['out_of_stock_type'] == "Custom Date" && $category['end_date'] < date("y-m-d")) {
                $category->end_date = NULL;
                $category->start_date = NULL;
                $category->out_of_stock_type = 1;
                $category->save();
            }

        }

        $this->info('stocks update successfully !');
    }
}
