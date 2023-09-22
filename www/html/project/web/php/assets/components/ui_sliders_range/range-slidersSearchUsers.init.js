rangeSliders = null;
$( function() {
    rangeSliders = new RangeSliders();
});

var RangeSliders = function() {}

RangeSliders.prototype.init = function() {
    var ageMin = $("#age").attr( 'data-ageMin') != '' ? $("#age").attr( 'data-ageMin') : 18;
    var ageMax = $("#age").attr( 'data-ageMax') != '' ? $("#age").attr( 'data-ageMax') : 55;
    
    $( "#age" ).editRangeSlider({
        bounds: { 
            min: 18, max: 90 
        },
        defaultValues: { 
            min: ageMin, 
            max: ageMax
        }
    })
}