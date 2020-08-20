<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
class createDefaultAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is to create KK Brokers Administrator';

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
        Role::create(['name' => 'Administrator']);

        //CREATING DEFAULT ADMIN INTO THE SYSTEM
        $user =  User::create([
            'name' => ucfirst('admin'),
            'mobileno' => '700000000',
            'email' => 'admin@kk.com',
            'password' => Hash::make('password'),
            'account_activated' => 1,
        ]);

        if($user) {
            $user->assignRole('Administrator');
            $this->info('Successfully Created A Default System Administrator');
            $subject = 'Creating Default Administrator';
            $details = 'Default Administrator created successfully';
            \LogActivity::addToLog($subject,$details, $user->id);
        }
    }
}
