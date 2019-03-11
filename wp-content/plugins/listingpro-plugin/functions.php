<?php 
/* ============== ListingPro Currency sign ============ */
class ListingproPlugin{
	
}
	add_action( 'admin_enqueue_scripts', 'listingpro_load_media' );
	if (!function_exists('listingpro_currency_sign')) {

		function listingpro_currency_sign() {
			$currency_code = '';
			$currencycode = '';
			global $listingpro_options;
			if(isset($listingpro_options)){
				$currency_code = $listingpro_options['currency_paid_submission'];
				if($currency_code == "USD") {
					$currencycode = "$";
				} elseif($currency_code == "BDT") {
					$currencycode = "৳";
				} elseif($currency_code == "TTD") {
					$currencycode = "TT$";
				} elseif($currency_code == "AUD") {
					$currencycode = "$";
				} elseif($currency_code == "AED") {
					$currencycode = "د.إ";
				} elseif($currency_code == "CAD") {
					$currencycode = "$";
				} elseif($currency_code == "CZK") {
					$currencycode = "Kč";
				} elseif($currency_code == "DKK") {
					$currencycode = "kr";
				} elseif($currency_code == "EUR") {
					$currencycode = "€";
				}elseif($currency_code == "EGP") {
                    $currencycode = "E£";
				}elseif($currency_code == "HKD") {
					$currencycode = "$";
				} elseif($currency_code == "HUF") {
					$currencycode = "Ft";
				} elseif($currency_code == "JPY") {
					$currencycode = "¥";
				} elseif($currency_code == "NOK") {
					$currencycode = "kr";
				} elseif($currency_code == "NZD") {
					$currencycode = "$";
				} elseif($currency_code == "PLN") {
					$currencycode = "zł";
				} elseif($currency_code == "GBP") {
					$currencycode = "£";
				} elseif($currency_code == "SEK") {
					$currencycode = "kr";
				} elseif($currency_code == "SGD") {
					$currencycode = "$";
				} elseif($currency_code == "CHF") {
					$currencycode = "CHF";
				} elseif($currency_code == "BRL") {
					$currencycode = "R$";
				} elseif($currency_code == "IDR") {
					$currencycode = "Rp";
				} elseif($currency_code == "ILS") {
					$currencycode = "₪";
				} elseif($currency_code == "INR") {
					$currencycode = "INR";
				} elseif($currency_code == "KOR") {
					$currencycode = "₩";
				} elseif($currency_code == "KSH") {
					$currencycode = "KSh";
				} elseif($currency_code == "MYR") {
					$currencycode = "RM";
				} elseif($currency_code == "MXN") {
					$currencycode = "$";
				} elseif($currency_code == "PHP") {
					$currencycode = "₱";
				} elseif($currency_code == "TWD") {
					$currencycode = "NT$";
				} elseif($currency_code == "THB") {
					$currencycode = "฿";
				} elseif($currency_code == "VND") {
					$currencycode = "₫";
				} elseif($currency_code == "ALL") {
					$currencycode = "Lek";
				} elseif($currency_code == "AFN") {
					$currencycode = "؋";
				} elseif($currency_code == "ARS") {
					$currencycode = "$";
				} elseif($currency_code == "AWG") {
					$currencycode = "ƒ";
				} elseif($currency_code == "AZN") {
					$currencycode = "ман";
				} elseif($currency_code == "BYN") {
					$currencycode = "Br";
				} elseif($currency_code == "BZD") {
					$currencycode = "BZ$";
				} elseif($currency_code == "BMD") {
					$currencycode = "$";
				} elseif($currency_code == "BOB") {
					$currencycode = "$b";
				} elseif($currency_code == "BAM") {
					$currencycode = "KM";
				} elseif($currency_code == "BWP") {
					$currencycode = "P";
				} elseif($currency_code == "BGN") {
					$currencycode = "лв";
				} elseif($currency_code == "BRL") {
					$currencycode = "R$";
				} elseif($currency_code == "BND") {
					$currencycode = "BND";
				} elseif($currency_code == "KHR") {
					$currencycode = "KHR";
				} elseif($currency_code == "KYD") {
					$currencycode = "$";
				} elseif($currency_code == "CLP") {
					$currencycode = "$";
				} elseif($currency_code == "CNY") {
					$currencycode = "¥";
				} elseif($currency_code == "COP") {
					$currencycode = "$";
				} elseif($currency_code == "CRC") {
					$currencycode = "₡";
				} elseif($currency_code == "HRK") {
					$currencycode = "kn";
				} elseif($currency_code == "CUP") {
					$currencycode = "₱";
				} elseif($currency_code == "DOP") {
					$currencycode = "RD$";
				} elseif($currency_code == "XCD") {
					$currencycode = "$";
				} elseif($currency_code == "EGP") {
					$currencycode = "£";
				} elseif($currency_code == "SVC") {
					$currencycode = "$";
				} elseif($currency_code == "FKP") {
					$currencycode = "£";
				} elseif($currency_code == "FJD") {
					$currencycode = "$";
				} elseif($currency_code == "GHS") {
					$currencycode = "GH₵";
				} elseif($currency_code == "GIP") {
					$currencycode = "£";
				} elseif($currency_code == "GTQ") {
					$currencycode = "Q";
				} elseif($currency_code == "GGP") {
					$currencycode = "£";
				} elseif($currency_code == "GYD") {
					$currencycode = "$";
				} elseif($currency_code == "HNL") {
					$currencycode = "L";
				} elseif($currency_code == "IMP") {
					$currencycode = "£";
				} elseif($currency_code == "JEP") {
					$currencycode = "£";
				} elseif($currency_code == "KZT") {
					$currencycode = "лв";
				} elseif($currency_code == "KPW") {
					$currencycode = "₩";
				} elseif($currency_code == "KRW") {
					$currencycode = "₩";
				} elseif($currency_code == "KGS") {
					$currencycode = "лв";
				} elseif($currency_code == "LAK") {
					$currencycode = "₭";
				} elseif($currency_code == "LBP") {
					$currencycode = "£";
				} elseif($currency_code == "LRD") {
					$currencycode = "$";
				} elseif($currency_code == "MKD") {
					$currencycode = "ден";
				} elseif($currency_code == "MUR") {
					$currencycode = "₨";
				} elseif($currency_code == "MXN") {
					$currencycode = "$";
				} elseif($currency_code == "MNT") {
					$currencycode = "₮";
				} elseif($currency_code == "MZN") {
					$currencycode = "MT";
				} elseif($currency_code == "NAD") {
					$currencycode = "$";
				} elseif($currency_code == "NPR") {
					$currencycode = "₨";
				} elseif($currency_code == "ANG") {
					$currencycode = "ƒ";
				} elseif($currency_code == "NIO") {
					$currencycode = "C$";
				} elseif($currency_code == "NGN") {
					$currencycode = "₦";
				} elseif($currency_code == "NOK") {
					$currencycode = "kr";
				} elseif($currency_code == "OMR") {
					$currencycode = "﷼";
				} elseif($currency_code == "PKR") {
					$currencycode = "₨";
				} elseif($currency_code == "PAB") {
					$currencycode = "B/.";
				} elseif($currency_code == "PYG") {
					$currencycode = "Gs";
				} elseif($currency_code == "PEN") {
					$currencycode = "S/.";
				} elseif($currency_code == "QAR") {
					$currencycode = "﷼";
				} elseif($currency_code == "RON") {
					$currencycode = "lei";
				} elseif($currency_code == "RUB") {
					$currencycode = "₽";
				} elseif($currency_code == "SHP") {
					$currencycode = "£";
				} elseif($currency_code == "SAR") {
					$currencycode = "﷼";
				} elseif($currency_code == "RSD") {
					$currencycode = "Дин.";
				} elseif($currency_code == "SCR") {
					$currencycode = "₨";
				} elseif($currency_code == "SGD") {
					$currencycode = "$";
				} elseif($currency_code == "SBD") {
					$currencycode = "$";
				} elseif($currency_code == "SOS") {
					$currencycode = "S";
				} elseif($currency_code == "ZAR") {
					$currencycode = "R";
				} elseif($currency_code == "LKR") {
					$currencycode = "₨";
				} elseif($currency_code == "SRD") {
					$currencycode = "$";
				} elseif($currency_code == "SYP") {
					$currencycode = "£";
				} elseif($currency_code == "TTD") {
					$currencycode = "TT$";
				} elseif($currency_code == "TVD") {
					$currencycode = "$";
				} elseif($currency_code == "UAH") {
					$currencycode = "₴";
				} elseif($currency_code == "UYU") {
					$currencycode = "$U";
				} elseif($currency_code == "UZS") {
					$currencycode = "лв";
				} elseif($currency_code == "VEF") {
					$currencycode = "Bs";
				} elseif($currency_code == "VND") {
					$currencycode = "₫";
				} elseif($currency_code == "YER") {
					$currencycode = "﷼";
				} elseif($currency_code == "ZWD") {
					$currencycode = "Z$";
				} elseif($currency_code == "TRY") {
					$currencycode = "&#8378;";
				} 				
			}
			return $currencycode;
		}
	}

	
	
	
	/* ============== ListingPro Icon8 SVG ============ */
	
	if (!function_exists('listingpro_icon8')) {

		function listingpro_icon8($icon) {
			$output = '';
			  if($icon == 'checked'){
				$output = '
												<img class="icon icons8-Checked" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAFLklEQVRoQ+1azXHbOBT+nm/2Zb0VREgDUSow1IF9DHWwXYG1FaxTQZIKohykHC1XIGwFtiuAXEHsS7wnv50HghRJgSQoMc5OJpzxjDwEQXzv53sfHkj4RS76RXDgN5CQJ0dze8QEDXZ/h0QYZuOYcQvCg/ufYPCMazNWt31FxM4e0V+txjNOiXDWdVEMrMAw2MMX806Zrs8Xx28NRM/tMYALAnRhwjsGZEEGjFXR4npmh9jDoXgKgCbmYxC9yj0mzxDebwuoMxD91Q7A+JwDYL5n0BR7mJp3atXFqg4ccEzEE4D+kGedIfZxYk5UGoaRVycgzgsCgsSq/MigS5Ooj5Hvqh2mr+whvmOSAfIhd1LNIRlXBzAaiJ7ZCyK4RTPjGgc462q1NsCyUHpyofnGv+fcjNVUfuuZlRz8AGAUIokoIHpmxQsumRn4qw8vNIHSc/uRgAtmvJVFC6EQY1kF1ynZ9dxOyFmCH5lpklmozbq73pdclJzzebSUcGbGezNWl6G5Gz0iOUHAVZMldl1wo2fS3BEQQwa+mETVUnwtEMdOz7hxlniBcAoB0jMr7xdmu+N96KacrAcyt0uhWElsM1ZSM170yvNS6P2AhgJCcqWuzgSBrEOKH3mfBn2zU5tFKnmpiwnPhFEITB2Q1Bs/IaSEZonw2TPkiUnUwtPvJRH+loJpEjWqGmMDSE51zPfL8etBm/X6vF9hqLyGOCCuxvBKFEDIK5tA5nZKwGkT1fW5+GyuCrkEGUrPbOaVjfsbQEZzy86tBNVVO20L0EsUR7MA/lkmqihE82kFLDEsMx5wAFXM3RKQQt24WyYq30tsu8DY5/TcXhEgzNhKs6O5lT3Mm2p4lYGsXffJJGoSu5Bdxq3lDz8y0bAtCgrypVTlS0BGcyuC7YiBnC12WWTbs2uGcvLH0WzsM9X6VvWIq6SZWGubdJf7MUIwWO3XArKUS1WPuERfJipaFUtydhWSsUIwCCSV+t8k4c1Y/ZmN2RpIqXAxSpzfKgSfcEPAoE0I1s2TMWvR4FsD8dV2XYUZIvE/tYVbUQhuy4y9AwmAmZqxOq8DExKCbcBD92OApBztd2axL6mEWRBMVpX9Bi2KoYI5MrNDItxIzSl6tDf6TVmIF04LMUpgSkBr1Gu00dabvXrWKmiZrQqisBERGwfGt3XwHQNvQWlaRJNCbXiu9/P1BTHjdmlvmrF6G2ul4rgSGGmTwgGRXWbjVjX2XRlZNEoUmawP0ZiCgbRxsrZOL7vMTDRKni2T19KxzK8fJuMLPSq07bc7eCNexufhBaxMolTsS+qqMP7FYZsQjH2HntlvLkwDhBGUIgXx+MObcdEg8v5aeL/S2HwIbWBiX9znOL/xsnXekHfVisOCVxYmUSd9LqzrXNnGq6k11digI+ZbXxN+WoiVWkMNG6//d8u0pjUU8mjrviOziMsX6XP5Nn/X8Og6vtLfao2IViBO4foWkfzmSLnedeEVdbA+i4lUBFFAPBh/vODOSBbYx3nfrVTHTk/uWM/1mrt0OqOBeDDHBJ56hSuhdhmzmYrxjpyIyXyFY72zrF0a83wnIA5M2iQTHXXkrbZCqqvkiLnbYagcXQCnYJzJ1teH7jX2MOk6V2cgmXV8M096Xw6QX4R8FGCIYRi43zjMFDEJvMo+Kih+UCBNDCZcvtjxdNXN7oOB1KKnMSFQHuNOhhfi0W0BZPNt7ZHQov1XEJrkMw64DwOcjC9cdwAeOP3awey6+OLEvQLp7pH+nvgNpD9b9jPTfwQDNWCupe5qAAAAAElFTkSuQmCC" alt="icon-check" />';
			  }
			 elseif($icon == 'unchecked'){
				$output = '
												<img class="icon icons8-Cancel" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAFCUlEQVRoQ9Va7XEaSRB9g36ZperkCCxFcO0IDkVgK4JDERhFcHIExhFYisAiAuEI3BeBRATHVYH8y9qrt/TgYcXuzi4L4qaKki0ts/2mu19/jUNL64fIyU/gDwDCjwNOsPyE6yEFHgAoP0fAt1eq/P/Wy22zA4V/Av4EMNggdOzWDw4YOWC8DahGQAzAXwYgEzgF/nXAhCfdWf58yAvG7xHwE9Cn1lKg74DfAsTXHeBjE0C1gKQix4/ApxAAgBsAt4nqbawKwucWIu8B8EPN+nXdBS6d6ix2z2ggfGEKfHHAsZ3+qEuTqPGyMqFMy4MUGFJLKTBzwEXsAUUBmYt8csDQBBl3gGET9cecrpHGtVsSB0121FO9rPpuKRCa0gL46oA+tQBg2FO9rtq0jb/PRUggJAFqZ5IA52XaLwRi/nBnTkkQ/Z4qaXNvay5CKp8YIWgXOCsCUwhkLnJHTQD4uwO835UpVZ0KwTiAVvC7kcr5pu9sBDIXoUo/0JyOAHkpEF7gUDMp8Lmn6v11hekZEKPDr+YTezenIg3lzOw8z2ZrQMy5741iL/bl2FXmFWhm4IAvpOYEOA39ZQ3IQoS2yMA0TlQZpA5uzUXo/KTmm0SVzJatFRALSPeH4hdFJ2hxRslkHeDU++8KSKCNj4nq1cGpIhBoIUL5mOuttJIB8drgv7vA69i0YyFyD2BWxu9VBxLEKySqb6uez8vrtZIB2YQwZsOFCAMk+b00WBXtFQZdxqtElQEwankLcsBlV5XhIgPCk2WK/YzWynY1QZiy1waTB9FlSl8jAfVhguVConrqQifvqR5HHUfwUBMw24II6JgZcub0jskZuXkbyq0Dpi0QZkmsgd6lwAWBZOkIgK3YKgZMmyBC32baQiBZgOkAZ69Uae+NVxmYtkEYe/WfgLsU+Oa8o4fBpTESFkLLcniNALjfI5CVBGSnuo5dJI9lxt/p8ASS8sFEGSzbWXkwtmurILykXv6dAOFLcmD4q9Y0ER73voB4c+K7GwXNKhvZKZC8Y5swtYNmFQhjrsw1aFpsWb5p2dnXHNucvVEGUAYmyBGnu6DfjewUE2diNBA+80PkF/22HBBLKbZtMD7Z9QGxrRQlKk60CWYh8itFCZLGWU/1dV31NonYbYGZi/zD/kKWNJrnZw7fMI2P0kT+gLYFE6Tx00T1JAPyKDJMl132tYK+SjsLEaYHjSN2HkxshWiHnzVK1gqrsNStQ8NWIbI8rlUUhQcUgGGaFFUhbpL3f9l8CJh2vflgKTEnSWwHzY6Aty/dJi0ya2sHffdO/qwdFNpdWbO4ym92/fegub65Qecz1gVz++VM4uBapp6U2ERMgJPClqlpha1SNrE5vzvb90ykSKPWxOaogw2S8ia23yQYKxyEv4QgoscKARjfLOa4+fylnN/KWXZ5SM2FzfWq0VuWer+UmeXMqbTCjBmG3rLLYmAu9zUzeRT58ARcmU+Mu8Cg0TA0dLogAHFcPDkCLnZlahYnOM/n/JLv2zhqy5NCdOfELgxw/u2H+aMOcNMWoOBeSzbSsEsJg1YvDHj0lheN8tctLICOmwTDhcg7u8Kxmj4xee3yBkSNpna0RnIlJtMZntzq/ohduVheqnFugjSdbrxU49ybpzQNL9WEjfObDnDVRMuNgHhQNIcU4B0VjotZzzRZU7vmdNsEgH/hVkDyWvpp15eCi2d5cNPcxbPJNsKH7/8PkcItXz99rKgAAAAASUVORK5CYII=" alt="icon-cross" />';
			  }
			  return $output;
			
		}
	}
	
	
	
	
	
	

	
	
	/* ============== ListingPro Author Name ============ */
	
	if (!function_exists('listingpro_author_name')) {

		function listingpro_author_name() {
				 if ( is_user_logged_in() ) {
					$current_user = wp_get_current_user();
					$output = $current_user->user_login; 
				} else {
					$output = '';
				}
				return $output;
			
		}

	}
	
	
	
	
	/* ============== ListingPro Get Metabox ============ */
	
	if (!function_exists('listing_get_metabox')) {
		function listing_get_metabox($name) {
			global $post;
			if ($post) {
				$metabox = get_post_meta($post->ID, 'lp_' . strtolower(THEMENAME) . '_options', true);
				return isset($metabox[$name]) ? $metabox[$name] : "";
			}
			return false;
		}
	}
	
	/* ============== ListingPro Get form fields ============ */
	
	if (!function_exists('listing_get_fields')) {
		function listing_get_fields($name,$post_id) {
			if ($post_id) {
				$metabox = get_post_meta($post_id, 'lp_' . strtolower(THEMENAME) . '_options_fields', true);
				return isset($metabox[$name]) ? $metabox[$name] : "";
			}
			return false;
		}
	}
	
	
	/* ============== ListingPro Get Metabox ============ */
	
	if (!function_exists('listing_get_metabox_by_ID')) {
		function listing_get_metabox_by_ID($name,$postid) {
			if ($postid) {
				$metabox = get_post_meta($postid, 'lp_' . strtolower(THEMENAME) . '_options', true);
				return isset($metabox[$name]) ? $metabox[$name] : "";
			}else{
				return false;
			}
			
		}
	}
	
	
	/* ============== ListingPro Set Metabox ============ */
	
	if (!function_exists('listing_set_metabox')) {
		function listing_set_metabox($name, $val, $postID) {
			if ($postID) {
				$metabox = get_post_meta($postID, 'lp_' . strtolower(THEMENAME) . '_options', true);
				if(!empty($metabox) && is_array($metabox)){
					$metabox[$name] = $val;
				}
				else{
					$metabox = array();
					$metabox[$name] = $val;
				}
				return update_post_meta($postID, 'lp_' . strtolower(THEMENAME) . '_options', $metabox);
			}else{
				return false;
			}
		}
	}
	
	
	/* ============== ListingPro Set Metabox ============ */
	
	if (!function_exists('listing_set_metabox_of_extraFields')) {
		function listing_set_metabox_of_extraFields($name, $val, $postID) {
			if ($postID) {
				$metabox = get_post_meta($postID, 'lp_' . strtolower(THEMENAME) . '_options_fields', true);
				$metabox[$name] = $val;
				return update_post_meta($postID, 'lp_' . strtolower(THEMENAME) . '_options_fields', $metabox);
			}else{
				return false;
			}
		}
	}
	
	/* ============== ListingPro deleted Metabox ============ */
	
	if (!function_exists('listing_delete_metabox')) {
		function listing_delete_metabox($key, $postid) {
			global $post;
			if ($postid) {
				$metabox = get_post_meta($postid, 'lp_' . strtolower(THEMENAME) . '_options', true);
				if (array_key_exists($key, $metabox)) {
					unset($metabox[$key]);
					if(!empty($metabox)){
						return update_post_meta($postid, 'lp_' . strtolower(THEMENAME) . '_options', $metabox);
					}
				}
				else{
					return false;
				}
				
			}else{
				return false;
			}
		}
	}
	
	/* ============== ListingPro get term meta ============ */
	
	if (!function_exists('listingpro_get_term_meta')) {
		function listingpro_get_term_meta( $term_id,$meta_name ) {
		  $value = get_term_meta( $term_id, $meta_name, true );		  
		  return $value;
		}
	}
	
	
	
	/* ============== ListingPro Get taxonomy Meta ============ */

	if (!function_exists('listing_get_tax_meta')) {
		function listing_get_tax_meta($termID,$taxonomy,$meta) {
			if ($termID) {
				$metae = 'lp_'.$taxonomy.'_'.$meta;
				$metad = listingpro_get_term_meta( $termID,$metae);
				return $metad;
			}else{
				return false;
			}
		}
	}
	
	/* ============== ListingPro Features array ============ */
	
	 if (!function_exists('listing_get_feature_array')) {
		function listing_get_feature_array() {
				$cat = array();
				 $ucat = array(
				 'post_type' => 'listing',
				  'hide_empty' => false,
				  'orderby' => 'count',
				  'order' => 'ASC',
				);
				$features = get_terms( 'features',$ucat);

				foreach($features as $feature) {

					$cat[$feature->term_id] = $feature->name;
				} 
				return $cat;
		}
	} 
	
	
	
	/* ============== ListingPro update form field id in listing category ============ */
	

	
	 if (!function_exists('listingpro_update_form_fields_meta_in_listing_categories')) {
		function listingpro_update_form_fields_meta_in_listing_categories($post_id) {
			if(is_admin()){
				$screen = get_current_screen();
				if(!empty($screen)){
					if ( $screen->post_type == 'form-fields' ){
						$cats='';
						$currentPostID = '';
						if(!empty($_POST['post_ID'])){
							$currentPostID = $_POST['post_ID'];
						}				
						
						if(isset($_POST['field-cat']) && !empty($_POST['field-cat'])){
							if(isset($_POST['post_ID'])){
								$currentPostID = $_POST['post_ID'];
							}
							$cats = $_POST['field-cat'];
							foreach($cats as $cat){
								$fieldIDs = listingpro_get_term_meta($cat,'fileds_ids');
								
								if(empty($fieldIDs)){
									$fieldIDs = array();							
								}
								
								if(!in_array($currentPostID,$fieldIDs)){
									array_push($fieldIDs,$currentPostID);
									update_term_meta( $cat, 'fileds_ids', $fieldIDs );							
								}
							}
							implode(',',$cats);
						}
						//if(!empty($cats)){
							$terms = get_terms( 'listing-category', array(
								'hide_empty' => false,
								'exclude' => $cats
							) );
							
							if(!empty($terms)){
								foreach($terms as $term){		
									$fieldIDs = listingpro_get_term_meta($term->term_id,'fileds_ids');
									
									if(!empty($fieldIDs)){
										foreach($fieldIDs as $index => $value)
										{
											if($currentPostID == $value)
											{
												unset($fieldIDs[$index]);
												/* echo $index;
												echo $value; */
												
												
											}
										}
										update_term_meta( $term->term_id, 'fileds_ids', $fieldIDs );	
										
									}
								}
								
								
							}
							
						//}
					}
				}
			
			}
		}
		add_action( 'save_post', 'listingpro_update_form_fields_meta_in_listing_categories' );
	}
	
	/* ============== ListingPro update features in listing post ============ */
	
	 if (!function_exists('listingpro_update_features_in_list')) {
		function listingpro_update_features_in_list($post_id) {
			if(is_admin()){
				require_once(ABSPATH . 'wp-admin/includes/screen.php');
				$screen = get_current_screen();				
				if (!empty($screen)){
					if ( $screen->post_type == 'listing' ){
						if(isset($_POST['lp_form_fields_inn']) && !empty($_POST['lp_form_fields_inn']['lp_feature']) && isset($_POST['post_ID'])){
							wp_set_post_terms($_POST['post_ID'], $_POST['lp_form_fields_inn']['lp_feature'], 'features');
						}
						 if(!isset($_POST['lp_form_fields_inn']['lp_feature']) && empty($_POST['lp_form_fields_inn']['lp_feature']) && isset($_POST['post_ID'])){		
						
							wp_delete_object_term_relationships( $_POST['post_ID'], 'features' );
						}
					}
				}
			}
			
		}
		add_action( 'save_post', 'listingpro_update_features_in_list' );
	}
	
	
	/* ============== ListingPro Features array ============ */
	
	 if (!function_exists('listing_get_cat_array')) {
		function listing_get_cat_array() {
				$cat = array();
				 $ucat = array(
				 'post_type' => 'listing',
				  'hide_empty' => false,
				  'orderby' => 'count',
				  'order' => 'ASC',
				);
				$features = get_terms( 'listing-category',$ucat);

				foreach($features as $feature) {

					$cat[$feature->term_id] = $feature->name;
				} 
				return $cat;
		}
	}
	
	
	
	/* ============== ListingPro Custom post type columns ============ */
	
	if (!function_exists('listing_columns')) {
		function listing_columns($columns) {
			return array(
				'cb' => '<input type="checkbox" />',			
				'title' => esc_html__('Title','listingpro-plugin'),			
				'listing-category' => esc_html__('Listing Category','listingpro-plugin'),
				'location' => esc_html__('Location','listingpro-plugin'),
				'features' => esc_html__('Features','listingpro-plugin'),
				'expires' => esc_html__('Expire After','listingpro-plugin'),
				'status' => esc_html__('Payment Status','listingpro-plugin'),
				'author' => esc_html__('Author','listingpro-plugin'),
				'date' => esc_html__('Date','listingpro-plugin')
			);
		}
		add_filter('manage_listing_posts_columns' , 'listing_columns');
	}
	
	

	
	if (!function_exists('listingpro_columns_content')) {
		function listingpro_columns_content($column_name, $post_ID) {
			if ($column_name == 'listing-category') {
				$term_list = wp_get_post_terms($post_ID, 'listing-category', array("fields" => "names"));
				foreach($term_list as $list) {
					echo $list.',';
				}
			}
			if ($column_name == 'location') {
				$term_list = wp_get_post_terms($post_ID, 'location', array("fields" => "names"));
				foreach($term_list as $list) {
					echo $list.',';
				}
			}
			if ($column_name == 'features') {
				$terms = get_the_terms( $post_ID, 'features' );
				if(!empty($terms)){
					foreach ($terms as $term) {
						 echo $term->name;
					 }
				}
				 
			}
			if ($column_name == 'expires') {
				//$listing_days  = listing_get_metabox_by_ID('listing_duration', $post_ID);
				$listing_status = get_post_status( $post_ID );
				$Plan_id = listing_get_metabox_by_ID('Plan_id', $post_ID);
				$plan_time  = get_post_meta($Plan_id, 'plan_time', true);
				if(!empty($Plan_id) && $listing_status=="publish"){
					if( !empty($plan_time) ){
						$startdate = get_the_time('d-m-Y');

						$endDate = date('d-m-Y', strtotime($startdate. ' + '.$plan_time.' days'));		
						$diff = (strtotime($endDate) - time()) / 60 / 60 / 24;

						if ($diff < 1 && $diff > 0) {
							$days = 1;
							echo esc_html($days).esc_html__(' Days Left','listingpro-plugin');
						} else {
							$days = floor($diff);
							if($days > 0){
								echo esc_html($days).esc_html__(' Days Left','listingpro-plugin');
							}
						}
					}else{
						$days = esc_html__('Unlimited','listingpro-plugin');
						echo esc_html($days).esc_html__(' Days Left','listingpro-plugin');
					}
				}
				 
			}
			if ($column_name == 'status') {
				
				 echo lp_get_payment_status_column($post_ID);
			}
		}
		add_action('manage_listing_posts_custom_column', 'listingpro_columns_content', 10, 2);
	}
	
	
	/* ============== ListingPro Frontend Uplaod ============ */
	
	if (!function_exists('listingpro_handle_attachment')) {
		function listingpro_handle_attachment($file_handler,$post_id,$set_thu=false) {
			// check to make sure its a successful upload
			if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

			require_once(ABSPATH . "wp-admin" . '/includes/image.php');
			require_once(ABSPATH . "wp-admin" . '/includes/file.php');
			require_once(ABSPATH . "wp-admin" . '/includes/media.php');

			$attach_id = media_handle_upload( $file_handler, $post_id );

				 // If you want to set a featured image frmo your uploads. 
			if ($set_thu) set_post_thumbnail($post_id, $attach_id);
			return $attach_id;
		}
	}
	

	
	/* ============== ListingPro Frontend Uplaod Featured image ============ */
	
	if (!function_exists('listingpro_handle_attachment_featured')) {
		function listingpro_handle_attachment_featured($file_handler,$post_id) {

			require_once(ABSPATH . "wp-admin" . '/includes/image.php');
			require_once(ABSPATH . "wp-admin" . '/includes/file.php');
			require_once(ABSPATH . "wp-admin" . '/includes/media.php');

			$attach_id = media_handle_upload( $file_handler, $post_id );

			set_post_thumbnail($post_id, $attach_id);
			return $attach_id;
		}
	}
	

	
	
	/* ============== ListingPro get child term (tags) ============ */
	
	if (!function_exists('listingpro_child_term_method')) {
		
		
		function listingpro_child_term_method(){
			global $listingpro_options;
			wp_register_script('ajax-term-script', plugins_url( '/assets/js/child-term.js', __FILE__ ), array('jquery') ); 
			wp_enqueue_script('ajax-term-script');

			wp_localize_script( 'ajax-term-script', 'ajax_term_object', array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			));

			// Enable the user with no privileges to run ajax_login() in AJAX
			
		}
		if(!is_admin()){

				add_action('wp_enqueue_scripts', 'listingpro_child_term_method');
			
		}
	}
	
	add_action('wp_ajax_ajax_term',        'ajax_term');
	add_action('wp_ajax_nopriv_ajax_term', 'ajax_term');
	function ajax_term(){

		// Nonce is checked, get the POST data and sign user on
		$term_id = $_POST['term_id'];
		
		$listingid = '';
		$metaFields = array();
		if(isset($_POST['listing_id'])){
			if(!empty($_POST['listing_id'])){
				$listingid = $_POST['listing_id'];
				$metaFields = get_post_meta( $listingid, 'lp_'.strtolower(THEMENAME).'_options_fields', true);
			}
		}
		$output = null;
		$tid = null;
		$hasFeatures = false;
		$hasFields = false;
		$termNameArray = array();
		$termFieldsArray = array();
		$lpselectedtags = array();
		$fieldIDss = array();
		$allIdsArray = array();
		$featureTitle = '';
		$featureTitle = esc_html__('Select your listing features', 'listingpro-plugin');
		if(!empty($term_id) && is_array($term_id)){
			foreach($term_id as $tid){
				$termdata = get_term_by('id', $tid, 'category');
				$termdataname = $termdata->name;
				$fieldIDs = array();
				$fieldIDs = listingpro_get_term_meta($tid,'fileds_ids');
				if(!empty($fieldIDs)){
					foreach($fieldIDs as $singlefId){
						if(array_search($singlefId, $allIdsArray)){}else{
							$lppoststatus = get_post_status( $singlefId );
							if($lppoststatus=="publish"){
								array_push($allIdsArray,$singlefId);
							}
						}
					}
							
				}
				
				
				$featureName;
				$features = listingpro_get_term_meta($tid,'lp_category_tags');
				
				if(!empty($features)){
					foreach($features as $feature){
						$terms = get_term_by('id', $feature, 'features');
						if(!empty($terms)){
								$featureName[" ".$terms->term_id] = $terms->name;
								
								/* for pre checked tags on edit listing */
								if(!empty($metaFields['lp_feature'])){
									if (in_array($feature, $metaFields['lp_feature'])) {
										$lpselectedtags[$terms->term_id] =  $terms->term_id;
									}
								}
								
						}
					}
					$hasFeatures = true;
				}
				
				
				
			}
			//exit(json_encode($allIdsArray));
			$allIdsArray = array_unique($allIdsArray);
			$fieldIDss[$tid] = $allIdsArray;
			$n=1;
			
			if(is_array($fieldIDss) && count($fieldIDss)>0){
				$publishedFields = array();
				//$fieldIDss = array_unique($fieldIDss);
				foreach($fieldIDss as $fidss){
					if(!empty($fidss)){
						/* $lppoststatus = get_post_status( $lpfid );
						if($lppoststatus=="publish"){ */
							$termFieldsArray[$n]= listingpro_field_type($fidss, $listingid);
							$n++;
							$hasFields = true;
						/* } */
					}
				}
				
			}
			
			
			if(!empty($termFieldsArray)){
				$cnt =1;
				foreach($termFieldsArray as $tf){
					if($cnt==1){
						$output .= '<label for="inputTags" class="featuresBycat">'.esc_html__('Additional Business Info', 'listingpro-plugin').'</label>';
					}
					$output .=$tf;
					$cnt++;
				}
			}
			
			/* sorting feature in assending */
			if(!empty($featureName)){
				asort($featureName);
			}
			$term_group_result = json_encode(array('tags'=>$featureName, 'fields'=>$output, 'hasfeatues'=>$hasFeatures, 'hasfields'=>$hasFields, 'fieldsids'=>$fieldIDs, 'featuretitle'=>$featureTitle, 'lpselectedtags'=>$lpselectedtags));
			//$term_group_result = json_encode($listingpro_tag_groups);
			die($term_group_result);
			
		}else{
			$fieldIDs = listingpro_get_term_meta($term_id,'fileds_ids');
			$fieldsOutput=null;
			if(is_array($fieldIDs) && count($fieldIDs)>0){
				
				$fieldsOutput .= '<label for="inputTags" class="featuresBycat">'.esc_html__('Additional Business Info', 'listingpro-plugin').'</label>';
				$fieldsOutput .= listingpro_field_type($fieldIDs, $listingid);
				$hasFields = true;
			}
			
			else{
				$hasFields = false;
			}
			
			$featureName;
			
			$features = listingpro_get_term_meta($term_id,'lp_category_tags');
			
			if(!empty($features)){
				foreach($features as $feature){
					$terms = get_term_by('id', $feature, 'features');
					if(!empty($terms)){
							$featureName[" ".$terms->term_id] = $terms->name;
					}
				}
				$hasFeatures = true;
			}
			
			//$term_fields = get_option(LiSTINGPRO_FORM_FIELDS);
			//$listingpro_term_fields = $term_fields[$term_id]['listingpro_form_fields'];
			
			
			$term_group_result = json_encode(array('tags'=>$featureName, 'fields'=>$fieldsOutput, 'hasfeatues'=>$hasFeatures, 'hasfields'=>$hasFields, 'fieldsids'=>$fieldIDs, 'featuretitle'=>$featureTitle));
			//$term_group_result = json_encode($listingpro_tag_groups);
			die($term_group_result);
		}
		
	}
	
	
	add_action('wp_ajax_lp_get_fields',        'lp_get_fields');
	add_action('wp_ajax_nopriv_lp_get_fields', 'lp_get_fields');
    if(!function_exists('lp_get_fields')){
        function lp_get_fields(){
            $output = null;
            $featureOutput = null;
            $array='';
            $value='';
            $term_id = $_POST['term_id'];
            $list_id = $_POST['list_id'];
            $featureName = array();
            $featurevalue = array();
            $fieldIDs = array();
            $idcounts = 1;
            $featureMID = 'lp_feature';

            /* for listing whose features are there but not assigned to categories */
            $lpFreetags = get_the_terms( $list_id ,'features');
            $featurevalued= listing_get_fields('lp_feature',$list_id);
            $featurevalue = array_merge($featurevalued, $featurevalue);
            if(!empty($lpFreetags)){
                foreach($lpFreetags as $sngTag) {
                    $featureName[$sngTag->term_id] = $sngTag->name;
                }
            }

            if(empty($term_id)){
                /* for outputing features */
                $settings = Array(
                    'name'          => 'Select Business Features',
                    'id'            => 'lp_form_fields_inn['.$featureMID.']',
                    'type'          => 'checkboxes',
                    'child_of'=> '',
                    'match'=>'',
                    'options'=>$featureName,
                    'value'=>$featurevalue,
                    'std'=>'',
                    'desc' => ''
                );
                ob_start();
                call_user_func('settings_checkboxes', $settings);
                $featureOutput[] .= ob_get_contents();
                ob_end_clean();
                ob_flush();
            }

            //die(json_encode($featureName));

            if(!empty($term_id)){
                foreach($term_id as $tid){
                    $fieldIDss = listingpro_get_term_meta($tid,'fileds_ids');
                    if(!empty($fieldIDss)){
                        foreach($fieldIDss as $singleId){
                            if(!empty($singleId)){
                                $fieldIDs[$idcounts] = $singleId;
                                $idcounts++;
                            }
                        }

                    }
                    $Features = listingpro_get_term_meta( $tid,'lp_category_tags' );

                    $featurevalued= listing_get_fields('lp_feature',$list_id);
                    $featurevalue = array_merge($featurevalued, $featurevalue);

                    if(!empty($Features)){
                        explode(',', $Features);
                        foreach($Features as $Feature){
                            $features = get_term_by('id', $Feature, 'features');
                            $featureName[$features->term_id] = $features->name;
                        }

                    }

                }
                /*
                print_r($fieldIDs);
                exit; */

                /* for outputing features */
                $settings = Array(
                    'name'          => 'Select Business Features',
                    'id'            => 'lp_form_fields_inn['.$featureMID.']',
                    'type'          => 'checkboxes',
                    'child_of'=> '',
                    'match'=>'',
                    'options'=>$featureName,
                    'value'=>$featurevalue,
                    'std'=>'',
                    'desc' => ''
                );
                ob_start();
                call_user_func('settings_checkboxes', $settings);
                $featureOutput[] .= ob_get_contents();
                ob_end_clean();
                ob_flush();
                /* end for outputing features */
                /* for form fields */
                if(!empty($fieldIDs)){
                    $type = 'form-fields';
                    $args=array(
                        'post_type' => $type,
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'post__in'         => $fieldIDs,

                    );
                    $my_query = null;

                    $my_query = new WP_Query($args);


                    if( $my_query->have_posts() ) {
                        while ($my_query->have_posts()) : $my_query->the_post();
                            global $post;
                            $options='';
                            $array= null;

                            $type = listing_get_metabox('field-type');

                            if(isset($list_id) && !empty($list_id)){
                                $value = listing_get_fields($post->post_name,$list_id);
                            }



                            if($type=='radio'){
                                $options = listing_get_metabox('radio-options');
                            }elseif($type=='select'){
                                $options = listing_get_metabox('select-options');
                            }elseif($type=='checkboxes'){
                                $options = listing_get_metabox('multicheck-options');
                            }
                            if(!empty($options)){
                                $myArray = explode(',', $options);
                                foreach($myArray as $key=>$myAr){
                                    $array[$myAr] = $myAr;
                                }

                            }

                            $settings = Array(
                                'name'          => get_the_title(),
                                'id'            => 'lp_form_fields_inn['.$post->post_name.']',
                                'type'          => $type,
                                'child_of'=> '',
                                'match'=>'',
                                'options'=>$array,
                                'value'=>$value,
                                'std'=>'',
                                'desc' => '',
                                'from' => 'ajax'
                            );
                            ob_start();
                            call_user_func('settings_'.$type, $settings);
                            $output[] .= ob_get_contents();
                            ob_end_clean();
                            ob_flush();
                        endwhile;

                    }
                }
                /* end for form fields */
            }


            $term_group_result = json_encode(array('fields'=>$output,'features'=>$featureOutput));
            die($term_group_result);

        }
    }
	
	/* for open fields ajax */
	add_action('wp_ajax_lp_get_excluded_fields',        'lp_get_excluded_fields');
	add_action('wp_ajax_nopriv_lp_get_excluded_fields', 'lp_get_excluded_fields');
	if (!function_exists('lp_get_excluded_fields')) {
		function lp_get_excluded_fields() {
			$value = '';
			$fieldIDs = array();
			$fieldIDs = listingpro_get_term_openfields(true);
			$lplistingid = $_POST['lplistingid'];
			
			if(!empty($fieldIDs)){
			$type = 'form-fields';
			$args=array(
				'post_type' => $type,
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'post__in'         => $fieldIDs,
				
			);
			$my_query = null;
			
			$my_query = new WP_Query($args);
			

			if( $my_query->have_posts() ) {
				while ($my_query->have_posts()) : $my_query->the_post();
					global $post;
					$options='';
					$array= null;
					
					$type = listing_get_metabox('field-type');
					
					if(isset($lplistingid) && !empty($lplistingid)){
						$value = listing_get_fields($post->post_name,$lplistingid);
					}
					
					
					
					if($type=='radio'){
						$options = listing_get_metabox('radio-options');
					}elseif($type=='select'){
						$options = listing_get_metabox('select-options');
					}elseif($type=='checkboxes'){
						$options = listing_get_metabox('multicheck-options');
					}
					if(!empty($options)){
						$myArray = explode(',', $options);
						foreach($myArray as $key=>$myAr){
							$array[$myAr] = $myAr;
						}
						
					}
					
					$settings = Array(
						'name'          => get_the_title(),
						'id'            => 'lp_form_fields_inn['.$post->post_name.']',
						'type'          => $type,
						'child_of'=> '',
						'match'=>'',
						'options'=>$array,
						'value'=>$value,
						'std'=>'',
						'desc' => '',
						'from' => 'ajax'
						);
					ob_start();
					call_user_func('settings_'.$type, $settings);
					 $output[] .= ob_get_contents(); 
						ob_end_clean();
						ob_flush();
				endwhile;	
				
			}
		}
		$term_group_result = json_encode(array('fields'=>$output,'features'=>''));
		die($term_group_result);
			
		}
	}
	/* end for open fields ajax */
	
	if (!function_exists('Listingpro_activation')) {
		function Listingpro_activation() {
			$status = get_option( 'theme_activation' );
			if(empty($status) && $status != 'none'){
				update_option( 'theme_activation', 'none' );
			}
			?>
			<div class="notice">
				<form action="" method="post">
					<h2 style="margin-top:0;margin-bottom:5px">Activate Listingpro</h2>
					<p><?php esc_html__('Verify your purchase code to unlock all features, see ', 'listingpro-plugin'); ?><a href="https://docs.listingprowp.com/knowledgebase/how-to-activate-listingpro-theme/" target="_blank"><?php echo esc_html__('instructions', 'listingpro-plugin'); ?></a></p>
					<div id="title-wrap" class="input-text-wrap">
						<label id="title-prompt-text" class="prompt" for="title"> Put here purchase key </label>
						<input id="title" name="key" autocomplete="off" type="text">
					</div>
					<?php echo wp_nonce_field( 'api_nonce', 'api_nonce_field' ,true, false ); ?>
					<input type="submit" name="submit" class="button button-primary button-hero" value="Activate"/>
				</form>
			<?php
			
			if( isset( $_POST['api_nonce_field'] ) &&  wp_verify_nonce( $_POST['api_nonce_field'], 'api_nonce' ) && !empty($_POST['key'])){
				
				$purchase_key = $_POST['key'];
				$item_id = 19386460;
				//'c8f37d37-52e2-4fed-b0ac-e470ba475772'
				$purchase_data = verify_envato_purchase_code( $purchase_key );

				if( isset($purchase_data['verify-purchase']['buyer']) && $purchase_data['verify-purchase']['item_id'] == $item_id) {
					update_option( 'theme_activation', 'activated' );
					echo '<p class="successful"> '.__( 'Valid License Key!', 'sample-text-domain' ).' </p>'; 
				} else{
					echo '<p class="error"> '.__( 'Invalid license key', 'sample-text-domain' ).' </p>'; 
				}
			
				

			}
			echo '</div>';
		}
		$status = get_option( 'theme_activation' );
		if(empty($status) || $status != 'activated'){
			add_action( 'admin_notices', 'Listingpro_activation' );
		}
	}
	function verify_envato_purchase_code($code_to_verify) {
		// Your Username
		$username = 'CridioStudio';
		
		// Set API Key	
		$api_key = 'd22l6udt6rk9s36spidjjlah3nhnxw77';
		
		// Open cURL channel
		$ch = curl_init();
		 
		// Set cURL options
		curl_setopt($ch, CURLOPT_URL, "http://marketplace.envato.com/api/edge/". $username ."/". $api_key ."/verify-purchase:". $code_to_verify .".json");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		   //Set the user agent
		   $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
		   curl_setopt($ch, CURLOPT_USERAGENT, $agent);	 
		// Decode returned JSON
		$output = json_decode(curl_exec($ch), true);
		 
		// Close Channel
		curl_close($ch);
		 
		// Return output
		return $output;
	}

