<?php
/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2015 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

AddonParser::addAddon('sp_gmap','sp_gmap_addon');

function sp_gmap_addon($atts){

	extract(spAddonAtts(array(
		"title"					=> '',
		"heading_selector" 		=> 'h3',
		"title_fontsize" 		=> '',
		"title_fontweight" 		=> '',
		"title_text_color" 		=> '',
		"title_margin_top" 		=> '',
		"title_margin_bottom" 	=> '',		
		"map"					=> '',
		"height"				=> '',
		"type"					=> '',
		"zoom"					=> '',
		'mousescroll'			=> '',
		"class"					=> '',
		), $atts));

	if($map) {

		$map = explode(',', $map);

		$doc = JFactory::getDocument();
		$doc->addScript('//maps.googleapis.com/maps/api/js?key=AIzaSyBAGbcbnRawKGxhgMCVY1far7wIh_6oKbo&callback=initMap');
		$doc->addScript( JURI::base(true) . '/components/com_sppagebuilder/assets/js/gmap.js');

		$output  = '<div class="sppb-addon sppb-addon-gmap ' . $class . '">';

		if($title) {

			$title_style = '';
			if($title_margin_top !='') $title_style .= 'margin-top:' . (int) $title_margin_top . 'px;';
			if($title_margin_bottom !='') $title_style .= 'margin-bottom:' . (int) $title_margin_bottom . 'px;';
			if($title_text_color) $title_style .= 'color:' . $title_text_color  . ';';
			if($title_fontsize) $title_style .= 'font-size:'.$title_fontsize.'px;line-height:'.$title_fontsize.'px;';
			if($title_fontweight) $title_style .= 'font-weight:'.$title_fontweight.';';

			$output .= '<'.$heading_selector.' class="sppb-addon-title" style="' . $title_style . '">' . $title . '</'.$heading_selector.'>';
		}

		$output .= '<div class="sppb-addon-content">';

		$output .= '<div style="height:' . (int) $height . 'px" class="sppb-addon-gmap-canvas" data-lat="' . $map[0] . '" data-lng="' . $map[1] . '" data-maptype="' . $type . '" data-mapzoom="' . $zoom . '" data-mousescroll="' . $mousescroll . '"></div>';

		$output .= '</div>';
		
		$output .= '</div>';

		return $output;

	}

	return;

}