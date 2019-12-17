git-tamires:
	git config --global user.name "siilvatamires"
	git config --global user.email tamiresmariia27@gmail.com
git-morgana:
	git config --global user.name "K0rgana"
	git config --global user.email anagrom1999@gmail.com
git-juciele:
	git config --global user.name "jucielefernandes"
	git config --global user.email juciele.bol@gmail.com
conf:
	composer install --no-scripts
	cp .env.example .env # copia o example
	php artisan key:generate # gera a chave
	