/* ========================= check if category has features or not */
if(!function_exists('lp_category_has_features')){
	function lp_category_has_features($term_id){
		
		$featureshas = false;
		if(!empty($term_id)){
			$termparent = get_term_by('id', $term_id, 'listing-category');
			$parent = $termparent->parent;
		}
		
		$features = listingpro_get_term_meta($term_id,'lp_category_tags');
		if(empty($features)){
			$features = listingpro_get_term_meta($parent,'lp_category_tags');
		}
		if(!empty($features)){
			foreach($features as $feature){
				$terms = get_term_by('id', $feature, 'features');
				if(!empty($terms)){
						$featureshas = true;
				}
			}
		}
		
		if($featureshas==false){
			$fieldIDs = listingpro_get_term_meta($term_id,'fileds_ids');
			if(!empty($fieldIDs)){
				$featureshas = true;
			}
			else{
				$featureshas = false;
			}
		}
		
			
		return $featureshas;
		
	}
}

/*============================= for ajax call all listings ==============================*/
function lp_ajax_callback_listings() {
        // Implement ajax function here
		$all_listings = '';
		$queryy = new WP_Query( array('post_type' => 'listing', 'posts_per_page'	=> -1,  'post_status'=>'publish') );
			if ( $queryy->have_posts() ) {
					while ( $queryy->have_posts() ) {
						$queryy->the_post();
						$all_listings .= '<option value="'.get_the_ID().'">'.get_the_title().'</option>';
					}
			}
			
			$varBack = json_encode($all_listings);
			die($varBack);
    }
