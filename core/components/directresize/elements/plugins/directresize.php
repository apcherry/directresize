<?php
/*
 * DirectResize - applies highslide expander to site images
 * 
 * Adrian Cherry
 * github.com/apcherry/directresize 
 * @package directresize
*/

$modx->lexicon->load('directresize:properties');

$path = $modx->getOption('cache_path',$scriptProperties,'assets/components/directresize/cache');
$prefix = $modx->getOption('prefix',$scriptProperties,'dr_');
$r = $modx->getOption('method',$scriptProperties,0);
$q_jpg = $modx->getOption('jpg_quality',$scriptProperties,85);
$q_png = $modx->getOption('png_quality',$scriptProperties,8);
$path_base = $modx->getOption('image_path',$scriptProperties,'assets/images');
$lightbox = $modx->getOption('enable',$scriptProperties,2);
$lightbox_w = $modx->getOption('max width',$scriptProperties,800);
$lightbox_h = $modx->getOption('max height',$scriptProperties,600);
$thumb_usesetting = $modx->getOption('thumb_usesetting',$scriptProperties,false);
$thumb_w = $modx->getOption('thumb_w',$scriptProperties,50);
$thumb_h = $modx->getOption('thumb_h',$scriptProperties,80);
$thumb_q = $modx->getOption('thumb_q',$scriptProperties,$q_jpg);
$hs_credit = $modx->getOption('hs_credit',$scriptProperties,'Highslide JS');
$hs_outlineType = $modx->getOption('Outline type',$scriptProperties,'rounded-white');
$hs_captionEval = $modx->getOption('Caption source',$scriptProperties,'this.thumb.alt');
$expander = $modx->getOption('Expander',$scriptProperties,'highslide');
$cb_style = $modx->getOption('Style',$scriptProperties,'style1');
$cb_transition = $modx->getOption('Transition',$scriptProperties,'elastic');
$pp_theme = $modx->getOption('Theme',$scriptProperties,'pp_default');
$slideshow = ($modx->getOption('Slideshow',$scriptProperties,false))? 'true' : 'false';
$duration = $modx->getOption('Slide duration',$scriptProperties,2500);
$opacity = number_format($modx->getOption('Opacity',$scriptProperties,50)/100,2);
$captionPosition = $modx->getOption('Caption position',$scriptProperties,'below');
$largeCaption = $modx->getOption('Large caption',$scriptProperties,120);
$excludePath = $modx->getOption('Exclude path',$scriptProperties,'assets/images/noresize');

if (substr($prefix,-1) != "_") $prefix .= "_";

include $modx->getOption('core_path').'components/directresize/elements/plugins/plugin.directresize.php';

$e = &$modx->event;

