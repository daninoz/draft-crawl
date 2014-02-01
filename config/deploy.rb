set :application, 'draft-crawl'
set :repo_url, 'git@github.com:daninoz/draft-crawl.git'

set :branch, 'master'

set :linked_dirs, %w{app/config/production}

set :deploy_to, '/var/www/vhosts/draft.daninoz.com'
set :deploy_via, :remote_cache
set :scm, :git

namespace :deploy do

    desc 'artisan migrate'
    task :artisan_migrate do
        on roles(:web) do
            within release_path do
                execute 'php', 'artisan', 'migrate'
            end
        end
    end

    after :updated, 'deploy:artisan_migrate'

    desc 'artisan example'
    task :artisan_example do
        on roles(:web) do
            within release_path do
                execute 'php', 'artisan'
            end
        end
    end

    after :updated, 'deploy:artisan_example'

end