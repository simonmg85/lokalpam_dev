<?php

foreach ( ($social) as $network => $url ) {

	$cleanNetwork = ucfirst(str_replace("sab", "",$network));

	if ( $network == 'sabemail' && $sabemail ){
		$output['content'] .= '<a id="sab-'.$network.'" '.$nofollow.'href="'.$mailto. $url . '" target="' . $settings['link_target'] . '"><img '.$fade.'id="sig-'.$network.'" alt="' . $sab_coauthor->display_name . ' on '.$cleanNetwork.'" src="'.plugins_url( $path, $plugin ).'/sexy-author-bio/public/assets/images/'.$iconset.'/'.$network.'.png"></a>';
	}
	else if ( $url && strpos($url, 'http://') !== false || strpos($url, 'https://') !== false && strpos($url, 'mailto') !== true ){
		$output['content'] .= '<a id="sab-'.$network.'" '.$nofollow.'href="' . $url . '" target="' . $settings['link_target'] . '"><img '.$fade.'id="sig-'.$network.'" alt="' . $sab_coauthor->display_name . ' on '.$cleanNetwork.'" src="'.plugins_url( $path, $plugin ).'/sexy-author-bio/public/assets/images/'.$iconset.'/'.$network.'.png"></a>';
	}
	else if ( $url ){
		$output['content'] .= '<a id="sab-'.$network.'" '.$nofollow.'href="//' . $url . '" target="' . $settings['link_target'] . '"><img '.$fade.'id="sig-'.$network.'" alt="' . $sab_coauthor->display_name . ' on '.$cleanNetwork.'" src="'.plugins_url( $path, $plugin ).'/sexy-author-bio/public/assets/images/'.$iconset.'/'.$network.'.png"></a>';
	}

}

?>