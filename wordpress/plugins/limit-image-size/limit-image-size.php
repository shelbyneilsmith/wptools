<?php
/*
 Plugin Name: Limit Image Size
 Plugin URI: http://cantuaria.net.br/limit-image-size/
 Description: Limit Image Size will save space in disk and bandwith resizing large images when you upload them to WordPress.
 Author: Bruno Cantuária
 Author URI: http://www.cantuaria.net.br
 Version: 1.0
 */

function lis_iniciar_plugin() {

	load_plugin_textdomain( 'lis-plugin', false, basename(dirname(__FILE__)) . "/lang" );
	
}
add_action('plugins_loaded', 'lis_iniciar_plugin'); 
 
function lis_adicionar_opcoes() {

	add_settings_section('lis_options',__('Options for Limit Image Size','lis-plugin'),'lis_adicionar_opcoes_callback','media');
	
	add_settings_field('lis_megapixels',__('Maximum Image Megapixels','lis-plugin'),'lis_adicionar_opcoes_interno_callback','media','lis_options',array('setting'=>'lis_megapixels'));
	add_settings_field('lis_quality',__('Image Quality','lis-plugin'),'lis_adicionar_opcoes_interno_callback','media','lis_options',array('setting'=>'lis_quality'));
	add_settings_field('lis_checkpng',__('Resize PNG?','lis-plugin'),'lis_adicionar_opcoes_interno_callback','media','lis_options',array('setting'=>'lis_checkpng'));
	add_settings_field('lis_convert',__('Convert PNG to JPG?','lis-plugin'),'lis_adicionar_opcoes_interno_callback','media','lis_options',array('setting'=>'lis_convert'));
	add_settings_field('lis_servico',__('Try Use an WebService?','lis-plugin'),'lis_adicionar_opcoes_interno_callback','media','lis_options',array('setting'=>'lis_servico'));

	register_setting('media','lis_megapixels');
	register_setting('media','lis_quality');
	register_setting('media','lis_checkpng');
	register_setting('media','lis_convert');
	register_setting('media','lis_servico');
	
}
add_action('admin_init', 'lis_adicionar_opcoes');

function lis_adicionar_opcoes_callback() {

	_e("Limit Image Size have 3 methods to resize your image.","lis-plugin");
	
	echo '<table style="background: #eee;border: 1px solid #ccc;">';
	
		echo '<tr><td style="font-weight: bold; padding: 10px;">ImageMagick</td>';
		if ( (extension_loaded('imagick')) || (extension_loaded('gmagick')) ) {
			echo '<td style="padding: 10px;"><img src="'. plugins_url( 'images/available.png' , __FILE__ ) .'" width="24px" height="24px" alt="Available" ></td>';
			echo '<td>'. __("Your server can run ImageMagick. Your should not have problems!","lis-plugin") . '</td>';
		} else {
			echo '<td style="padding: 10px;"><img src="'. plugins_url( 'images/unavailable.png' , __FILE__ ) .'" width="24px" height="24px" alt="Unavailable" ></td>';
			echo '<td>'. __("Your server does not have ImageMagick installed. For best performance install or ask your host to install this extension. More details in the following link:","lis-plugin") . ' <a href="http://www.imagemagick.org" target="_blank">ImageMagick</a></td>';
		}
		echo '</tr>';
		
		echo '<tr><td style="font-weight: bold; padding: 10px;">WebService</td>';
		if ( get_option('lis_servico',0)  ) {
			echo '<td style="padding: 10px;"><img src="'. plugins_url( 'images/available.png' , __FILE__ ) .'" width="24px" height="24px" alt="Available" ></td>';
			echo '<td>'. __("Before use GD, the plugin will try use the WebService for resize images. You can deactivate this option below.","lis-plugin") . '</td>';
		} else {
			echo '<td style="padding: 10px;"><img src="'. plugins_url( 'images/unavailable.png' , __FILE__ ) .'" width="24px" height="24px" alt="Unavailable" ></td>';
			echo '<td>'. __("The plugin will not try use the WebService. You can activate this option below.","lis-plugin") . '</td>';
		}
		echo '</tr>';
			
		echo '<tr><td style="font-weight: bold; padding: 10px;">GD</td>';
		if (function_exists("imagecreatetruecolor")) {
			echo '<td style="padding: 10px;"><img src="'. plugins_url( 'images/available.png' , __FILE__ ) .'" width="24px" height="24px" alt="Available" ></td>';
			echo '<td>'. __("Your server can run the GD script, the plugin will use it only as last resource. If GD is the only resource available to you, you may want disable the PNG Resize and/or improve your site memory.","lis-plugin") . '</td>';
		} else {
			echo '<td style="padding: 10px;"><img src="'. plugins_url( 'images/unavailable.png' , __FILE__ ) .'" width="24px" height="24px" alt="Unavailable" ></td>';
			echo '<td>'. __("GD is unavailable at your server.","lis-plugin") . '</td>';
		}
		echo '</tr>';
		
	echo "</table>";
	
}

