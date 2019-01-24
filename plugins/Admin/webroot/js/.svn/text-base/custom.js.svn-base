$(function () {
	initMethods();
});

/* Set Image preview on change of file input */
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#photo-preview').attr('style', 'background-image: url('+e.target.result+')');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function initMethods() {

    if ($( ".switch" ).length) {
        $(".switch").bootstrapSwitch('destroy', true);
        $(".switch").bootstrapSwitch({
            size: 'mini',
            onColor: 'success',
            onSwitchChange: function(event, state) {
            	var id = $(this).attr("data-value");
            	changeStatus(state,id);              
            }
        });
    }
}