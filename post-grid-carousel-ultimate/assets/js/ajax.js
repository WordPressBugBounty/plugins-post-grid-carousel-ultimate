(function ($) {

	"use strict";

	$('.pgcu-post-sortable__btn').each(function(id, elm){
		$(elm).on("click", function (e) {
			e.preventDefault();
			var button = $(this),
				data = {
					'action': 'pgcu_sortable',
					'id': $(this).attr('data-id'),
					'term_id': $(this).attr('data-sortable-nav'),
					'query': pgcu_ajax.query
				};
			$(elm).closest('.pgcu-post-sortable__nav').siblings('.pgcu-row').addClass('pgcu-post-loading');
			$.ajax({ // you can also use $.post here
				url: pgcu_ajax.ajaxurl, // AJAX handler
				data: data,
				type: 'POST',
				success: function (data) {
					$(elm).closest('.pgcu-post-sortable__nav').siblings('.pgcu-row').empty().append(data);
					$(elm).siblings().removeClass('pgcu-post-sortable__btn--active');
					$(elm).addClass('pgcu-post-sortable__btn--active');
					$(elm).closest('.pgcu-post-sortable__nav').siblings('.pgcu-row').removeClass('pgcu-post-loading');
				}
			});
		});
	})

})(jQuery);