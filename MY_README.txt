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
docker-compose up -d php81-apache
Kolla läget
docker-compose run php81 bin/console debug:router

Start lokalt
php -S localhost:8888 -t public &
Kolla router
bin/console debug:router
composer recipes (vad som är installerat)

Git och Github
mvc-report
git add .
git commit -a -m "meddelande"
git push
git tag -a 1.0.0 -m "First draft"
git tag
git push --tags

Installera markdown
composer require twig/markdown-extra league/commonmark
docker-compose run php81 composer require twig/markdown-extra league/commonmark

phph statisk kodvalidering
composer require php-cs-fixer

Testning - phpunit
composer require --dev symfony/test-pack
mkdir tests/Card
php bin/phpunit
php bin/phpunit tests/Card
