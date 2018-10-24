var HTML_LOAD_SPINNER 	=	"<br><li><center><i class='fa fa-spinner fa-spin'></i></center></li>";
var HTML_NO_CONTACT 	= 	"<br><li><center>No found result</center></li>";
var HTML_NO_MESSAGE 	= 	"<br><li><center>No found history message</center></li>";
var HTML_START_MESSAGE 	=	"<br><li><center>Lets chat with the other</center></li>";

jQuery(document).ready(function() {
	getListContact();
	renderSearchContact();
});

var goBack = () => {
	window.history.back();
};

var renderSearchContact = function() {
	$("#search_contact").keyup(function() {
		var search = $(this).val();
		if (search != "") {
			getListContact(search);
		} else {
			getListContact();
		}
	});
};

var getListContact = function(search) {
	$("#chat_username").html("");
	$.ajax({
		url: base_url + "page_chat_message/get_list_contact",
		method: "post",
		dataType: "json",
		data: { name: search },
		beforeSend: function() {
			$("#list_contact").html(HTML_LOAD_SPINNER);
			$("#list_message").html(HTML_START_MESSAGE);
		}
	})
		.done(function(data) {
			if (data.html != "") {
				$("#list_contact").html(data.html);
			} else {
				$("#list_contact").html(HTML_NO_CONTACT);
			}
		})
		.fail(function() {
			toastr.clear();
			toastr.error("Error Load Contact", "Error ", {
				closeButton: true,
				debug: false,
				positionClass: "toast-top-right",
				onclick: null,
				showDuration: "1000",
				hideDuration: "1000",
				timeOut: "3000",
				extendedTimeOut: "1000",
				showEasing: "swing",
				hideEasing: "linear",
				showMethod: "fadeIn",
				hideMethod: "fadeOut"
			});
		});
};

var getRecentChat = function(id, name) {
	$.ajax({
		url: base_url + "page_chat_message/get_chat_message",
		method: "post",
		dataType: "json",
		data: { id: id },
		beforeSend: function() {
			$("#list_message").html(HTML_LOAD_SPINNER);
		}
	})
		.done(function(data) {
			$(".contact").removeClass("active");
			$("#chat_" + id).addClass("active");
			$("#chat_username").html(name);
			$("textarea#chat_message").val("");
			$("#id_receiver").val(id);

			if (data.html != "") {
				$("#list_message").html(data.html);
			} else {
				$("#list_message").html(HTML_NO_MESSAGE);
			}
		})
		.fail(function() {
			toastr.clear();
			toastr.error("Error Load Message", "Error ", {
				closeButton: true,
				debug: false,
				positionClass: "toast-top-right",
				onclick: null,
				showDuration: "1000",
				hideDuration: "1000",
				timeOut: "3000",
				extendedTimeOut: "1000",
				showEasing: "swing",
				hideEasing: "linear",
				showMethod: "fadeIn",
				hideMethod: "fadeOut"
			});
		});
};

var sendChatMessage = function() {
	var id_receiver = $("input#id_receiver").val();
	var chat_message = $("textarea#chat_message").val();

	$.ajax({
		type: "post",
		url: base_url + "page_chat_message/submit/",
		data: {
			id_receiver: id_receiver,
			chat_message: chat_message
		},
		dataType: "json"
	})
		.done(function(data) {
			if (data.status == true) {
				$("textarea#chat_message").val("");
				getRecentChat(id_receiver);
				//	alert(id_receiver);
			} else {
				toastr.warning(data.reason, data.title, {
					closeButton: true,
					debug: false,
					positionClass: "toast-top-right",
					onclick: null,
					showDuration: "1000",
					hideDuration: "1000",
					timeOut: "3000",
					extendedTimeOut: "1000",
					showEasing: "swing",
					hideEasing: "linear",
					showMethod: "fadeIn",
					hideMethod: "fadeOut"
				});
			}
		})
		.fail(function() {
			toastr.clear();
			toastr.error("Please check your connection ", "Error ", {
				closeButton: true,
				debug: false,
				positionClass: "toast-top-right",
				onclick: null,
				showDuration: "1000",
				hideDuration: "1000",
				timeOut: "3000",
				extendedTimeOut: "1000",
				showEasing: "swing",
				hideEasing: "linear",
				showMethod: "fadeIn",
				hideMethod: "fadeOut"
			});
		});
};
