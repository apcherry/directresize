<?php
/**
 * Properties Lexicon Topic
 *
 * @package directresize
 * @subpackage lexicon
 */

/* directresize properties */

$_lang['dr_width_desc'] = 'define the maximum width for the resized image.';
$_lang['dr_height_desc'] = 'define the maximum height for the resized image.';

$_lang['dr_cache_path_desc'] = "directory to store the resized images. The directory will be created if it doesn't exist.";
$_lang['dr_image_path_desc'] = 'location of images which will be resized, eg. assets/images/resize<br>If left blank then all images will be resized';
$_lang['dr_prefix_desc'] = 'prefix to apply to all resized images.';
$_lang['dr_height_desc'] = 'define the maximum height for the resized image.';
$_lang['dr_jpg_quality_desc'] = 'set compression level on any resized jpg files. Set between 0 and 100';
$_lang['dr_png_quality_desc'] = 'Set compression level on any png files resized. Set between 0 and 9';
$_lang['dr_method_desc'] = 'How to resize the image.<ul><li>0: proportional to the width and height</li><li> 1: based on the width</li><li>2: based on height</li><li>3: The maximum width and height</li><li>4: The image fills the container is full width and height.</li></ul>';
$_lang['dr_enable_desc'] = 'How to apply directResize to the images.<ul><li>0: off.</li><li>1: apply only to images with class or id set to directResize.</li><li>2: apply to all images in the path defined.</li></ul> ';
$_lang['dr_thumb_w_desc'] = 'Set pixel width for thumbnails.';
$_lang['dr_thumb_h_desc'] = 'Set thumbnail pixel height.';
$_lang['dr_thumb_usesetting_desc'] = 'Use plugin to set thumbnail size.';
$_lang['dr_hs_outlineType_desc'] = 'Select the border outline type for the images.';
$_lang['dr_hs_captionEval_desc'] = 'Select the source for the image caption.';
$_lang['dr_expand_type_desc'] = 'Select the required expander for the images<ul><li>Highslide</li><li>Colorbox</li><li>prettyPhoto</li></ul>If you want more then please request it';
$_lang['dr_cb_style_desc'] = 'Select the style to apply to the colorbox images';
$_lang['dr_opacity_desc'] = 'Set the background grey level, between  0 (white) and 100 (black)';
$_lang['dr_slide_duration_desc'] = 'Set the time between images when running a slideshow, measured in milliseconds';
$_lang['dr_cb_transistion_desc'] = 'Select the transition type when going from one photo to the next.';
$_lang['dr_pp_theme_desc'] = 'Select the border theme to apply to the prettyPhoto images';
