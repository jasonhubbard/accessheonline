<?php
add_action('init','wdmqe_export_data');
function wdmqe_export_data() {
	if( isset( $_POST['wdm_format'] ) ) {

		$obj_class = new Wdm_Export_Quiz();

		// Get all data of statistics
		$data = $obj_class->wdm_export();

		if( empty($data ) ) {
			die('Something went wrong OR data not found!!!');
		}

		//Stores all the required values from the form
		//Data to be inserted in Csv or Excel
		$wdm_export_data = isset( $data[ 'table' ] ) ? ( $data[ 'table' ] ) : '';
		//User name
		$wdm_uname		 = isset( $data[ 'name' ] ) ? ( $data[ 'name' ] ) : '';
		//Quiz Title
		$wdm_quiz		 = isset( $data[ 'quiz_title' ] ) ? ( $data[ 'quiz_title' ] ) : '';
		//Format of Export
		$wdm_format		 = isset( $_REQUEST[ 'wdm_format' ] ) ? ( $_REQUEST[ 'wdm_format' ] ) : '';

		//Checks for the data to be exported
		if ( $wdm_export_data !== '' && $wdm_format !== '') {

			//If username and Quiz title is not empty then set file name using Username and Quiz title 
			if ( ! empty( $wdm_uname ) && ! empty( $wdm_quiz ) ) {

				$file_name	 = $wdm_quiz . "-" . $wdm_uname;
				$file_name	 = str_replace( " ", "_", $file_name );
			}
			// Else set it to sample
			else {
				$file_name = "sample";
			}

			header( 'Content-type: application/ms-excel' );
			header( 'Content-Disposition: attachment; filename=' . $file_name . '.' . $wdm_format );
			// Checks if the format is Csv
			if ( $wdm_format === 'csv' ) {
				
				//Include library which we used to convert Html to Csv data
				include "simple_html_dom.php";
				// Library's function to get Html from the data
				$html	 = str_get_html( htmlspecialchars_decode( $wdm_export_data ) );

				//Opens a file in write mode
				$fp		 = fopen( "php://output", "w" );
				//Checks if file opened on php output stream
				if ( $fp ) {

					// For each row of the table in Data recieved
					foreach ( $html->find( 'tr' ) as $element ) {

						// For Headings
						$th = array();
						foreach ( $element->find( 'th' ) as $row ) {
							$th [] = $row->plaintext;
						}
						//Inserts Heading into the csv file
						if ( ! empty( $th ) )
							fputcsv( $fp, $th );
						//For cell's value
						$td = array();
						//For each cell
						foreach ( $element->find( 'td' ) as $row ) {
							$td [] = $row->plaintext;
						}
						//Inserts Each cell's value and points to next row
						if ( ! empty( $td ) )
							fputcsv( $fp, $td );
					}
					// Closes the Csv file
					fclose( $fp );
				}
				// If file cannot be opened
				else {
					echo "File Permission Issue!!!";
				}
			}
			//Create Excel sheet if format is xls
			else {

				//Data recieved is in JSON format, so we have decoded it
				$table = json_decode( $wdm_export_data, TRUE );
				//Includes all the files required for Excel sheet creation
				//Contains  PHPExcel_IOFactory::createWriter
				include 'Classes/PHPExcel/IOFactory.php';
				//Contains PHPExcel Class
				include 'Classes/PHPExcel.php';
				//Contains PHPExcel_Style_Alignment Class
				include 'Classes/PHPExcel/Style/Alignment.php';

				//Creates Object
				$objPHPExcel = new PHPExcel();

				//Set Column width to auto
				for ( $col = 'A'; $col != 'J'; $col ++ ) {
					$objPHPExcel->getActiveSheet()->getColumnDimension( $col )->setAutoSize( TRUE );
				}

				//Set Text alignment of cells to Vertical Center
				$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical( PHPExcel_Style_Alignment::VERTICAL_CENTER );

				//For row number
				$i = 0;
				foreach ( $table as $row ) {

					for ( $cell = 0; $cell < count( $row ); $cell ++ ) {

						//Converts integer to Character
						$charc = chr( 65 + $cell );

						//Gets the value of the Cell
						$value = $row[ $cell ][ 'value' ];
						//To set Row Height, it will be according to the cell having the maximum number of lines
						if ( strpos( $value, "\n" ) !== FALSE ) {
							$count_lines		 = count( explode( "\n", $value ) ) + 1;
							$current_row_height	 = $objPHPExcel->getActiveSheet()->getRowDimension( $i + 1 )->getRowHeight();
							if ( (20 * $count_lines) > $current_row_height ) {
								$objPHPExcel->getActiveSheet()->getRowDimension( $i + 1 )->setRowHeight( 15 * $count_lines );
							}
						}
						//For style on each cell
						if ( isset( $row[ $cell ][ 'style' ] ) ) {
							$style	 = array();
							$style	 = $row[ $cell ][ 'style' ];
							//If the cell text should be bold
							if ( key_exists( 'bold', $style ) ) {
								$objPHPExcel->getActiveSheet()->getStyle( "$charc" . ($i + 1) )->getFont()->setBold( TRUE );
							}
							// For italic text style
							if ( key_exists( 'italic', $style ) ) {
								$objPHPExcel->getActiveSheet()->getStyle( "$charc" . ($i + 1) )->getFont()->setItalic( TRUE );
							}
							//To set font color
							if ( key_exists( 'font-color', $style ) ) {
								if ( $style[ 'font-color' ] === 'red' )
									$color_hex_value = 'FF0000';
								if ( $style[ 'font-color' ] === 'green' )
									$color_hex_value = '339933';
								if ( $style[ 'font-color' ] === 'blue' )
									$color_hex_value = '0000FF';

								$styleArray = array( 'font' => array( 'color' => array( 'rgb' => $color_hex_value ) ) );
								$objPHPExcel->getActiveSheet()->getStyle( "$charc" . ($i + 1) )->applyFromArray( $styleArray );
							}
						}
						// Insert value in the cell 
						$objPHPExcel->getActiveSheet()->setCellValue( "$charc" . ($i + 1), "$value" );
						// For text wrapping
						$objPHPExcel->getActiveSheet()->getStyle( "$charc" . ($i + 1) )->getAlignment()->setWrapText( TRUE );
					}
					//For next row
					$i ++;
				}

				// Object to wrie into the file and save in Php output stream
				$objWriter = PHPExcel_IOFactory::createWriter( $objPHPExcel, 'Excel2007' );
				$objWriter->save( 'php://output' );
			}
		} else {

			echo "Something went wrong!!!";
		}

		exit;
	}
	
}

// "htmlspecialchars_decode" function is supported after PHP "5.1.0" version. For older PHP versions, following functions is used.
if ( !function_exists('htmlspecialchars_decode') ) {
	function htmlspecialchars_decode($text) {
		return strtr($text, array_flip(get_html_translation_table(HTML_SPECIALCHARS)));
	}
}

// To print array in <pre> tag.
function wdmqep($arr) {
	echo '<pre>'; print_r($arr); echo '</pre>';
}