set :stage, :staging

role :web, %w{deploy@69.195.223.207}
role :app, %w{deploy@69.195.223.207}

set :ssh_options, {
    forward_agent: true
}