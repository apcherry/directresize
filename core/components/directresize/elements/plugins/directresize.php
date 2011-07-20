<?php
/**
 * DirectResize - applies highslide expander to site images
 *
 * Adrian Cherry
 * github.com/apcherry/directresize 
 * 
 * @package directresize
 */
/**
$modx->lexicon->load('directresize:properties');
*/
$path = $modx->getOption('cache_path',$scriptProperties,'assets/components/directresize/cache');
$prefix = $modx->getOption('prefix',$scriptProperties,'dr_');
$r = $modx->getOption('method',$scriptProperties,0);
$q_jpg = $modx->getOption('jpg_quality',$scriptProperties,85);
$q_png = $modx->getOption('png_quality',$scriptProperties,8);
$path_base = $modx->getOption('image_path',$scriptProperties,'assets/images');
$lightbox = $modx->getOption('enable',$scriptProperties,2);
$lightbox_w = $modx->getOption('width',$scriptProperties,800);
$lightbox_h = $modx->getOption('height',$scriptProperties,600);
$thumb_usesetting = $modx->getOption('thumb_usesetting',$scriptProperties,false);
$thumb_w = $modx->getOption('thumb_w',$scriptProperties,50);
$thumb_h = $modx->getOption('thumb_h',$scriptProperties,80);
$thumb_q = $modx->getOption('thumb_q',$scriptProperties,$q_jpg);
$hs_credit = $modx->getOption('hs_credit',$scriptProperties,'Highslide JS');
$hs_outlineType = $modx->getOption('hs_outlineType',$scriptProperties,'rounded-white');
$hs_captionEval = $modx->getOption('hs_captionEval',$scriptProperties,'this.thumb.alt');


if (substr($prefix,-1) != "_") $prefix .= "_";

include $modx->getOption('core_path').'components/directresize/elements/plugins/plugin.directresize.php';

$e = &$modx->event;

switch ($e->name) {
    case "OnWebPagePrerender":
        $o = $modx->documentOutput;

        
        $reg = "/<img[^>]*>/";  
        preg_match_all($reg, $o, $imgs, PREG_PATTERN_ORDER);
        for($n=0;$n<count($imgs[0]);$n++) {
            //-----------------------
            $path_img = preg_replace("/^.+src=('|\")/i","",$imgs[0][$n]);    
            $path_img = preg_replace("/('|\").*$/i","",$path_img);                                                                           
            //-----------------------

            if (substr($path_img,0,strlen($path_base)) == $path_base) {                                                                     

                $img = strtolower($imgs[0][$n]);
                $verif_balise = sizeof(explode("width",$img)) + sizeof(explode("height",$img)) - 2;
                if ($verif_balise > 0) {
                    #################################
                    preg_match("/height *(:|=) *[\"']* *\d+ *[\"']*/",$img,$array);                                      
                    sizeof(explode(":",$array[0])) > 1 ? $style = true : $style = false;
    		    //mod by Bruno
		    if ($thumb_usesetting && !empty($thumb_h)){
     			$height = $thumb_h;
     		    }else{
                        $height = preg_replace("[^0123456789]","",$array[0]);
                    }
                    //-------------------
                    preg_match("/width *(:|=) *[\"']* *\d+ *[\"']*/",$img,$array);
                    //mod by Bruno
		    if ($thumb_usesetting && !empty($thumb_w)){
     			$width = $thumb_w;
     		    }else{
                        $width = preg_replace("/[^0123456789]/","",$array[0]);
                    }
                    //-------------------
                    if ($style) {
                        $imgf = preg_replace("/(height|HEIGHT|Height) *: *[0123456789]* *(px)* */i","",$imgs[0][$n]);
                        $imgf = preg_replace("/(width|WIDTH|Width) *: *[0123456789]* *(px)* */i","",$imgf);
                    } else {
                        $imgf = preg_replace("/(height|HEIGHT|Height) *= *[\"']* *[0123456789]* *(px)* *[\"']*/i","",$imgs[0][$n]);
                        $imgf = preg_replace("/(width|WIDTH|Width) *= *[\"']* *[0123456789]* *(px)* *[\"']*/i","",$imgf);
                    }
                    //-------------------
                    preg_match("/^.+(src|Src|SRC)=('|\")/",$imgf,$path_g);
                    $imgf = preg_replace("/^.+src=('|\")/","",$imgf);
                    preg_match("/('|\").*$/",$imgf,$path_d);
                    //-------------------
                    $pathRedim = directResize($path_img,$path,$prefix,$width,$height,$r,$q_jpg,$q_png);
                    //-------------------
                    $nouvo_lien = $path_g[0].$pathRedim.$path_d[0];
                    
                    ###############################
                    preg_match("/highslide/",strtolower($imgs[0][$n]),$verif_light);
                    if (($lightbox == 1 && $verif_light[0] == "highslide") || ($lightbox == 2 && substr($path_img,0,strlen($path_base)) == $path_base)) {
                        $size       = getimagesize($path_img);
                        $img_src_w  = $size[0];
                        $img_src_h  = $size[1];
                        $alt        = "";
                        $title  = "";
                        preg_match("/(alt|Alt|ALT) *= *[\"|'][^\"']*[\"']/",$imgs[0][$n],$array);
                        if ($array[0] <> "") {
                            $alt = preg_replace("/alt *= *[\"|']/i","",$array[0]);
                            $alt = preg_replace("/[\"']*/i","",$alt);
                            $alt = trim($alt);
                        }
                        preg_match("/(title|Title|TITLE) *= *[\"|'][^\"']*[\"']/",$imgs[0][$n],$array);
                        if ($array[0] <> "") {
                            $title = preg_replace("/title *= *[\"|']/i","",$array[0]);
                            $title = preg_replace("/[\"']*/i","",$title);
                            $title = trim($title);
                        }
                        if ($alt <> "" || $title <> "") {
                            $legende = " title=\"$alt";
                            if ($alt <> "" && $title <> "") $legende .= "<br />";
                            if ($title <> "") $legende .= "<span style='font-weight:normal; font-size: 9px'>$title</span>";
                            $legende .= "\" ";
                        } else {
                            $legende = "";
                        }
                        if ($img_src_w > $width || $img_src_h > $height) {
                            if ($img_src_w > $lightbox_w || $img_src_h > $lightbox_h) {
                                $pathRedim = directResize($path_img,$path,$prefix,$lightbox_w,$lightbox_h,3,$q_jpg,$q_png);
                                $nouvo_lien = "<a class=\"highslide\" onclick=\"return hs.expand(this)\" ".$legende." href='".$pathRedim."' >".$nouvo_lien."</a>";
                            } else {
                                $nouvo_lien = "<a class=\"highslide\" onclick=\"return hs.expand(this)\" ".$legende." href='".$path_img."' >".$nouvo_lien."</a>";
                            }

                        }
                    }
                    ####################################

                    $o = str_replace($imgs[0][$n],$nouvo_lien,$o);
                }
            }
        }
        $head = '<script type="text/javascript" src="assets/components/directresize/js/highslide.packed.js"></script>
<link rel="stylesheet" type="text/css" href="assets/components/directresize/highslide.css" />
<script type="text/javascript">
hs.graphicsDir = \'assets/components/directresize/graphics/\';
                  hs.outlineType = \''.$hs_outlineType.'\';
                  hs.captionEval = \''.$hs_captionEval.'\';
                  hs.lang.creditsText = \''.$hs_credit.'\';</script>';

        $o = preg_replace('~(</head>)~i', $head . '\1', $o);
        $modx->resource->_output = $o;
        
        break;
    default :
        return;
        break;
}
