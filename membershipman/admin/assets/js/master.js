(function($) {
    $.Master = function(settings) {
        var config = {
            weekstart: 0,
            lang: {
                button_text: "Choose file...",
                empty_text: "No file...",
                monthsFull: '',
                monthsShort: '',
                weeksFull: '',
                weeksShort: '',
                weeksMed: '',
                today: "Today",
                delBtn: "Delete Record",
                clear: "Clear",
                selProject: "Select Project",
                delMsg1: "Are you sure you want to delete this record?",
                delMsg2: "This action cannot be undone!!!",
                working: "working..."
            }
        };

        if (settings) {
            $.extend(config, settings);
        }

        var itemid = ($.url(true).param('id')) ? $.url(true).param('id') : 0;
        var plugname = $.url(true).param('plugin');
        var modname = $.url(true).param('module');
		var posturl = (plugname ? "../plugins/" + plugname + "/controller.php" : (modname ? "../modules/" + modname + "/controller.php" : SITEURL + "/admin/controller.php"));
		
		$("table.sortable").tablesort();
		$(".filefield").filestyle({buttonText: config.lang.button_text});

		$('select[data-cover="true"]').selecter({cover: true});
		$("select").selecter();
		$('.wojo.dropdown').dropdown();
		$('body [data-content]').popup({
			context: 'html'
		});

		/* == Scrollbox == */
		$(".scrollbox").scroller();
		
		/* == Datepicker == */
        $.fn.datetimepicker.dates['en'] = 
		 {
			  days:        config.lang.weeksFull,
			  daysShort:   config.lang.weeksMed,
			  daysMin:     config.lang.weeksShort,
			  months:      config.lang.monthsFull,
			  monthsShort: config.lang.monthsShort,
			  meridiem:    ["am", "pm"],
			  suffix:      ["st", "nd", "rd", "th"],
			  today:       config.lang.today
		}
			
		$('body [data-datepicker]').datetimepicker({
        weekStart: config.weekstart,
		format: "dd, MM yyyy",
        autoclose: true,
        todayBtn: true,
        linkField: true,
        linkFormat: "yyyy-mm-dd",
		startView: 2,
		minView: 2,
		forceParse: 0,
		});
		
		$('body [data-timepicker]').datetimepicker({
			weekStart: config.weekstart,
			format: "HH:ii:00",
			autoclose: true,
			todayBtn: true,
			linkField: true,
			startView: 1,
			minView: 0,
			maxView: 1,
			forceParse: 0
		});

		/* == Editor == */
		$('.bodypost').redactor({
			observeLinks: true,
			wym: true,
			toolbarFixed: false,
			minHeight: 400,
			maxHeight: 600,
			plugins: ['fullscreen']
		});

		/* == Editor == */
		$('.fullpage').redactor({
			observeLinks: true,
			toolbarFixed: true,
			minHeight: 500,
			maxHeight: 800,
			iframe: true,
			focus: true,
			plugins: ['fullscreen']
		});
		
		$('.altpost').redactor({
			observeLinks: true,
			minHeight: 150,
			buttons: ['formatting', 'bold', 'italic', 'unorderedlist', 'orderedlist', 'outdent', 'indent'],
			wym: true,
			plugins: ['fullscreen']
		});
		/* == Submit Search by date == */
		$("#doDates").on('click', function () {
			$("#admin_form").submit();
			return false;
		});
		
		/* == From/To date range == */
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
		$('#fromdate')
			.datetimepicker({
				weekStart: config.weekstart,
				todayBtn:  1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				minView: 2,
				forceParse: 0
			})
			.on('changeDate', function(e) {
				var newDate = new Date(e.date)
				newDate.setDate(newDate.getDate() + 1);
				$('#enddate').datetimepicker('setStartDate', newDate)
		});

		/* == Master Form == */
		$('body').on('click', 'button[name=dosubmit], .dosubmit', function() {
		    var $parent = ($(this).is("button")) ? $(this).closest('.wojo.form') : $('.messi-content').find('.wojo.form');
		    function showResponse(json) {
				$($parent).removeClass("loading");
				$.sticky(decodeURIComponent(json.message), {
					autoclose: 12000,
					type: json.type,
					title: json.title
				});
		    }

		    function showLoader() {
		        $($parent).addClass("loading");
		    }
		    var options = {
		        target: null,
		        beforeSubmit: showLoader,
		        success: showResponse,
		        type: "post",
		        url: posturl,
		        dataType: 'json'
		    };

		    $('#wojo_form').ajaxForm(options).submit();
		});

		/* == Delete Item == */
		$('body').on('click', 'a.delete', function () {
			var data = $(this).data("set");
			$parent = $(this).closest(data.parent);
			new Messi("<div class=\"messi-warning\"><p><i class=\"icon warn danger sign\"></i></p><p>" + config.lang.delMsg1  + "<br><strong>" + config.lang.delMsg2  + "</strong></p></div>", {
				title: data.title,
				titleClass: '',
				modal: true,
				closeButton: true,
				buttons: [{
					id: 0,
					label: config.lang.delBtn,
					class: 'basic negative',
					val: 'Y'
				}],
				callback: function (val) {
					$.ajax({
						type: 'post',
						url: posturl,
						dataType: 'json',
						data: {
							id: data.id,
							delete: data.option,
							extra: data.extra ? data.extra : null,
							title: encodeURIComponent(data.name)
						},
						beforeSend: function () {
							$parent.css({
								'opacity': .35
							});
						},
						success: function (json) {
							$parent.fadeOut(400, function () {
								$parent.remove();
							});
							$.sticky(decodeURIComponent(json.message), {
								type: json.type,
								title: json.title
							});
						}

					});
				}
			});
		});

		/* == Search == */
		$("#searchfield").on('keyup', function () {
			var srch_string = $(this).val();
			var type_string = $(this).prop('name');
			if (srch_string.length > 3) {
				$.ajax({
					type: "get",
					url: ADMINURL + '/controller.php',
					data: {
						doLiveSearch:1,
						value: srch_string,
						type: type_string
						},
					success: function (res) {
						$('#suggestions').html(res).show();
						$("input").blur(function () {
							$('#suggestions').fadeOut();
						});
					}
				});
			}
			return false;
		});

		/* == Inline Edit == */
		$('#editable').editableTableWidget();
		$('#editable')
		.on('validate', '[data-editable]', function(e, val) {
			if (val === "") {
				return false;
			}
		})
		.on('change', '[data-editable]', function(e, val) {
			data = $(this).data('set');
			$this = $(this);
			$.ajax({
				type: "POST",
				url: ADMINURL + "/controller.php",
				data: ({
					'title': val,
					'type': data.type,
					'key': data.key,
					'path': data.path,
					'id': data.id,
					'quickedit': 1
				}),
				beforeSend: function() {
					$this.text(config.lang.working).animate({
						opacity: 0.2
					}, 800);
				},
				success: function(res) {
					$this.animate({
						opacity: 1
					}, 800);
					setTimeout(function() {
						$this.html(res).fadeIn("slow");
					}, 1000);
				}
			})
		});
		
		/* == Submit Search by date == */
		$("#doDates").on('click', function () {
			$("#admin_form").submit();
			return false;
		});
		
        /* == Admin Menu == */
        var MenuNav = (function() {
            var $listItems = $('nav > ul > li'),
                $menuItems = $listItems.children('a'),
                $body = $('body'),
                current = -1;

            function init() {
                $menuItems.on('click', open);
                $listItems.on('click', function(event) {
                    event.stopPropagation();
                });
                $("div.mobilemenu a").on('click', function(event) {
                    $('nav').slideToggle()
                });
            }

            function open(event) {
                if (current !== -1) {
                    $listItems.eq(current).removeClass('opened').find('.dotoggle').removeClass('minus').addClass('add');
                }

                var $item = $(event.currentTarget).parent('li'),
                    idx = $item.index();

                if (current === idx) {
                    $item.removeClass('opened').find('.dotoggle').removeClass('minus').addClass('add');
                    current = -1;
                } else {
                    $item.addClass('opened').find('.dotoggle').removeClass('add').addClass('minus');
                    current = idx;
                    $body.off('click').on('click', close);
                }


            }

            function close(event) {
                $listItems.eq(current).removeClass('opened').find('.dotoggle').removeClass('minus').addClass('add');
                current = -1;
            }

            return {
                init: init
            };

        })();

        MenuNav.init();
    };
})(jQuery);


/*This is the end */
