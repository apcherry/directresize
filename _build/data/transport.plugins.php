<?php

$plugins = array();

$plugin = $modx->newObject('modPlugin');
$plugin->set('id', null);
$plugin->set('name', 'DirectResize');
$plugin->set('description', 'Simple Image and gallery viewer, expand pictures similar to Lightbox. The following viewers can be selected Highslide, Colorbox and prettyPhoto. ');
$plugin->set('plugincode', getSnippetContent($sources['source_core'].'/elements/plugins/directresize.php'));
 

/* add plugin events */
$events = include $sources['data'].'transport.plugins.events.php';
if (is_array($events) && !empty($events)) {
    $plugin->addMany($events, 'PluginEvents');
    $modx->log(xPDO::LOG_LEVEL_INFO,'Packaged in '.count($events).' Plugin Events.'); flush();
} else {
    $modx->log(xPDO::LOG_LEVEL_ERROR,'Could not find plugin events!');
}

 
$properties = Array
(
    "Exclude path" => array
        (
            "name" => "Exclude path",
            "desc" => "dr_excludePath_desc",
            "type" => "textfield",
            "options" => array
                (
                ),

            "value" => "assets/images/noresize",
            "lexicon" => "directresize:properties",
            "area" => "",
        ),

    "Expander" => array
        (
            "name" => "Expander",
            "desc" => "dr_expand_type_desc",
            "type" => "list",
            "options" => array
                (
                    "0" => array
                        (
                            "text" => "HighSlide",
                            "value" => "highslide",
                        ),

                    "1" => array
                        (
                            "text" => "Colorbox",
                            "value" => "colorbox",
                        ),

                    "2" => array
                        (
                            "text" => "prettyPhoto",
                            "value" => "prettyphoto",
                        ),

                ),

            "value" => "highslide",
            "lexicon" => "directresize:properties",
            "area" => "",
        ),

    "Opacity" => array
        (
            "name" => "Opacity",
            "desc" => "dr_opacity_desc",
            "type" => "numberfield",
            "options" => array
                (
                ),

            "value" => "40",
            "lexicon" => "directresize:properties",
            "area" => "",
        ),

    "Slide duration" => array
        (
            "name" => "Slide duration",
            "desc" => "dr_slide_duration_desc",
            "type" => "numberfield",
            "options" => array
                (
                ),

            "value" => "5000",
            "lexicon" => "directresize:properties",
            "area" => "",
        ),

    "Slideshow" => array
        (
            "name" => "Slideshow",
            "desc" => "Set images running as a slideshow",
            "type" => "combo-boolean",
            "options" => array
                (
                ),

            "value" => "",
            "lexicon" => "directresize:properties",
            "area" => "",
        ),

    "cache_path" => array
        (
            "name" => "cache_path",
            "desc" => "dr_cache_path_desc",
            "type" => "textfield",
            "options" => array
                (
                ),

            "value" => "assets/components/directresize/cache",
            "lexicon" => "directresize:properties",
            "area" => "",
        ),

    "enable" => array
        (
            "name" => "enable",
            "desc" => "dr_enable_desc",
            "type" => "list",
            "options" => array
                (
                    "0" => array
                        (
                            "text" => "off",
                            "value" => "0",
                        ),

                    "1" => array
                        (
                            "text" => "all images",
                            "value" => "2",
                        ),

                    "2" => array
                        (
                            "text" => "directResize class",
                            "value" => "1",
                        ),

                ),

            "value" => "2",
            "lexicon" => "directresize:properties",
            "area" => "",
        ),

    "image_path" => array
        (
            "name" => "image_path",
            "desc" => "dr_image_path_desc",
            "type" => "textfield",
            "options" => array
                (
                ),

            "value" => "assets/images",
            "lexicon" => "directresize:properties",
            "area" => "",
        ),

    "jpg_quality" => array
        (
            "name" => "jpg_quality",
            "desc" => "dr_jpg_quality_desc",
            "type" => "numberfield",
            "options" => array
                (
                ),

            "value" => "85",
            "lexicon" => "directresize:properties",
            "area" => "",
        ),

    "max height" => array
        (
            "name" => "max height",
            "desc" => "dr_height_desc",
            "type" => "numberfield",
            "options" => array
                (
                ),

            "value" => "600",
            "lexicon" => "directresize:properties",
            "area" => "",
        ),

    "max width" => array
        (
            "name" => "max width",
            "desc" => "dr_width_desc",
            "type" => "numberfield",
            "options" => array
                (
                ),

            "value" => "800",
            "lexicon" => "directresize:properties",
            "area" => "",
        ),

    "method" => array
        (
            "name" => "method",
            "desc" => "dr_method_desc",
            "type" => "numberfield",
            "options" => array
                (
                ),

            "value" => "0",
            "lexicon" => "directresize:properties",
            "area" => "",
        ),

    "png_quality" => array
        (
            "name" => "png_quality",
            "desc" => "dr_png_quality_desc",
            "type" => "numberfield",
            "options" => array
                (
                ),

            "value" => "8",
            "lexicon" => "directresize:properties",
            "area" => "",
        ),

    "prefix" => array
        (
            "name" => "prefix",
            "desc" => "dr_prefix_desc",
            "type" => "textfield",
            "options" => array
                (
                ),

            "value" => "dr_",
            "lexicon" => "directresize:properties",
            "area" => "",
        ),

    "thumb_h" => array
        (
            "name" => "thumb_h",
            "desc" => "dr_thumb_h_desc",
            "type" => "numberfield",
            "options" => array
                (
                ),

            "value" => "80",
            "lexicon" => "directresize:properties",
            "area" => "",
        ),

    "thumb_usesetting" => array
        (
            "name" => "thumb_usesetting",
            "desc" => "dr_thumb_usesetting_desc",
            "type" => "combo-boolean",
            "options" => array
                (
                ),

            "value" => "",
            "lexicon" => "directresize:properties",
            "area" => "",
        ),

    "thumb_w" => array
        (
            "name" => "thumb_w",
            "desc" => "dr_thumb_w_desc",
            "type" => "numberfield",
            "options" => array
                (
                ),

            "value" => "80",
            "lexicon" => "directresize:properties",
            "area" => "",
        ),

    "Style" => array
        (
            "name" => "Style",
            "desc" => "dr_cb_style_desc",
            "type" => "list",
            "options" => array
                (
                    "0" => array
                        (
                            "text" => "Style1",
                            "value" => "style1",
                        ),

                    "1" => array
                        (
                            "text" => "Style2",
                            "value" => "style2",
                        ),

                    "2" => array
                        (
                            "text" => "Style3",
                            "value" => "style3",
                        ),

                    "3" => array
                        (
                            "text" => "Style4",
                            "value" => "style4",
                        ),

                    "4" => array
                        (
                            "text" => "Style5",
                            "value" => "style5",
                        ),

                ),

            "value" => "style1",
            "lexicon" => "directresize:properties",
            "area" => "Colorbox",
        ),

    "Transition" => array
        (
            "name" => "Transition",
            "desc" => "dr_cb_transition_desc",
            "type" => "list",
            "options" => array
                (
                    "0" => array
                        (
                            "text" => "Elastic",
                            "value" => "elastic",
                        ),

                    "1" => array
                        (
                            "text" => "Fade",
                            "value" => "fade",
                        ),

                    "2" => array
                        (
                            "text" => "None",
                            "value" => "none",
                        ),

                ),

            "value" => "elastic",
            "lexicon" => "directresize:properties",
            "area" => "Colorbox",
        ),

    "Caption position" => array
        (
            "name" => "Caption position",
            "desc" => "dr_hs_captionPosition_desc",
            "type" => "list",
            "options" => array
                (
                    "0" => array
                        (
                            "text" => "Above image",
                            "value" => "above",
                        ),

                    "1" => array
                        (
                            "text" => "Top of image",
                            "value" => "top",
                        ),

                    "2" => array
                        (
                            "text" => "Lefthand panel",
                            "value" => "leftpanel",
                        ),

                    "3" => array
                        (
                            "text" => "Middle of image",
                            "value" => "middle",
                        ),

                    "4" => array
                        (
                            "text" => "Righthand panel",
                            "value" => "rightpanel",
                        ),

                    "5" => array
                        (
                            "text" => "Bottom",
                            "value" => "bottom",
                        ),

                    "6" => array
                        (
                            "text" => "Below",
                            "value" => "below",
                        ),

                ),

            "value" => "below",
            "lexicon" => "directresize:properties",
            "area" => "Highslide",
        ),

    "Caption source" => array
        (
            "name" => "Caption source",
            "desc" => "dr_hs_captionEval_desc",
            "type" => "list",
            "options" => array
                (
                    "0" => array
                        (
                            "text" => "Image Alt text",
                            "value" => "this.thumb.alt",
                        ),

                    "1" => array
                        (
                            "text" => "Image title text",
                            "value" => "this.thumb.title",
                        ),

                    "2" => array
                        (
                            "text" => "Image anchor title",
                            "value" => "this.a.title",
                        ),

                ),

            "value" => "this.thumb.title",
            "lexicon" => "directresize:properties",
            "area" => "Highslide",
        ),

    "Large caption" => array
        (
            "name" => "Large caption",
            "desc" => "dr_hs_captionMove_desc",
            "type" => "numberfield",
            "options" => array
                (
                ),

            "value" => "120",
            "lexicon" => "directresize:properties",
            "area" => "Highslide",
        ),

    "Outline type" => array
        (
            "name" => "Outline type",
            "desc" => "dr_hs_outlineType_desc",
            "type" => "list",
            "options" => array
                (
                    "0" => array
                        (
                            "text" => "Rounded white corners",
                            "value" => "rounded-white",
                        ),

                    "1" => array
                        (
                            "text" => "None",
                            "value" => "null",
                        ),

                    "2" => array
                        (
                            "text" => "Outer glow",
                            "value" => "outer-glow",
                        ),

                    "3" => array
                        (
                            "text" => "Glossy dark",
                            "value" => "glossy-dark",
                        ),

                    "4" => array
                        (
                            "text" => "Rounded black corners",
                            "value" => "rounded-black",
                        ),

                    "5" => array
                        (
                            "text" => "Beveled",
                            "value" => "beveled",
                        ),

                    "6" => array
                        (
                            "text" => "Drop shadow",
                            "value" => "drop-shadow",
                        ),

                ),

            "value" => "rounded-white",
            "lexicon" => "directresize:properties",
            "area" => "Highslide",
        ),

    "Theme" => array
        (
            "name" => "Theme",
            "desc" => "dr_pp_theme_desc",
            "type" => "list",
            "options" => array
                (
                    "0" => array
                        (
                            "text" => "Default",
                            "value" => "pp_default",
                        ),

                    "1" => array
                        (
                            "text" => "Dark rounded",
                            "value" => "dark_rounded",
                        ),

                    "2" => array
                        (
                            "text" => "Dark square",
                            "value" => "dark_square",
                        ),

                    "3" => array
                        (
                            "text" => "Light rounded",
                            "value" => "light_rounded",
                        ),

                    "4" => array
                        (
                            "text" => "Light square",
                            "value" => "light_square",
                        ),

                    "5" => array
                        (
                            "text" => "Facebook",
                            "value" => "facebook",
                        ),

                ),

            "value" => "pp_default",
            "lexicon" => "directresize:properties",
            "area" => "prettyPhoto",
        ),

);

 
$plugin->set('properties', $properties);

$plugins[] = $plugin;
 

return $plugins;