add_action( 'wp_ajax_lp_get_all_p_listings', 'lp_ajax_callback_listings' );    // If called from admin panel
add_action( 'wp_ajax_nopriv_lp_get_all_p_listings', 'lp_ajax_callback_listings' );    // If called from front end


/*============================= for dashboard filter options ==============================*/
if(!function_exists('listingpro_filter_listing_by_taxonomies')){
	function listingpro_filter_listing_by_taxonomies( $post_type, $which ) {

		// Apply this only on a specific post type
		if ( 'listing' !== $post_type )
			return;

		// A list of taxonomy slugs to filter by
		$taxonomies = array( 'features', 'listing-category' );

		foreach ( $taxonomies as $taxonomy_slug ) {

			// Retrieve taxonomy data
			$taxonomy_obj = get_taxonomy( $taxonomy_slug );
			$taxonomy_name = $taxonomy_obj->labels->name;

			// Retrieve taxonomy terms
			$terms = get_terms( $taxonomy_slug );

			// Display filter HTML
			echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
			echo '<option value="">' . sprintf( esc_html__( 'Show All %s', 'text_domain' ), $taxonomy_name ) . '</option>';
			foreach ( $terms as $term ) {
				printf(
					'<option value="%1$s" %2$s>%3$s (%4$s)</option>',
					$term->slug,
					( ( isset( $_GET[$taxonomy_slug] ) && ( $_GET[$taxonomy_slug] == $term->slug ) ) ? ' selected="selected"' : '' ),
					$term->name,
					$term->count
				);
			}
			echo '</select>';
		}

	}
}
add_action( 'restrict_manage_posts', 'listingpro_filter_listing_by_taxonomies' , 10, 2);


