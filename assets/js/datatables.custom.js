$(document).ready(function() {
	
$("#infoitem").on('shown.bs.modal', function () {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});

$('#mytabl2').DataTable({
"bProcessing": true,
"bPaginate": false,
"bLengthChange": false,
"scrollX": false,
"scrollCollapse": false,
"fixedHeader": false,
"bFilter": false,
"bInfo": false,
"bAutoWidth": false	
});

$('#mytable2').DataTable({
"bProcessing": true,
"bPaginate": false,
"bLengthChange": false,
"scrollX": false,
"scrollCollapse": false,
"fixedHeader": false,
"bFilter": false,
"bInfo": false,
"bAutoWidth": false,
"order": [[ 1, "DESC" ]]
});

$('#mytable_desc2').DataTable({
"bProcessing": true,
"bPaginate": false,
"bLengthChange": false,
"scrollX": false,
"scrollCollapse": false,
"fixedHeader": false,
"bFilter": false,
"bInfo": false,
"bAutoWidth": false,
"order": [[ 1, "asc" ]]
});

$('#mytable_item, #mytable_item2').DataTable({
"bProcessing": true,
"bPaginate": true,
"bLengthChange": true,
"iDisplayLength": 10,
"scrollX": true,
"scrollY": true,
"scrollCollapse": true,
"fixedHeader": false,
"bFilter": true,
"bInfo": false,
"bAutoWidth": false,
"oLanguage": {
		"sSearch": "Pencarian: ",
		"oPaginate": {
			"sFirst": "<i class='fa fa-fast-backward'></i>",
			"sLast": "<i class='fa fa-fast-forward'></i>",
			"sNext": "<i class='fa fa-forward'></i>",
			"sPrevious": "<i class='fa fa-backward'></i>"
		}
	}
});

$('#mytable_info').DataTable({
"bProcessing": true,
"bPaginate": false,
"bLengthChange": false,
"scrollX": false,
"scrollCollapse": false,
"fixedHeader": false,
"bFilter": false,
"bInfo": false,
"bAutoWidth": false	
});

});