<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@bitbucket.org:opensourcedesign/homeapp.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('10.0.0.20')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '~/home');

// Hooks

after('deploy:failed', 'deploy:unlock');