/*===================function for insert metabox in listing creation ===================*/
if(!function_exists('lp_listing_save_additional_metas')){
    function lp_listing_save_additional_metas($plan_id, $listingid){
        $planmetaArray = array();
        if(!empty($plan_id) && !empty($listingid) ){
            if($plan_id != "none"){

                $planmetaArray['price'] = get_post_meta($plan_id, 'plan_price',true);
                $planmetaArray['menu'] = get_post_meta($plan_id, 'listingproc_plan_menu',true);
                $planmetaArray['announcment'] = get_post_meta($plan_id, 'listingproc_plan_announcment',true);
                $planmetaArray['deals'] = get_post_meta($plan_id, 'listingproc_plan_deals',true);
                $planmetaArray['competitor_campaigns'] = get_post_meta($plan_id, 'listingproc_plan_campaigns',true);
                $planmetaArray['events'] = get_post_meta($plan_id, 'lp_eventsplan',true);
                update_post_meta($listingid, 'listing_plan_data', $planmetaArray);
            }
        }
    }
}

/*===================function for lisitng to check if actions allowed ===================*/
if(!function_exists('lp_validate_listing_action')){
    function lp_validate_listing_action($listingid, $action){
        $pLan_Id = listing_get_metabox_by_ID( 'Plan_id', $listingid );

        if( $action == 'price' )
        {
            $p_action =   'plan_price';
        }elseif ( $action == 'menu' )
        {
            $p_action =   'listingproc_plan_menu';
        }elseif ( $action == 'announcment' )
        {
            $p_action =   'listingproc_plan_announcment';
        }elseif ( $action == 'deals' )
        {
            $p_action =   'listingproc_plan_deals';
        }elseif ( $action   == 'competitor_campaigns' )
        {
            $p_action =   'listingproc_plan_campaigns';
        }elseif ( $action == 'events' )
        {
            $p_action =   'lp_eventsplan';
        }
        if(isset($pLan_Id)){
            if($pLan_Id!="none"){
                $plans_meta = get_post_meta($pLan_Id, $p_action, true);
                if( $plans_meta == 'false' )
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }else{
                return false;
            }
        }
        return true;
    }
}

