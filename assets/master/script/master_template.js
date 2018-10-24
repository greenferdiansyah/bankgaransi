/*
	Author 	:  	Fauzan Hilmy Abyan 
	Year	:	2018
	Version : 	0.0
	Notes 	:	Global Javascript For Template Adminpress
*/

jQuery(document).ready(function() {
	Master.init();
});

var Master = {
	//Declaration Constructor init
	init: function() {
		this.setSelect2();
		this.setSelectPicker();
		this.select2Validation();
		this.renderToolTip();
	},
	//Handling For initiation Select2 Plugin
	setSelect2: function() {
		$(".select2").select2();
	},
	//Handling For initiation Select picker Plugin
	setSelectPicker: function() {
		$(".selectpicker").selectpicker();
	},
	//Handling Select2 From Validation Plugin
	select2Validation: function() {
		$(".select2").on("select2:select", function() {
			$(this)
				.siblings(".help-block")
				.remove();
			$(this)
				.parents(".form-group")
				.removeClass("has-danger");
		});
	},
	//Handling Loading Button Effect Bootstrap 4
	handleLoadingButton: function($class) {
		$class.html('<i class="fa fa-circle-o-notch fa-spin"></i> Loading');
		$class.attr("disabled", true);
	},
	//Handling Reset Loading Button Effect Bootstrap 4
	resetLoadingButton: function($class, text) {
		$class.html(text);
		$class.attr("disabled", false);
	},
	//Handling Back Page
	goBack: function() {
		window.history.back();
	},
	//Hanlde Tooltip
	renderToolTip: function(){
		$(function () {
			$('[data-toggle="tooltip"]').tooltip("show");
		  })
	},
	//Handling Close Modal
	showModal: function($class) {
		$class.modal("show");
	},
	closeModal: function($class) {
		$class.modal("hide");
	}
};
