set :application, 'draft-crawl'
set :repo_url, 'git@github.com:daninoz/draft-crawl.git'

set :branch, 'master'

set :deploy_to, '/var/www/vhosts/draft.daninoz.com'
set :deploy_via, :remote_cache
set :scm, :git