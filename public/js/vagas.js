jQuery(function ($) {
    // Máscara monetária (R$) para o valor mensal da bolsa
    $('.money').mask('#.##0,00', { reverse: true });

    // Seleção de múltiplos cursos
    $('#curso').select2({
        theme: 'bootstrap4',
        placeholder: 'Selecione um ou mais cursos',
        language: 'pt-BR',
        width: '100%'
    });
});
