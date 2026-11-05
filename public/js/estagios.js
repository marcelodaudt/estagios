jQuery(function ($) {
    $(".cnpj").mask('00.000.000/0000-00');

    // Máscara monetária (R$) - mesma do cadastro de vagas
    $('.money').mask('#.##0,00', { reverse: true });

    // Data de início: somente a partir de hoje + N dias (sem datas retroativas)
    var $dataInicial = $('#data_inicial[data-min-dias]');
    if ($dataInicial.length && $dataInicial.hasClass('hasDatepicker')) {
        $dataInicial.datepicker('option', 'minDate', parseInt($dataInicial.data('min-dias'), 10));
    }

    // Mostra informações dos alunos abaixo do input
    $('#numero_usp').change(function(){
        var data = { codpes: $( "#numero_usp" ).val() };
        function success(response) {
            $( "#info" ).html(response).css('color', 'red');;
        }
        $.get('info', data, success);
    });
});

// Calcula o Total (Saída - Entrada - Tempo de Intervalo) da grade de horários por dia da semana
function paraMinutos(horaMinuto) {
    var partes = horaMinuto.split(':');
    return parseInt(partes[0], 10) * 60 + parseInt(partes[1], 10);
}

function calculaTotalHorario(dia) {
    var form = document.querySelector('input[name="horarios[' + dia + '][entrada]"]').form;
    var entrada = form.querySelector('input[name="horarios[' + dia + '][entrada]"]').value;
    var saida = form.querySelector('input[name="horarios[' + dia + '][saida]"]').value;
    var intervalo = form.querySelector('input[name="horarios[' + dia + '][intervalo]"]').value;
    var totalCampo = document.getElementById('total-' + dia);

    if (!entrada || !saida) {
        totalCampo.value = '';
        return;
    }

    var total = paraMinutos(saida) - paraMinutos(entrada);
    if (intervalo) {
        total -= paraMinutos(intervalo);
    }

    if (total <= 0) {
        totalCampo.value = 'Horário inválido';
        return;
    }

    var horas = Math.floor(total / 60);
    var minutos = total % 60;
    totalCampo.value = (horas < 10 ? '0' : '') + horas + ':' + (minutos < 10 ? '0' : '') + minutos;

    calculaTotalSemanal();
}

// Forma de preenchimento da carga horária escolhida: 'padrao', 'por_dia' ou null
function tipoHorarioSelecionado() {
    var marcado = document.querySelector('input[name="tipo_horario"]:checked');
    return marcado ? marcado.value : null;
}

// Mostra o bloco correspondente à forma de preenchimento escolhida
function alternaTipoHorario() {
    var tipo = tipoHorarioSelecionado();
    var padrao = document.getElementById('bloco-horario-padrao');
    var porDia = document.getElementById('bloco-horario-por-dia');
    if (padrao) {
        padrao.style.display = (tipo === 'padrao') ? '' : 'none';
    }
    if (porDia) {
        porDia.style.display = (tipo === 'por_dia') ? '' : 'none';
    }
    calculaTotalPadrao();
    calculaTotalSemanal();
}

// Total diário do horário padrão (mesmo horário de segunda a sexta)
var DIAS_HORARIO_PADRAO = 5;

function calculaTotalPadrao() {
    var totalCampo = document.getElementById('total-padrao');
    if (!totalCampo) {
        return;
    }
    var entrada = document.getElementById('horario_padrao_entrada').value;
    var saida = document.getElementById('horario_padrao_saida').value;
    var intervalo = document.getElementById('horario_padrao_intervalo').value;

    if (!entrada || !saida) {
        totalCampo.value = '';
    } else {
        var total = paraMinutos(saida) - paraMinutos(entrada);
        if (intervalo) {
            total -= paraMinutos(intervalo);
        }
        totalCampo.value = (total <= 0) ? 'Horário inválido' : formataMinutos(total);
    }
    calculaTotalSemanal();
}

function formataMinutos(total) {
    var horas = Math.floor(total / 60);
    var minutos = total % 60;
    return (horas < 10 ? '0' : '') + horas + ':' + (minutos < 10 ? '0' : '') + minutos;
}

// Atualiza a Carga Horária Semanal Total conforme a forma de preenchimento escolhida
function calculaTotalSemanal() {
    var totalSemanalCampo = document.getElementById('total-semanal');
    if (!totalSemanalCampo) {
        return;
    }

    var tipo = tipoHorarioSelecionado();
    if (tipo === null && document.querySelector('input[name="tipo_horario"]')) {
        totalSemanalCampo.value = '';
        return;
    }

    if (tipo === 'padrao') {
        var totalPadrao = document.getElementById('total-padrao').value;
        if (!totalPadrao) {
            totalSemanalCampo.value = '';
        } else if (totalPadrao === 'Horário inválido') {
            totalSemanalCampo.value = 'Verifique os horários acima';
        } else {
            totalSemanalCampo.value = formataMinutos(paraMinutos(totalPadrao) * DIAS_HORARIO_PADRAO);
        }
        return;
    }

    var totalGeral = 0;
    var algumInvalido = false;

    ['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado'].forEach(function (dia) {
        var campo = document.getElementById('total-' + dia);
        if (!campo || !campo.value) {
            return;
        }
        if (campo.value === 'Horário inválido') {
            algumInvalido = true;
            return;
        }
        totalGeral += paraMinutos(campo.value);
    });

    if (algumInvalido) {
        totalSemanalCampo.value = 'Verifique os horários acima';
        return;
    }

    if (totalGeral === 0) {
        totalSemanalCampo.value = '';
        return;
    }

    var horas = Math.floor(totalGeral / 60);
    var minutos = totalGeral % 60;
    totalSemanalCampo.value = (horas < 10 ? '0' : '') + horas + ':' + (minutos < 10 ? '0' : '') + minutos;
}

document.addEventListener('DOMContentLoaded', function () {
    ['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado'].forEach(function (dia) {
        if (document.querySelector('input[name="horarios[' + dia + '][entrada]"]')) {
            calculaTotalHorario(dia);
        }
    });
    calculaTotalPadrao();
    calculaTotalSemanal();
});

function checagemdeferimento(that) {
    if (that.value == "Deferido") {
        document.getElementById("deferimentoparcial").style.display = "none";
        var x = document.forms["form-group"]["condicaodeferimento"].value;
        if (x == "") {
          alert("Caso o estágio estágio seja parecialmente deferido, é necessário preencher se haverá ou não a redução de tempo.");
          return false;
        }
    }
    else if (that.value == "Indeferido"){
        document.getElementById("deferimentoparcial").style.display = "none";
        var x = document.forms["form-group"]["condicaodeferimento"].value;
        if (x == "") {
          alert("Caso o estágio estágio seja parecialmente deferido, é necessário preencher se haverá ou não a redução de tempo.");
          return false;
        }
    }
    else
    {
        document.getElementById("deferimentoparcial").style.display = "block";
    }
}
