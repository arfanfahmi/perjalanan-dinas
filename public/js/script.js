
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});

$(`input[type=radio][name="ln"]`).change(function() {
    if (this.value == 'Y') {
        $("#provinsi").val('1000').change();
        $("#provinsi").attr("disabled","disabled");
        $("#pulau").attr("disabled","disabled");
        $("#pulau").prop("selectedIndex", 0).change();
    }
    else if (this.value == 'N') {
        $("#provinsi").prop("selectedIndex", 0).change();
        $("#provinsi").removeAttr("disabled");
        $("#pulau").removeAttr("disabled");
        $("#pulau").prop("selectedIndex", 0).change();
    }
});