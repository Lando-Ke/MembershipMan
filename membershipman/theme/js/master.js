/*Master JS file for home page */

$(document).ready(function() {
    //$("#intro").css("height", $(window).height());
    $(window).resize(function() {
        $("#intro").css("height", $(window).height());
    });

	$('select[data-cover="true"]').selecter({cover: true});
	$("select").selecter();
	$(".filefield").filestyle();

	/* == Tabs == */
	$(".wtabs .wojo.tab.data").hide();
	$(".wojo.tabs").find('a:first').addClass("active").show();
	$('.wtabs').each(function(){
		$(this).find('.wojo.tab.data:first').show();
	});
	$(".wojo.tabs a").on('click', function () {
		id = $(this).closest(".wtabs").attr("id");
		$("#" + id + " .wojo.tabs a").removeClass("active");
		$(this).addClass("active");
		$("#" + id + " .wojo.tab.data").hide();
		var activeTab = $(this).data("tab");
		$(activeTab).show();
	});

      /* == Close Message == */
      $('body').on('click', '.message i.close.icon', function () {
          var $msgbox = $(this).closest('.message')
          $msgbox.slideUp(500, function () {
              $(this).remove()
          });
      });
	  
	/* == Master Form == */
	$('body').on('click', 'button[name=dosubmit], .dosubmit', function() {
		var $parent = ($(this).is("button")) ? $(this).closest('.wojo.form') : $('.messi-content').find('.wojo.form');
		var posturl = $(this).data('url');

		function showResponse(json) {
			$($parent).removeClass("loading");
			$.sticky(decodeURIComponent(json.message), {
				autoclose: 12000,
				type: json.type,
				title: json.title
			});
			if(json.type == "success"){
				$parent.trigger("reset");
			}
		}

		function showLoader() {
			$($parent).addClass("loading");
		}
		var options = {
			target: null,
			beforeSubmit: showLoader,
			success: showResponse,
			type: "post",
			url: SITEURL + posturl,
			dataType: 'json'
		};

		$('#wojo_form').ajaxForm(options).submit();
	});

	
	
});