function lis_adicionar_opcoes_interno_callback($args) {
	
	switch ($args["setting"]) {
		case "lis_megapixels":
			echo '<input name="lis_megapixels" id="lis_megapixels" type="number" min="0.1" max="10" step="0.1" value="'. get_option('lis_megapixels',"1.5") .'" /> '. __('Any image with more megapixels than this setting will be resized to have this exactly megapixel.','lis-plugin') .' <span style="font-weight:bold; vertical-align: top;">'. __('Recommended:','lis-plugin') .' 1.5</span>';
		break;
		case "lis_quality":
			echo '<input name="lis_quality" id="lis_quality" type="number" min="10" max="100" step="1" value="'. get_option('lis_quality',"85") .'" /> '. __('Change the image quality when possible. Higher values give better image quality but with increased image size.','lis-plugin') .' <span style="font-weight:bold; vertical-align: top;">'. __('Recommended:','lis-plugin') . ' 85</span>';
		break;
		case "lis_checkpng":
			echo '<input name="lis_checkpng" id="lis_checkpng" type="checkbox" value="1" class="code" '. checked(1, get_option('lis_checkpng',0), false ) .' /> '. __('Check this to resize images in PNG format. You will want to keep this unchecked if your server is very limited.','lis-plugin');
		break;
		case "lis_convert":
			echo '<input name="lis_convert" id="lis_convert" type="checkbox" value="1" class="code" '. checked(1, get_option('lis_convert',0), false ) .' /> '. __('JPG images does not have transparency, but have lower file size. This setting will only take effect if the setting above is checked.');
		break;
		case "lis_servico":
			echo '<input name="lis_servico" id="lis_servico" type="checkbox" value="1" class="code" '. checked(1, get_option('lis_servico',0), false ) .' /> '. __('If your server is limited, the plugin may try use an webservice to resize the image. WebService used in this version:','lis-plugin') . ' <a href="http://dsin.appspot.com/image" target="_blank">dsin at App Engine</a>';
		break;
			
	}
	
}

function lis_adicionar_info( $form_fields, $post ) {
	
	if( substr($post->post_mime_type, 0, 5) == 'image' ){  
		
		$resized = get_post_meta($post->ID, "_lis_resized", true);
		if (!$resized) $resized = "<tr><td>" . __("This midia was not resized by Limit Image Size","lis-plugin") ."</td></tr>";
		$form_fields["lis_resized"] = array(
			"label" => __("Resize Information","lis-plugin"),
			"input" => "html",
			"html" => '<table style="background: #eee;border: 1px solid #ccc;padding: 5px;">
						'. $resized .'
						</table>'
		);
		
	}
 
	return $form_fields;
}
add_filter("attachment_fields_to_edit", "lis_adicionar_info", null, 2);

$lis_metadata = "";