switch ($e->name) {
    case "OnWebPagePrerender":
       $o = &$modx->resource->_output; // get a reference to the output
       $foundImage = false; // if no image found then don't insert javascript
       
       // search for all the image tags on the page
       $reg = "/<img[^>]*>/";  
       preg_match_all($reg, $o, $imgs, PREG_PATTERN_ORDER);
  
       // process each image tag 
       for($n=0;$n<count($imgs[0]);$n++) {
            //-----------------------
            $path_img = preg_replace("/^.+src=('|\")/i","",$imgs[0][$n]);    
            $path_img = preg_replace("/('|\").*$/i","",$path_img);                                                                           
            //-----------------------
            
	    // process the image if it's in the defined directory 
            if (substr($path_img,0,strlen($path_base)) == $path_base && substr($path_img,0,strlen($excludePath)) != $excludePath) { 
                $foundImage = true;
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
                    $new_link = $path_g[0].$pathRedim.$path_d[0];

                    ###############################
                    preg_match("/directresize/",strtolower($imgs[0][$n]),$verif_light);
                    if (($lightbox == 1 && $verif_light[0] == "directresize") || ($lightbox == 2 && substr($path_img,0,strlen($path_base)) == $path_base)) {
                        $size       = getimagesize($path_img);
                        $img_src_w  = $size[0];
                        $img_src_h  = $size[1];
                        $alt        = "";
                        $title  = "";
		        // create the expanded image legend from the title and alt tags, for colorbox and prettyPhoto
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
		        // work out if the caption is large enough to go into the right hand panel
		        if ($largeCaption > 0 && ( strlen($title) > $largeCaption || strlen($alt) > $largeCaption )) {
			    $override = ', { captionOverlay: { position: \'rightpanel\', width: \'250px\' } }';
		        } else {
			    $override = '';
			}
                        if ($img_src_w > $width || $img_src_h > $height) {
                                
                          // select which expander to apply to the graphical element
			  switch ($expander) {
			    case "colorbox" :
			          $new_link = "<a class='colorbox cboxElement' ".$legende." href='".$path_img."' >".$new_link."</a>";
			          break;
			    case "prettyphoto" :
			          $new_link = "<a rel='prettyPhoto[[pp_gal]]' ".$legende." href='".$path_img."' >".$new_link."</a>";
			          break;
			    default : //use highslide as the default
			    $new_link = "<a class='highslide' onclick=\"return hs.expand(this".$override.")\" href='".$path_img."' >".$new_link."</a>";
			  }
                        }

 
                    } // end lightbox highslide test

                    $o = str_replace($imgs[0][$n],$new_link,$o);

                } // end verif_balise            
            } // end path_base test
       } // end for loop
      
        // select which expander style sheet and java script is required
       switch ($expander) {
	  case "colorbox" :
	    $drStyle = "<link rel='stylesheet' type='text/css' href='assets/components/directresize/colorbox/".$cb_style."/colorbox.css' />\n";
	    $jsCall = "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
                       <script type='text/javascript' src='assets/components/directresize/js/jquery.colorbox-min.js'></script>
                       <script>
                          jQuery('a.colorbox').colorbox({
                                 rel:'colorbox',
                                 opacity:".$opacity.",
                                 transition:'".$cb_transition."',
                                 slideshow:".$slideshow.",
                                 slideshowSpeed:".$duration.",
                                 maxWidth:".$lightbox_w.",
                                 maxHeight:".$lightbox_h."});
                       </script>\n";
	    break;
	  
	  case "prettyphoto" :
	  $drStyle = "<link rel='stylesheet' type='text/css' href='assets/components/directresize/css/prettyPhoto.css' />\n";
	    $jsCall = "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
                       <script type='text/javascript'src='assets/components/directresize/js/jquery.prettyPhoto.js'></script>
                       <script>
                       $(document).ready(function(){
                       $(\"a[rel^='prettyPhoto']\").prettyPhoto({
                          theme:'".$pp_theme."',
                          opacity:".$opacity.",
                          autoplay_slideshow:".$slideshow.",
                          slideshow:".$duration."});});
                       </script>\n";
	    break;
	  default :// default to highslide settings
	    $drStyle = "<link rel='stylesheet' type='text/css' href='assets/components/directresize/highslide/highslide.css' />\n";
	    $jsCall = "<script type='text/javascript' src='assets/components/directresize/js/highslide-with-gallery.min.js'></script>
                       <script type='text/javascript'>
                           hs.graphicsDir = 'assets/components/directresize/highslide/graphics/';
                           hs.outlineType = '".$hs_outlineType."';
                           hs.captionEval = '".$hs_captionEval."';
                           hs.captionOverlay.position = '".$captionPosition."';
                           hs.dimmingOpacity = ".$opacity.";
                           hs.numberPosition = 'caption';
	                   hs.lang.number = 'Image %1 of %2';
                           hs.maxWidth = '".$lightbox_w."';
                           hs.maxHeight = '".$lightbox_h."';
                           hs.lang.creditsText = '".$hs_credit."';
                           </script>\n";
	    if ( $slideshow == 'true' ) {
	         $jsCall = $jsCall."<script type='text/javascript'>
                           hs.addSlideshow({
	                   interval: ".$duration.",
	                   repeat: false,
	                   useControls: true,
	                   fixedControls: true,
	                   overlayOptions: {
		                opacity: ".$opacity.",
		                position: 'top center',
		                hideOnMouseOut: true,
                           }});
                           </script>\n";
	    }
	   
	}
        // only add style sheet and javascript if there is an image to resize
        if ( $foundImage ) {
            // add the style sheet to the head of the html file
            $o = preg_replace('~(</head>)~i', $drStyle . '\1', $o);
  
            // add the javascript to the bottom of the page 
            $o = preg_replace('~(</body>)~i', $jsCall . '\1', $o);
	}
  
       break;
    default :
        return;
        break;

// end switch
}
