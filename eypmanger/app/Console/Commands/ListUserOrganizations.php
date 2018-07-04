<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Http\Controllers\UserController;
use GrahamCampbell\GitHub\Authenticators\AuthenticatorFactory;
use GrahamCampbell\GitHub\GitHubFactory;
use GitHub;
use Github\ResultPager;

class ListUserOrganizations extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'users:listorganizations {nickname}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'list user\'s organizations';

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
   * @return mixed
   */
  public function handle()
  {
    $nickname=$this->argument('nickname');

    $github=UserController::githubAPI($nickname);
    if($github)
    {
      foreach ($github->me()->memberships()->all() as $github_membership)
      {
        print($github_membership['organization']['login']."\n");
      }
    }
    else
    {
      print("ERROR: ".$nickname." is not a registered user\n");
    }
  }
}