function lis_redimensiona_imagem($args) {
	global $lis_metadata;
	$lis_metadata = false;
	
	$arquivo = $args["file"];
	
	$limite = round(floatval(get_option('lis_megapixels',"1.5")),1);
	if (!$limite) $limite = 1.5;
	
	$convert = get_option('lis_convert',0);
	$checkPng = get_option('lis_checkpng',0);
	$usarServico = get_option('lis_servico',0);
	
	if (!$checkPng && $args["type"]=="image/png")
		return $args;	
	if ($args["type"]!="image/png" && $args["type"]!="image/jpg" && $args["type"]!="image/jpeg")
		return $args;
	
	$imagem = getimagesize($arquivo);
	if ($imagem) {
		
		$size = round(filesize($arquivo)/1024,2);
		
		$megapixels = $imagem[0]*$imagem[1];
		$limite_mp = $limite * 1024 * 1024;
		
		if ($megapixels>$limite_mp) {
			
			$limite = $limite * 1024;
			
			if ($imagem[0]>$imagem[1]) {
				$proporcao = $imagem[0]/$imagem[1];
				$height = round(sqrt($limite_mp/$proporcao));
				$width = round($height * $proporcao);
			} elseif ($imagem[1]>$imagem[0]) {
				$proporcao = $imagem[1]/$imagem[0];
				$width = round(sqrt($limite_mp/$proporcao));
				$height = round($width * $proporcao);
			} else {
				$width = $limite;
				$height = $limite;
			}
			
			$lis_metadata = "";
			$lis_metadata .= lis_formatar_data("dimension",$imagem[0] ." x ". $imagem[1],$width ." x ". $height);
			$lis_metadata .= lis_formatar_data("megapixels",$megapixels,$limite_mp);
			
		} else {
			
			return $args;
		}
	
	} else {
		return $args;
	}
	
	//Trying Image Magick
	if ( (extension_loaded('imagick')) || (extension_loaded('gmagick')) ) {
		
		if (extension_loaded('imagick'))
			$nova = new Imagick($arquivo);
		else
			$nova = new Gmagick($arquivo);
		
		$nova->thumbnailImage($width,$height);
		clearstatcache();
		
		if ($args["type"]=="image/png") {
			if ($convert) {
				unlink($arquivo);
				$arquivo = substr($arquivo,0,-3)."jpg";
				$args["file"] = $arquivo;
				$args["type"] = "image/jpeg";
			} else {
				unlink($arquivo);
				$novo_arquivo .= $arquivo."32";
				$nova->writeImage($novo_arquivo);
				rename($novo_arquivo,$arquivo);
				$nova->clear();
				$nova->destroy();
				
				$lis_metadata .= lis_formatar_data("size",$size,round(filesize($arquivo)/1024,2));
				$lis_metadata .= lis_formatar_data("method","ImageMagick");
				
				unset($size);
				return $args;
			}
		}
		
		
		$nova->writeImage($arquivo);
		$nova->clear();
		$nova->destroy();
		
		$lis_metadata .= lis_formatar_data("size",$size,round(filesize($arquivo)/1024,2));
		$lis_metadata .= lis_formatar_data("method","ImageMagick");
		
		unset($size);
		return $args;
	
	}
	
	//Lets use service if settings allow
	if ($usarServico) {

		$dados = http_build_query( array('img_url'=>$args["url"],'w' => $width,'h' => $height));
		$servico = array('http' => array( 'method'  => 'POST', 'header'  => "Content-type: application/x-www-form-urlencoded\r\nContent-Length: " . strlen($dados) . "\r\n", 'content' => $dados, 'timeout' => 60 ) );
		$contexto  = stream_context_create($servico);
		
		$nova = file_get_contents("http://dsin.appspot.com/image/service", false, $contexto);
		unset($dados,$servico,$contexto);
		if ($nova) {
			
			$velha = file_get_contents($arquivo);
			file_put_contents($arquivo,$nova);
			unset($nova);
			
			if (!getimagesize($arquivo)) {
				file_put_contents($arquivo,$arquivo_copia);
				unset($arquivo_copia);
			} else {
				$lis_metadata .= lis_formatar_data("size",$size,round(filesize($arquivo)/1024,2));
				$lis_metadata .= lis_formatar_data("method","WebService");
				
				unset($size);
				unset($arquivo_copia);
				return $args;
			}
			
		}
		
		unset($nova);
		
	}
	
	//No Alternative Way. Let's use GD.
	if (function_exists("imagecreatetruecolor")) {
		
		$nova = imagecreatetruecolor($width, $height);
		$qualidade = intval(get_option('lis_quality',"85"));
		if (!$qualidade) $qualidade = 85;
		
		if ($args["type"]=="image/png"){
			$velha = imageCreateFromPng($arquivo);
			
			if ($convert) {
				
				$branco = imagecolorallocate($nova,  255, 255, 255);
				imagefilledrectangle($nova, 0, 0, $width, $height, $branco);
				imagecopyresized($nova, $velha, 0, 0, 0, 0, $width, $height, $imagem[0], $imagem[1]);
				unlink($arquivo);
				$arquivo = substr($arquivo,0,-3)."jpg";
				$args["file"] = $arquivo;
				$args["type"] = "image/jpeg";
				imagejpeg($nova,$arquivo,$qualidade);
			
			} else {
				
				imagealphablending($nova, false);
				imageSaveAlpha($nova, true);
				imagecopyresized($nova, $velha, 0, 0, 0, 0, $width, $height, $imagem[0], $imagem[1]);				
				imagepng($nova,$arquivo,9);
			
			}
			
		} else {
			
			$velha = imagecreatefromjpeg($arquivo);
			imagecopyresized($nova, $velha, 0, 0, 0, 0, $width, $height, $imagem[0], $imagem[1]);
			imagejpeg($nova,$arquivo,$qualidade);
		
		}
		
		$lis_metadata .= lis_formatar_data("size",$size,round(filesize($arquivo)/1024,2));
		$lis_metadata .= lis_formatar_data("method","GD");
		
		unset($size);
		imagedestroy($nova);
		imagedestroy($velha);
		return $args;
	}
	
	$lis_metadata = false;
	return $args;
}
add_filter("wp_handle_upload","lis_redimensiona_imagem");

