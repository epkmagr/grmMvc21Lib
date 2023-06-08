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

Starta lokalt
php -S localhost:8881 -t public &
Kolla vilka processer/jobb som är igång
jobs
kill %1 (om jobb 1 ska stoppas, %2 om jobb 2 ska stoppas)

Kolla router
bin/console debug:router
Rensa cachen
bin/console cache:clear
Kolla kommandon
bin/console

Composer
composer recipes (vad som är installerat)

Git och Github
mvc_vt23_report
Gör en gång bara:
git init && git symbolic-ref HEAD refs/heads/main
git remote add origin git@github.com:epkmagr/mvc_vt23_report.git
git branch -M main
git pull origin main --rebase (första gången)
git push -u origin main (första gången)
Glöm inte composer install om jag behöver ladda ner repot igen.

Gör vid varje push:
git status
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

phpDocumentor
tools/phpdoc/phpdoc --version (or help)
Generera doc:
tools/phpdoc/phpdoc -d ./src -t ./docs/api

Sqlite3
sqlite3 -header -column var/data.db
php bin/console dbal:run-sql 'SELECT * FROM book;'

Symfony migrera vid förändring i databasen, Sqlite3
php bin/console make:migration
php bin/console doctrine:migrations:migrate

PHPmetrics
composer phpmetrics

FIXA TILL VT24
1. Använd phpunit test istället för symfonys
2. Se till att göra tester på controllers
3. Ev fixa till koden så att värdena blir bättre