/* ================function for filtering backend invoices====================== */
if(!function_exists('lp_filter_backend_invoice')){
    function lp_filter_backend_invoice(){
        $method = $_POST['method'];
        $status = $_POST['status'];
        $where = 'WHERE ';
        if( !empty($method) && !empty($status) ){
            $where .="payment_method='$method' AND status='$status'";
        }elseif(!empty($method)){
            $where .="payment_method='$method'";
        }elseif(!empty($status)){
            $where .="status='$status'";
        }elseif( empty($method) && empty($status) ){
			$where ="";
		}

        global $wpdb;
        $counter = 1;
        $table = "listing_orders";
        $dbprefix = $wpdb->prefix;
        $table =$dbprefix.$table;
        $results = array();
        $htmlReturn = null;
        if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table) {
            $query = "";
            $query = "SELECT * from $table  $where ORDER BY main_id DESC";
            $results = $wpdb->get_results( $query);
        }
        if(!empty($results)){
            foreach($results as $Index=>$Value){
				$main_id = $Value->main_id;
                $classStatus = '';
                $textStatus = '';
                $invoiceStatus = $Value->status;
                if($invoiceStatus =="success"){
                    $classStatus = 'success';
                    $textStatus = esc_html__('Active', 'listingpro-plugin');
                }elseif($invoiceStatus =="failed"){
                    $classStatus = 'danger';
                    $textStatus = esc_html__('Failed', 'listingpro-plugin');
                }elseif($invoiceStatus =="pending" || $invoiceStatus =="in progress" ){
                    $classStatus = 'info';
                    $textStatus = esc_html__('Pending', 'listingpro-plugin');
                }
                $htmlReturn .='<tr>';
                $htmlReturn .='<th scope="row" class="check-column">			
																<input type="checkbox">
															</th>';
                $htmlReturn .='<td class="manage-column column-categories">'.$Value->order_id.'</td>';
                $htmlReturn .='<td class="manage-column column-categories">'. date(get_option('date_format'), strtotime($Value->date)).'</td>';
                $htmlReturn .='<td class="manage-column column-categories">'.$Value->payment_method.'</td>';
                $htmlReturn .='<td class="manage-column column-categories">'.$Value->price.$Value->currency.'</td>';
				$buttunType = 'button';
				if($Value->payment_method=="wire"){
					
					$buttunType = 'submit';
					
					$htmlReturn .= '
						
						<td>
							<form class="posts-filter" method="POST">
								<input class="alert alert-'.$classStatus.'" type="'.$buttunType.'" value="'.$textStatus.'" >
								<input type="hidden" name="payment_submitt" value="proceed">
								<input type="hidden" name="order_id" value="'.$Value->order_id.'">
								<input type="hidden" name="post_id" value="'.$Value->post_id.'">
							</form>
						</td>
						
						';
						
				}else{
					$htmlReturn .='<td><input class="alert alert-'.$classStatus.'" type="'.$buttunType.'" value="'.$textStatus.'" ></td>';
				}
				$htmlReturn .='
							<td>
							<form class="wp-core-ui" method="post">
								<input type="submit" name="delete_invoice" class="button action" value="'.esc_html__('Delete', 'listingpro-plugin') .'" onclick="return window.confirm("Are you sure you want to proceed action?")" />
								<input type="hidden" name="main_id" value="'.$main_id.'" />
							</form>
																
						</td>';
                $htmlReturn .='</tr>';
            }
			

        }else{
            $htmlReturn = '<p style="width: 98%;position: absolute;padding: 20px;font-size: 16px;text-align: center;">'.esc_html__("Sorry! there is no result", "listingpro-plugin").'</p>';
        }

        exit(json_encode($htmlReturn));
    }
}

