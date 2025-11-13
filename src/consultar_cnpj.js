document.addEventListener('DOMContentLoaded', function () {
  const inputCnpj = document.getElementById('empresa_cnpj');
  const spanStatus = document.querySelector('#mensagem_enviar');

  // Adiciona a máscara ao campo de CNPJ
  inputCnpj.addEventListener('input', function () {
    let cnpj = inputCnpj.value.replace(/\D/g, '');
    cnpj = cnpj.replace(/^(\d{2})(\d)/, '$1.$2');
    cnpj = cnpj.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
    cnpj = cnpj.replace(/\.(\d{3})(\d)/, '.$1/$2');
    cnpj = cnpj.replace(/(\d{4})(\d)/, '$1-$2');
    inputCnpj.value = cnpj.substring(0, 18);
  });

  inputCnpj.addEventListener('blur', function () {
    const cnpjLimpo = inputCnpj.value.replace(/\D/g, '');
    if (cnpjLimpo.length === 14) {
      consultarCNPJ(cnpjLimpo);
    } else {
      spanStatus.textContent = 'CNPJ inválido.';
      spanStatus.style.color = 'red';
    }
  });

  async function consultarCNPJ(cnpj) {
    spanStatus.textContent = 'Buscando...';
    spanStatus.style.color = 'blue';

    try {
      const response = await fetch(`consultar_cnpj.php?cnpj=${cnpj}`);
      if (!response.ok) {
        throw new Error('Falha na busca. CNPJ não encontrado.');
      }
      const dados = await response.json();

      if (dados.erro) {
        throw new Error(dados.erro);
      }
      console.log(dados);

      preencherFormulario(dados);
      spanStatus.textContent = 'Dados carregados!';
      spanStatus.style.color = 'green';
    } catch (error) {
      console.error('Erro na consulta:', error);
      spanStatus.textContent = error.message;
      spanStatus.style.color = 'red';
    }
  }

  function preencherFormulario(dados) {
    document.getElementById('empresa_nome').value =
      dados.estabelecimento.nome_fantasia || dados.razao_social;
    document.getElementById('empresa_endereco').value =
      `${dados.estabelecimento.logradouro}, ${dados.estabelecimento.numero}, ${dados.estabelecimento.complemento}, ${dados.estabelecimento.bairro}, ${dados.estabelecimento.cidade.nome}/${dados.estabelecimento.estado.sigla}, CEP ${dados.estabelecimento.cep}` ||
      '';
    document.getElementById('empresa_descricao').value =
      dados.estabelecimento.atividade_principal.descricao || '';
  }
});
