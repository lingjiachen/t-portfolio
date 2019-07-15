var table;

$(document).ready(function () {

  if ($('#frm-approve').length > 0) {
    table = $('#approve').DataTable({
      columnDefs: [{
        orderable: false,
        className: 'select-checkbox',
        targets: 0
      }],
      select: 'multi',
      order: [[1, 'asc']]
    });

    $('#frm-approve').on('submit', function (e) {
      var form = this,
        rows_selected = table.rows({
          selected: true
        }).nodes();

      $.each(rows_selected, function (index, row) {
        $(form).append(
          $('<input>')
            .attr('type', 'hidden')
            .attr('name', 'id[]')
            .val(row.getAttribute('data-id'))
        );
      });
    });
  } else {
    table = $('#approve').DataTable();
  }

});