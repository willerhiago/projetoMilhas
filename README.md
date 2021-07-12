Documentação Projeto Milhas

Inicialização do projeto
Deverá ser feita a configuração do ambiente para iniciar o projeto utilizando Laravel.
Instalar um servidor de aplicação. Nesse exemplo utilizou-se o xampp (https://www.apachefriends.org/pt_br/download.html).
Instalar o Laravel via docker ou via composer. Ambas instalações podem ser consultadas no site oficial do framework (https://laravel.com/docs/8.x).
Com o ambiente configurado,clone o projeto do github (https://github.com/willerhiago/projetoMilhas.git) na pasta htdocs do xampp. Abra o xampp e inicie o Apache.
Na raiz do projeto instale as dependências do framework

Utilização da API Local
Com o projeto instalado e configurado, é possível acessar os recursos da API acessando a raíz do projeto, através das seguintes rotas:
../flights: Retorna todos os voos
../flights/{tipo}/{nome}: Retorna os voos com o filtro correspondente
Ex: flights/cia/GOL
../groups: Retorna o agrupamento de voos
../groups/id/{chave}: Retorna o agrupamento de voos pela chave correspondente
../groups/cheapestPrice: Retorna o agrupamento de voo mais barato

Utilização da API Nuvem
A API também foi hospedada em nuvem através do heroku. Para acessar seus recursos acesse: https://projetomilhas.herokuapp.com/
Para mais informações sobre as rotas disponíveis acesse: https://www.getpostman.com/collections/e0168c07ee5450d82665
