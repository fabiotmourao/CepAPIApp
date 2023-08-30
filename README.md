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













