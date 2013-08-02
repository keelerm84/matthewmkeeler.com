# Matthew M. Keeler Personal Homepage
This is the personal website of Matthew M. Keeler.  Built on top of Silex, it's a simple site to showcase some information about me.

## Setup
To work locally on the site, you can fire up Vagrant, and it should take care of everything.  Just follow the below steps.

    git clone git://github.com/keelerm84/matthewmkeeler.com
    cd matthewmkeeler.com
    git submodule init
    git submodule update
    composer update
    vagrant up

Once the VM is up, run the database migrations and populate the tables with the skill data

    php -f app/console knp:migration:migrate
    php -f app/console mojo:skills
