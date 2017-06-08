function IsNumeric(sText)
{
    var ValidChars = "0123456789.";
    var IsNumber = true;
    var Char;
    for (i = 0; i < sText.length && IsNumber == true; i++)
    {
        Char = sText.charAt(i);
        if (ValidChars.indexOf(Char)==-1)
        {
            IsNumber = false;
        }
    }
    return IsNumber;
};
function calcProdSubTotal() {
    var prodSubTotal = 0;
    $(".row-total-input").each(function() {
        var valString = $(this).val() || 0;
        prodSubTotal += parseFloat(valString);
    });
    $("#product-subtotal").val(parseFloat(prodSubTotal).toFixed(2));
};
function calcTotalPallets() {
    var totalPallets = 0;
    $(".num-pallets-input").each(function() {
        var thisValue = $(this).val();
        if ((IsNumeric(thisValue)) && (thisValue != '')) {
            totalPallets += parseFloat(thisValue);
        };
    });
    $("#total-pallets-input").val(parseFloat(totalPallets).toFixed(2));
};
function calcShippingTotal() {
    var totalPallets = $("#total-pallets-input").val() || 0;
    var shippingRate = $("#shipping-rate").text() || 0;
    var shippingTotal = totalPallets * shippingRate;
    $("#shipping-subtotal").val(parseFloat(shippingTotal).toFixed(2));
};
function calcOrderTotal() {
    var orderTotal = 0;
    var productSubtotal = $("#product-subtotal").val() || 0;
    var shippingSubtotal = $("#shipping-subtotal").val() || 0;
    var orderTotal = parseFloat(productSubtotal) + parseFloat(shippingSubtotal);
    var orderTotalNice = orderTotal;
    $("#order-total").val(parseFloat(orderTotalNice).toFixed(2));
};
$(function() {
    $('.num-pallets-input').blur(function() {
        var $this = $(this);
        var numPallets = $this.val();
        //var multiplier = $this.parent().parent().find("td.price-per-pallet span").text();
		var multiplier = $this.parent().parent().find("td.price-per-pallet input").val();
        if ((IsNumeric(numPallets)) && (numPallets != '')) {
            var rowTotal = numPallets * multiplier;
            $this.css("background-color", "white").parent().parent().find("td.row-total input").val(parseFloat(rowTotal).toFixed(2));
        } else {
            $this.css("background-color", "#ffdcdc");
        };
        calcProdSubTotal();
        calcTotalPallets();
        calcShippingTotal();
        calcOrderTotal();
    });
	$('.row-total-input').blur(function() {
        var $this = $(this);
        var numPallets = $this.val();
		var trid = $(this).parent().parent().attr("id");
		var trsl = $("#amount"+trid).val();
		$("#cbjia"+trid).val(parseFloat(numPallets/trsl).toFixed(2));
        if ((IsNumeric(numPallets)) && (numPallets != '')) {
            var rowTotal = numPallets;
            $this.css("background-color", "white").parent().parent().find("td.row-total input").val(parseFloat(rowTotal).toFixed(2));
        } else {
            $this.css("background-color", "#ffdcdc");
        };
        calcProdSubTotal();
        calcShippingTotal();
        calcOrderTotal();
    });
});