add_action( 'wp_ajax_lp_filter_backend_invoice', 'lp_filter_backend_invoice' );    // If called from admin panel
add_action( 'wp_ajax_nopriv_lp_filter_backend_invoice', 'lp_filter_backend_invoice' );    // If called from front end


if(!function_exists('lp_theme_option')){
    function lp_theme_option($optionID){
        global $listingpro_options;
        if(isset($listingpro_options["$optionID"])){
            $optionValue = $listingpro_options["$optionID"];
            return $optionValue;
        }else{
            return false;
        }
    }
	
}


add_action('wp_ajax_lp_get_child_cats', 'lp_get_child_cats');
add_action('wp_ajax_nopriv_lp_get_child_cats', 'lp_get_child_cats');
if( !function_exists( 'lp_get_child_cats' ) )
{
    function lp_get_child_cats()
    {
        $parentID   =   $_POST['parentID'];
        $markup     =   '';
        $child_terms = get_terms('listing-category', array('hide_empty' => false, 'parent' => $parentID ));
        if( $child_terms )
        {
            foreach ( $child_terms as $child_term )
            {
                $markup .=  '<label class="vc_checkbox-label"><input id="child_category_ids-'. $child_term->term_id .'" value="'. $child_term->term_id .'" class="wpb_vc_param_value child_category_ids checkbox" type="checkbox" name="child_category_ids"> '. $child_term->name .'</label>';
            }
        }
        $json_attr  =   'json';
        $child_cats_result = json_encode(array('markup'=>$markup,'json_attr'=>$json_attr));
        die($child_cats_result);
    }
}


