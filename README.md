## How to run PokéCards application

# Prerequisites

- Check composer is installed
- Check yarn & node are installed


# Install

- Clone this project
- Run composer install
- Run yarn install
- Run yarn encore dev to build assets
- Create a .env.local file (corresponding to the .env file) with your own database credentials
- Add you access to your favorite mailer on the .env.local (MAILER_DSN=smtp://xxxx)


# Working

- Run symfony server:start to launch your local php web server
- Run yarn run dev --watch to launch your local server for assets (or yarn dev-server do the same with Hot Module Reload
activated)
