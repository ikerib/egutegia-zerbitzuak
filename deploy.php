<?php
namespace Deployer;

require 'recipe/symfony3.php';

// Project name
set('application', 'egutegia-zerbitzuak');

// Project repository
set('repository', 'git@github.com:ikerib/egutegia-zerbitzuak.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', ['app/config/parameters.yml']);
add('shared_dirs', ['var/logs','var/cache','web/uploads']);

// Writable dirs by web server
add('writable_dirs', ['var','web/uploads']);
set('allow_anonymous_stats', false);

// Hosts

host('172.28.64.61')
    ->user( 'root')
    ->set('branch', 'main')
    ->set('deploy_path', '/var/www/egutegia');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.


//set('bin/yarn', function () {
//    return run('which yarn');
//});
//desc('Install Yarn packages');
//task('yarn:install', function () {
//    if (has('previous_release')) {
//        if (test('[ -d {{previous_release}}/node_modules ]')) {
//            run('cp -R {{previous_release}}/node_modules {{release_path}}');
//        }
//    }
//    run("cd {{release_path}} && {{bin/yarn}}");
//});

set('npm', function () {
    return run('which npm');
});
desc('Install npm packages');
task('npm:install', function () {
    if (has('previous_release')) {
        if (test('[ -d {{previous_release}}/node_modules ]')) {
            run('cp -R {{previous_release}}/node_modules {{release_path}}');
        }
    }
    run("cd {{release_path}} && /usr/bin/npm install");
});

desc('Build my assets');
task('gulp:prod', function () {
    run("cd {{release_path}} && gulp prod");
});

after( 'deploy:symlink', 'npm:install' );
after( 'npm:install', 'gulp:prod' );
