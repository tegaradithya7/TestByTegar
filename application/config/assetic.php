<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['assetic'] = array(
	'js' => array(
		//For every page
		'autoload' => array(
			'themes/default/assets/plugins/pace/pace.min.js',
			'themes/default/assets/plugins/jquery/jquery-3.2.1.min.js',
			'themes/default/assets/plugins/modernizr.custom.js',
			'themes/default/assets/plugins/jquery-ui/jquery-ui.min.js',
			'themes/default/assets/plugins/popper/umd/popper.min.js',
			'themes/default/assets/plugins/bootstrap/js/bootstrap.min.js',
			'themes/default/assets/plugins/jquery/jquery-easy.js',
			'themes/default/assets/plugins/jquery-unveil/jquery.unveil.min.js',
			'themes/default/assets/plugins/jquery-ios-list/jquery.ioslist.min.js',
			'themes/default/assets/plugins/jquery-actual/jquery.actual.min.js',
			'themes/default/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js',
			'themes/default/assets/plugins/select2/js/select2.full.min.js',
			'themes/default/assets/plugins/classie/classie.js',
			'themes/default/assets/plugins/switchery/js/switchery.min.js',
			'themes/default/assets/plugins/jquery-datatable/media/js/jquery.dataTables.min.js',
			'themes/default/assets/plugins/jquery-datatable/extensions/TableTools/js/dataTables.tableTools.min.js',
			'themes/default/assets/plugins/jquery-datatable/media/js/dataTables.bootstrap.js',
			'themes/default/assets/plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js',
			'themes/default/assets/plugins/datatables-responsive/js/datatables.responsive.js',
			'themes/default/assets/plugins/datatables-responsive/js/lodash.min.js',
			'themes/default/assets/plugins/bootstrap3-wysihtml5/bootstrap3-wysihtml5.all.min.js',
			'themes/default/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
			'themes/default/assets/plugins/summernote/js/summernote.min.js',
			'themes/default/assets/plugins/moment/moment.min.js',
			'themes/default/assets/plugins/bootstrap-daterangepicker/daterangepicker.js',
			'themes/default/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js',
			'themes/default/assets/plugins/bootstrap-typehead/typeahead.bundle.min.js',
			'themes/default/assets/plugins/bootstrap-typehead/typeahead.jquery.min.js',
			'themes/default/assets/js/reorderDatatableJs.js',
			'themes/default/pages/js/pages.js',
			'themes/default/assets/js/datatables.js',
			'themes/default/assets/js/form_elements.js',
			'themes/default/assets/js/scripts.js',
			'themes/default/assets/js/chained/jquery.chained.remote.js',
		),
		'default-group'	=> 'common',
	),
	'css' => array(
		//For every page
		'autoload' => array(
			'themes/default/assets/plugins/pace/pace-theme-flash.css',
			'themes/default/assets/plugins/bootstrap/css/bootstrap.min.css',
			'themes/default/assets/plugins/font-awesome/css/font-awesome.css',
			'themes/default/assets/plugins/jquery-scrollbar/jquery.scrollbar.css',
			'themes/default/assets/plugins/select2/css/select2.min.css',
			'themes/default/assets/plugins/switchery/css/switchery.min.css',
			'themes/default/assets/plugins/jquery-datatable/media/css/dataTables.bootstrap.min.css',
			'themes/default/assets/plugins/jquery-datatable/extensions/FixedColumns/css/dataTables.fixedColumns.min.css',
			'themes/default/assets/plugins/bootstrap3-wysihtml5/bootstrap3-wysihtml5.min.css',
			'themes/default/assets/plugins/datatables-responsive/css/datatables.responsive.css',
			'themes/default/assets/plugins/bootstrap-datepicker/css/datepicker3.css',
			'themes/default/assets/plugins/summernote/css/summernote.css',
			'themes/default/assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css',
			'themes/default/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css',
			'themes/default/pages/css/pages-icons.css',
			'themes/default/pages/css/pages.css',
		),
		'default-group'	=> 'style'
	),
	'static' => array(
		//Directory where Assetic puts the merged files
		'dir'					=> 'static/',
	)
);