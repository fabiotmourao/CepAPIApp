<!DOCTYPE html>
<html>

<head>
    <title>Consulta de CEP</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
    <div class="center-container">
        <h1>Consulta de CEP</h1>
        <form action="{{ route('consultar-cep') }}" method="post">
            @csrf
            <input type="text" name="ceps" id="ceps-input" placeholder="Digite o CEP">
            <button class="button-consultar" type="submit">Consultar</button>
        </form>

        <div class="errors">
            @if (isset($cepErrors) && count($cepErrors) > 0)
                <ul class="error-message">
                    @foreach ($cepErrors as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        @if (isset($results) && count($results) > 0)
            <table>
                <thead>
                    <tr>
                        <th>CEP</th>
                        <th>Logradouro</th>
                        <th>Bairro</th>
                        <th>Cidade</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($results as $cep)
                        <tr>
                            <td>{{ $cep['cep'] }}</td>
                            <td>{{ $cep['logradouro'] }}</td>
                            <td>{{ $cep['bairro'] }}</td>
                            <td>{{ $cep['localidade'] }}</td>
                            <td>{{ $cep['uf'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class=" button-container">
                <a href="{{ route('exportar',['ceps'=>  $cepsInput]) }}" value="{{}}" class="button-exportar" type="submit"
                    id="button-exportar">Exportar CSV</a>

                <a href="#" class="button-limpar" type="button" id="button-limpar"
                    onclick="limparTabela();">Limpar Dados</a>
            </div>
        @endif
    </div>

    <script>
        function limparTabela() {
            var tbody = document.querySelector('table tbody');
            tbody.innerHTML = `
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
            `;

            var errorsDiv = document.querySelector('.errors');
            if (errorsDiv) {
                errorsDiv.innerHTML = '';
            }

            var buttonExportar = document.getElementById('button-exportar');
            var buttonLimpar = document.getElementById('button-limpar');

            buttonLimpar.addEventListener("click", function(event) {
                event.preventDefault();
            })


            if (buttonExportar) {
                buttonExportar.style.display = 'none';
            }

            if (buttonLimpar) {
                buttonLimpar.style.display = 'none';
            }
        }
    </script>
</body>

</html>
