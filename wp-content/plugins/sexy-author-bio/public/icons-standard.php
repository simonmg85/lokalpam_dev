<?php

foreach ( ($social) as $network => $url ) {

	$cleanNetwork = ucfirst(str_replace("sab", "",$network));

	if ( $network == 'sabemail' && $sabemail ){
		$html .= '<a id="sab-'.$cleanNetwork.'" '.$nofollow.'href="'.$mailto . $url . '" target="' . $settings['link_target'] . '"><img '.$fade.'id="sig-'.$cleanNetwork.'" alt="'.get_the_author().' on '.$cleanNetwork.'" src="'.plugins_url( $path, $plugin ).'/sexy-author-bio/public/assets/images/'.$iconset.'/'.$network.'.png"></a>';
	}
	else if ( $url && strpos($url, 'http://') !== false || strpos($url, 'https://') !== false && strpos($url, 'mailto') !== true ){
		$html .= '<a id="sab-'.$cleanNetwork.'" '.$nofollow.'href="' . $url . '" target="' . $settings['link_target'] . '"><img '.$fade.'id="sig-'.$cleanNetwork.'" alt="'.get_the_author().' on '.$cleanNetwork.'" src="'.plugins_url( $path, $plugin ).'/sexy-author-bio/public/assets/images/'.$iconset.'/'.$network.'.png"></a>';
	}
	else if ( $url ){
		$html .= '<a id="sab-'.$cleanNetwork.'" '.$nofollow.'href="//' . $url . '" target="' . $settings['link_target'] . '"><img '.$fade.'id="sig-'.$cleanNetwork.'" alt="'.get_the_author().' on '.$cleanNetwork.'" src="'.plugins_url( $path, $plugin ).'/sexy-author-bio/public/assets/images/'.$iconset.'/'.$network.'.png"></a>';
	}
}

?>