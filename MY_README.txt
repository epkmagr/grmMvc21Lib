Kmom01

Stå i me-katalogen
composer create-project symfony/website-skeleton report

Gå till report
Kopiera dit docker-compose.yaml från example/symfony

Kör (i report)
docker-compose run php81 composer require webapp

Kopiera .htaccess från example/symfony och lägg den under report/public
Kör dbwebb publishpure me

Kör
docker-compose run php81 composer require annotations
docker-compose run php81 composer require twig

Kör i docker
docker-compose up php81-apache
Kolla läget
docker-compose run php81 bin/console debug:router

Start lokalt
php -S localhost:8888 -t public &
Kolla router
bin/console debug:routes
