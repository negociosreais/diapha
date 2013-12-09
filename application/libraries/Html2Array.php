<?php
class Html2Array {
	var $html_data = '';
	var $_return = array();
	var $_counter = '';
	var $button_counter = '';
	var $_unique_id = '';
	function __construct( $html_data ) 
	{
		if ( is_array($html_data) ) {
			$this->html_data = join('', $html_data);
		} else {
			$this->html_data = $html_data;
		}
		$this->_return = array();
		$this->_counter = 0;
		$this->button_counter = 0;
		$this->_unique_id = md5(time());
	}
	function parseForms() {
		if ( preg_match_all("/<form.*>.+<\/form>/isU", $this->html_data, $forms) ) {
			foreach ( $forms[0] as $form ) {
				preg_match("/<form.*name=[\"']?([\w\s]*)[\"']?[\s>]/i", $form, $form_name);
				$this->_return[$this->_counter]['form_data']['name'] = preg_replace("/[\"'<>]/", "", $form_name[1]);
				preg_match("/<form.*action=(\"([^\"]*)\"|'([^']*)'|[^>\s]*)([^>]*)?>/is", $form, $action);
				$this->_return[$this->_counter]['form_data']['action'] = preg_replace("/[\"'<>]/", "", $action[1]);
				preg_match("/<form.*method=[\"']?([\w\s]*)[\"']?[\s>]/i", $form, $method);
				$this->_return[$this->_counter]['form_data']['method'] = preg_replace("/[\"'<>]/", "", $method[1]);
				preg_match("/<form.*enctype=(\"([^\"]*)\"|'([^']*)'|[^>\s]*)([^>]*)?>/is", $form, $enctype);
				$this->_return[$this->_counter]['form_data']['enctype'] = preg_replace("/[\"'<>]/", "", $enctype[1]);
				if ( preg_match_all("/<input.*type=[\"']?hidden[\"']?.*>$/im", $form, $hiddens) ) {					
					foreach ( $hiddens[0] as $hidden ) {
						$this->_return[$this->_counter]['form_elemets'][$this->_getName($hidden)] = array(
																							'type'	=> 'hidden',
																							'value'	=> $this->_getValue($hidden)
																							);
					}
				}
				
				/*
				 * <input type=text entries
				 */
				if ( preg_match_all("/<input.*type=[\"']?text[\"']?.*>/iU", $form, $texts) ) { 
					foreach ( $texts[0] as $text ) {
						$this->_return[$this->_counter]['form_elemets'][$this->_getName($text)] = array(
																							'type'	=> 'text',
																							'value'	=> $this->_getValue($text)
																							);
					}
				}
				
				/*
				 * <input type=password entries
				 */
				if ( preg_match_all("/<input.*type=[\"']?password[\"']?.*>/iU", $form, $passwords) ) { 
					foreach ( $passwords[0] as $password ) {
						$this->_return[$this->_counter]['form_elemets'][$this->_getName($password)] = array(
																							'type'	=> 'password',
																							'value'	=> $this->_getValue($password)
																							);
					}
				}
				if ( preg_match_all("/<textarea.*>.*<\/textarea>/isU", $form, $textareas) ) {
					foreach ( $textareas[0] as $textarea ) {
						preg_match("/<textarea.*>(.*)<\/textarea>/isU", $textarea, $textarea_value);
						$this->_return[$this->_counter]['form_elemets'][$this->_getName($textarea)] = array(
																							'type'	=> 'textarea',
																							'value'	=> $textarea_value[1]
																							);
					}
				}
				if ( preg_match_all("/<input.*type=[\"']?checkbox[\"']?.*>/iU", $form, $checkboxes) ) {
					foreach ( $checkboxes[0] as $checkbox ) {
						if ( preg_match("/checked/i", $checkbox) ) {
							$this->_return[$this->_counter]['form_elemets'][$this->_getName($checkbox)] = array(
																							'type'	=> 'checkbox',
																							'value'	=> 'on'
																							);
						} else {
							$this->_return[$this->_counter]['form_elemets'][$this->_getName($checkbox)] = array(
																							'type'	=> 'checkbox',
																							'value'	=> ''
																							);
						}
					}
				}
				if ( preg_match_all("/<input.*type=[\"']?radio[\"']?.*>/iU", $form, $radios) ) {
					foreach ( $radios[0] as $radio ) {
						if ( preg_match("/checked/i", $radio) ) {
							$this->_return[$this->_counter]['form_elemets'][$this->_getName($radio)] = array(
																							'type'	=> 'radio',
																							'value'	=> $this->_getValue($radio)
																							);
						}
					}		
				}
				if ( preg_match_all("/<input.*type=[\"']?submit[\"']?.*>/iU", $form, $submits) ) {
					foreach ( $submits[0] as $submit ) {
						$this->_return[$this->_counter]['buttons'][$this->button_counter] = array(
																							'type'	=> 'submit',
																							'name'	=> $this->_getName($submit),
																							'value'	=> $this->_getValue($submit)
																							);
						$this->button_counter++;
					}
				}
			if ( preg_match_all("/<input.*type=[\"']?button[\"']?.*>/iU", $form, $buttons) ) {
					foreach ( $buttons[0] as $button ) {
						$this->_return[$this->_counter]['buttons'][$this->button_counter] = array(
																							'type'	=> 'button',
																							'name'	=> $this->_getName($button),
																							'value'	=> $this->_getValue($button)
																							);
						$this->button_counter++;
					}
				}
				if ( preg_match_all("/<input.*type=[\"']?reset[\"']?.*>/iU", $form, $resets) ) {
					foreach ( $resets[0] as $reset ) {
						$this->_return[$this->_counter]['buttons'][$this->button_counter] = array(
																							'type'	=> 'reset',
																							'name'	=> $this->_getName($reset),
																							'value'	=> $this->_getValue($reset)
																							);
						$this->button_counter++;
					}
				}
				
				if ( preg_match_all("/<input.*type=[\"']?image[\"']?.*>/iU", $form, $images) ) {
					foreach ( $images[0] as $image ) {
						$this->_return[$this->_counter]['buttons'][$this->button_counter] = array(
																							'type'	=> 'reset',
																							'name'	=> $this->_getName($image),
																							'value'	=> $this->_getValue($image)
																							);
						$this->button_counter++;
					}
				}
				if ( preg_match_all("/<select.*>.+<\/select>/isU", $form, $selects) ) {
					foreach ( $selects[0] as $select ) {
						if ( preg_match_all("/<option.*>.+<\/option>/isU", $select, $all_options) ) {
							foreach ( $all_options[0] as $option ) {
								if ( preg_match("/selected/i", $option) ) {
									if ( preg_match("/value=[\"'](.*)[\"']\s/iU", $option, $option_value) ) {
										$option_value = $option_value[1];
										$found_selected = 1;
									} else {
										preg_match("/<option.*>(.*)<\/option>/isU", $option, $option_value);
										$option_value = $option_value[1];
										$found_selected = 1;
									}
								}
							}
							if ( !isset($found_selected) ) {
								if ( preg_match("/value=[\"'](.*)[\"']/iU", $all_options[0][0], $option_value) ) {
									$option_value = $option_value[1];
								} else {
									preg_match("/<option>(.*)<\/option>/iU", $all_options[0][0], $option_value);
									$option_value = $option_value[1];
								}
							} else {
								unset($found_selected);
							}
							$this->_return[$this->_counter]['form_elemets'][$this->_getName($select)] = array(
																									'type'	=> 'select',
																									'value'	=> trim($option_value)
																									);
						}
					}
				}

				$this->_counter++;
			}
		}
		return $this->_return;
	}
	function _getName( $string ) {
		if ( preg_match("/name=[\"']?([\w\s]*)[\"']?[\s>]/i", $string, $match) ) {
			$val_match = preg_replace("/\"'/", "", trim($match[1]));
			
			unset($string);
			return $val_match;
		}
	}
	function _getValue( $string ) {
		if ( preg_match("/value=(\"([^\"]*)\"|'([^']*)'|[^>\s]*)([^>]*)?>/is", $string, $match) ) {
			$val_match = trim($match[1]);
			
			if ( strstr($val_match, '"') ) {
				$val_match = str_replace('"', '', $val_match);
			}
			
			unset($string);
			return $val_match;
		}
	}

	function __destruct()
	{

	}

}

?>
