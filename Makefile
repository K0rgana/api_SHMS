git-tamires:
	git config user.name "siilvatamires"
	git config user.email tamiresmariia27@gmail.com
git-morgana:
	git config user.name "K0rgana"
	git config user.email anagrom1999@gmail.com
git-juciele:
	git config user.name "jucielefernandes"
	git config user.email juciele.bol@gmail.com
conf:
	composer install --no-scripts
	cp .env.example .env # copia o example
	php artisan key:generate # gera a chave
	

