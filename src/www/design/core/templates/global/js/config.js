/**
 * TDProject_Core
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**  
 * Loader configuration
 */
	$(function() {
		$('#fogLoader').ajaxStart(function() {
			$('#loader').fogLoader({
				animated: true,
			});
		}).ajaxComplete(function() {
			$("#fogLoader").fogLoader("close");
		});
	});

/**
 * jGrowl configuration
 */
	$.jGrowl.defaults.position = 'bottom-right';