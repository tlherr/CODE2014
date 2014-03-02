

$('.filter').click(function(e) {
    if($(this).attr('data-sort-order') === 'none') {
        $(this).attr('data-sort-order', 'desc');
    } else if($(this).attr('data-sort-order') === 'desc') {
        $(this).attr('data-sort-order', 'asc');
    } else {
        $(this).attr('data-sort-order', 'desc');
    }

    $('.filter').not($(this)).attr('data-sort-order', 'none');

    $('.sortable').tsort({ attr: $(e.target).attr('data-sort-attr'), order: $(this).attr('data-sort-order')  });
});