/* =============== for admin invoice details================ */
add_action('wp_ajax_lp_get_admin_invoice_details', 'lp_get_admin_invoice_details');
add_action('wp_ajax_nopriv_lp_get_admin_invoice_details', 'lp_get_admin_invoice_details');
if( !function_exists( 'lp_get_admin_invoice_details' ) ){
	function lp_get_admin_invoice_details(){
		global $wpdb;
		$invoiceid   =   $_POST['invoiceid'];
		$dbprefix = $wpdb->prefix;
		$myInvoice = $wpdb->get_row( "SELECT * FROM ".$dbprefix."listing_orders WHERE main_id = $invoiceid" );

		$firstName = '';
		$lastName = '';
		$listingName = '';
		$price = '';
		$currency = '';
		$paymentMethod = '';
		$transactionID = '';

		if(!empty($myInvoice)){
			$userID = $myInvoice->user_id;
			$author_obj = get_user_by('id', $userID);
			$firstName = $author_obj->first_name;
			$lastName = $author_obj->last_name;
			$listingID = $myInvoice->post_id;
			$listingName = get_the_title($listingID);
			$price = $myInvoice->price;
			$paymentMethod = $myInvoice->payment_method;
			$transactionID = $myInvoice->order_id;
			$currency = $myInvoice->currency;
		}

		$output = null;
		$output = '
					
					<button style="display:none" type="button" class="btn btn-info btn-lg lpinvoiceadminpop" data-toggle="modal" data-target="#lpinvoiceadminpop"></button>

					<!-- Modal -->
					<div id="lpinvoiceadminpop" class="modal fade" role="dialog">
					  <div class="modal-dialog">

						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">'.esc_html__('Invoice Summary', 'listingpro-plugin').'</h4>
						  </div>
						  <div class="modal-body">
							<div class="row">
								<div class="col-xs-12">
									<div class="row">
										<div class="col-xs-6">'.esc_html__('First Name', 'listingpro-plugin').'</div>
										<div class="col-xs-6 text-right">'.$firstName.'</div>
										<div class="clearfix"></div>
										
										<div class="col-xs-6">'.esc_html__('Last Name', 'listingpro-plugin').'</div>
										<div class="col-xs-6 text-right">'.$lastName.'</div>
										<div class="clearfix"></div>
										
										<div class="col-xs-6">'.esc_html__('Listing Name', 'listingpro-plugin').'</div>
										<div class="col-xs-6 text-right">'.$listingName.'</div>
										<div class="clearfix"></div>
										
										
									</div>
									<div class="row">
										<br>
										<div class="col-md-12">
											<div class="panel panel-default">
												<div class="panel-heading">
													<h3 class="panel-title"><strong>'.esc_html__('Order Info', 'listingpro-plugin').'</strong></h3>
												</div>
											</div>
										</div>
										
										<div class="col-xs-6">'.esc_html__('Price', 'listingpro-plugin').'</div>
										<div class="col-xs-6 text-right">'.$price.$currency.'</div>
										<div class="clearfix"></div>
										
										<div class="col-xs-6">'.esc_html__('Payment Method', 'listingpro-plugin').'</div>
										<div class="col-xs-6 text-right">'.$paymentMethod.'</div>
										<div class="clearfix"></div>
										
										<div class="col-xs-6">'.esc_html__('Transaction id', 'listingpro-plugin').'</div>
										<div class="col-xs-6 text-right">'.$transactionID.'</div>

									</div>
								</div>
							</div>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						  </div>
						</div>

					  </div>
					</div>
		';
		exit(json_encode(array($output)));
	}
}