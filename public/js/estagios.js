jQuery(function ($) {
    $(".cnpj").mask('00.000.000/0000-00');

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

// Soma o Total de cada dia da semana e atualiza a Carga Horária Semanal Total
function calculaTotalSemanal() {
    var totalSemanalCampo = document.getElementById('total-semanal');
    if (!totalSemanalCampo) {
        return;
    }

    var totalGeral = 0;
    var algumInvalido = false;

    ['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'domingo'].forEach(function (dia) {
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
    ['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'domingo'].forEach(function (dia) {
        if (document.querySelector('input[name="horarios[' + dia + '][entrada]"]')) {
            calculaTotalHorario(dia);
        }
    });
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
