<?php namespace Brackets\AdminGenerator;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class GenerateProfile extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'admin:generate:user:profile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold admin "My Profile" feature (controller, views, routes)';

    /**
     * Create a new controller creator command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $tableNameArgument = 'users';
        $modelOption = $this->option('model-name');
        $controllerOption = !empty($this->option('controller-name')) ? $this->option('controller-name') : 'ProfileController';
        $force = $this->option('force');

        if($force) {
            //remove all files
            $this->files->delete(app_path('Http/Controllers/Admin/ProfileController.php'));
            $this->files->deleteDirectory(resource_path('assets/js/admin/profile-edit-profile'));
            $this->files->deleteDirectory(resource_path('assets/js/admin/profile-edit-password'));
            $this->files->deleteDirectory(resource_path('views/admin/profile'));
        }

        $this->call('admin:generate:controller', [
            'table_name' => $tableNameArgument,
            'class_name' => $controllerOption,
            '--model-name' => $modelOption,
            '--template' => 'profile',
        ]);

        $this->call('admin:generate:routes', [
            'table_name' => $tableNameArgument,
            '--model-name' => $modelOption,
            '--controller-name' => $controllerOption,
            '--template' => 'profile',
        ]);
        // TODO add this route to the dropdown user-menu

        $this->call('admin:generate:full-form', [
            'table_name' => $tableNameArgument,
            '--model-name' => $modelOption,
            '--file-name' => 'profile/edit-profile',
            '--route' => 'admin/profile/update',
            '--template' => 'profile',
        ]);

        $this->call('admin:generate:full-form', [
            'table_name' => $tableNameArgument,
            '--model-name' => $modelOption,
            '--file-name' => 'profile/edit-password',
            '--route' => 'admin/password/update',
            '--template' => 'profile.password',
        ]);

        $this->info('Generating whole admin "My Profile" finished');

    }

    protected function getArguments() {
        return [
        ];
    }

    protected function getOptions() {
        return [
            ['model-name', 'm', InputOption::VALUE_OPTIONAL, 'Specify custom model name'],
            ['controller-name', 'c', InputOption::VALUE_OPTIONAL, 'Specify custom controller name'],
            ['force', 'f', InputOption::VALUE_NONE, 'Force will delete files before regenerating admin profile'],
        ];
    }

}