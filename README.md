# Pré-requisitos
Antes de começar, certifique-se de ter o seguinte instalado

PHP (7.4 ou superior)
Composer
Laravel

# Instalação

## Clone o repositório
git clone https://github.com/your-username/github-user-info.git
cd github-user-info

## Instale dependências usando o Composer
composer install

## Renomeie .env.example .env insira linha com o URL da API do GitHub
dotenv
API_CEP_URL_BASE=https://viacep.com.br/ws

## Gere uma chave de aplicativo
php artisan key:generate

## Inicie o servidor de desenvolvimento
php artisan serve


## Uso
Ao acessar a página, o usuário tem a opção de consultar um ou mais CEPs em um único clique. 
Isso é possível ao permitir que o usuário insira vários CEPs separados por vírgula.
Quando o usuário clica em um botão "Consultar",A API retorna os detalhes do endereço associado ao(s) CEP(s) consultado(s).
As informações retornadas pela API (como logradouro, bairro, cidade, estado etc.) exibida na página. A cada consulta, uma nova linha é adicionada à tabela com os detalhes do endereço correspondente.
Para oferecer uma maneira de limpar o conteúdo da tabela e recomeçar, um botão "Limpar Tabela" está presente. 
Ao clicar neste botão, remove todas as linhas da tabela, reiniciando o processo para uma nova consulta.
Para permitir a exportação dos registros de CEPs consultados, um botão "Exportar CSV" está presente na página.
Quando o usuário clica nesse botão, recolhe os dados da tabela e os formata em formato CSV. 
Um arquivo CSV é gerado dinamicamente, contendo todas as informações dos endereços consultados.
Esse arquivo pode ser oferecido para download.


## Sobre o codigo!

Sobre as rotas usei web.php 

Para retorna a view cep.blade.php uso a rota GET (/) que acessa a CepController direcionata para a função index() que tenho acesso a página principal.

A segunda rota ('/consultar-cep') é uma rota POST que lida com a consulta dos CEPs. Ela chama o método consultar do CepController onde recebo atravez do request, os dados da  view cep.blade.php
faço os devidos tratamentos e validações nessa variavel que foi recebida ess array de dados.
E esses dado passa para dentro de um metodo privado para buscar o cep que contém uma URL quem vem do dotenv e retornada para a o metodo consultar() e assim exbir a pesquisa novamente na tela caso nao tenha nenhum erro, se houver a tela recebe uma mensagem sobre o o tipo de erro.

A terceira rota ('/exportar/arquivo/{ceps?}') é uma rota GET que chama o método exportar() do CepController onde recebe um parametro {ceps?}
esses dados vem do input onde e feito mais um tratamento e reservado esses dados.

A variável $csvFileName contém um UUID gerado para garantir um nome único para o arquivo CSV.
O caminho completo do arquivo é construído usando storage_path('app/' . $csvFileName), onde storage_path fornece o diretório de armazenamento da aplicação.

fopen($csvFilePath, 'a+') abre o arquivo CSV no modo de escrita ('a+').
Isso permite adicionar dados ao arquivo existente ou criar um novo se o arquivo não existir.

fputcsv($csvFile, ['CEP', 'Logradouro', 'Bairro', 'Cidade', 'Estado']) escreve a linha de cabeçalho no arquivo CSV. Essa linha define as colunas do arquivo.

O foreach itera sobre o array de CEPs ($cepsArray) que reservei anteriormente.
Para cada CEP, é feita uma chamada à função getUrlData($cep) para obter os dados relacionados ao CEP por meio da API.
Os dados da resposta JSON da API são decodificados usando o  json_decode e armazenados no array $data

fputcsv($csvFile, $data) escreve a linha de dados no arquivo CSV.
A função fputcsv formata os dados para serem compatíveis com CSV, incluindo tratamento de aspas e separadores.

fclose($csvFile) fecha o arquivo CSV após a conclusão da escrita.

assim eu retorno o arquivo $csvFilePath onde cria uma resposta HTTP que permite o download do arquivo CSV.
A opção deleteFileAfterSend(true) indica que o arquivo será excluído após o download.






