function lis_formatar_data($data,$a,$b="0") {
	switch ($data) {
		case "dimension":
			$return = "<tr><td style='font-weight: bold;'>". __("Original Dimension","lis-plugin") ."</td><td>$a</td><td style='font-weight: bold;'>". __("Final Dimension","lis-plugin") ."</td><td>$b</td></tr>";
		break;
		case "megapixels":
			$a = round( ($a/1024)/1024 , 1) . " MP";
			$b = round( ($b/1024)/1024 , 1) . " MP";
			$return = "<tr><td style='font-weight: bold;'>". __("Original MegaPixels","lis-plugin") ."</td><td>$a</td><td style='font-weight: bold;'>". __("Final MegaPixels","lis-plugin") ."</td><td>$b</td></tr>";
		break;
		case "size":
			$a .= " KB";
			$b .= " KB";
			$return = "<tr><td style='font-weight: bold;'>". __("Original Size","lis-plugin") ."</td><td>$a</td><td style='font-weight: bold;'>". __("Final Size","lis-plugin") ."</td><td>$b</td></tr>";
		break;
		default:
			$return = "<tr><td style='font-weight: bold;'>". __("Method Used","lis-plugin") ."</td><td>$a</td></tr>";
	}
	return $return;
}

function lis_adicionar_data($metadata) {
	
	global $lis_metadata;
	
	if ($lis_metadata) {
		global $wpdb;
		
		if (is_multisite()) {
			global $blog_id;
			$table = "wp_".$blog_id."_posts";
		} else 
			$table = "wp_posts";
		
		$id = $wpdb->get_var("SELECT ID FROM $table WHERE guid LIKE '%". $metadata["file"] ."%' LIMIT 1");
		update_post_meta($id, '_lis_resized', $lis_metadata);

	}
	
	return $metadata;
	
}
add_filter("wp_generate_attachment_metadata","lis_adicionar_data");
?>