function calculateCost() {
    // cost variables definition
    var single = 15000;
    var spouse = 10000;
    var child = 5000;
    var spouseVal = $('#maridgeStatus option:selected').val();
    if (spouseVal == 'وضعیت تاهل') {
        return 0;
    }
    var hasSpouse = (spouseVal == 'married');
    var childNumber = parseInt($('#childNumber').val()) || 0;
    var spouseToo = $('#spouseToo').prop('checked');
    var cost = (single + hasSpouse * spouse + childNumber * child) * (1 + 0.5 * spouseToo);
    $('#regFee').html('        <strong>' + String(cost) + '</strong>' + '  تومان');

}