<?php 
class Printpage extends CI_Controller {
	public function index() {

		secureLogin($this->session->userdata('userID'), 'admin', $this->session->userdata('positionID'));
		$data = array(
			'profileInfo' 	=> $this->model->get_profileInfo(),
			'position' 		=> $this->model->get_position(),
			'status' 		=> $this->model->get_status(),
			'department' 	=> $this->model->get_department(),
			'title'			=> 'Tracking System | Reports',
			'search'		=> $this->input->post()
		);

		// print_r($_POST);

		if($_POST['btnPrintVal'] == 1) {
			$this->load->view('admin/print_page',$data);
		}else {

			$dfromRep 		= $this->input->post('filDateFrom');
			$dtoRep 		= $this->input->post('filDateTo');
			$departmentRep 	= $this->input->post('departmentRep');
			$positionRep 	= $this->input->post('positionRep');
			$classRep 		= $this->input->post('classRep');
			$shiftRep 		= $this->input->post('shiftRep');
			$employeeFilter = $this->input->post('employeeFilter');


			$query = $this->model->get_generateReport($dfromRep, $dtoRep, $departmentRep, $positionRep, $classRep, $shiftRep, $employeeFilter);

			$worksheetCount = 0;
			$objPHPExcel = new PHPExcel();

			foreach($query->result() as $row) {
				$fullname = $row->lastname.', '.$row->firstname.' '.$row->middlename;

				$timeInAndOut = $this->model->get_setTimeInAndOut($row->userID,  $dfromRep, $dtoRep);

				$dateStart 	= date('M d', strtotime($dfromRep));
				$dateEnd 	= date('M d', strtotime($dtoRep));	
				$year 		= date('Y', strtotime($dtoRep));	

				$objPHPExcel->getActiveSheet($worksheetCount)->mergeCells('A1:F1');
				$objPHPExcel->getActiveSheet($worksheetCount)->setCellValue('A1', 'TCAP DAILY TIME RECORD AS OF '.$dateStart.'. to '.$dateEnd.'. '.$year);
				$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
				$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
				$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray(
					array(
						'font'  => array(
							'size'  => 15,
						),
						'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						)
					)
				);

				if($worksheetCount == 0) {
					$objPHPExcel->setActiveSheetIndex(0);

					$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Log Date');
					$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Time In');
					$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Time Out');
					$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Late');
					$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Overtime');
					$objPHPExcel->getActiveSheet()->setCellValue('F2', 'Work Duration');

					$style = array(
						'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						)
					);
					$objPHPExcel->getDefaultStyle()->applyFromArray($style);

					$objPHPExcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray(
						array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'd00f2b')
							),
							'font'  => array(
								'color' => array('rgb' => 'FFFFFF'),
								'size'  => 13,
							)
						)
					);

					for($col = 'A'; $col !== 'G'; $col++) {
						$objPHPExcel->getActiveSheet() // auto resize width of column
							->getColumnDimension($col)
							->setAutoSize(true);

						$objPHPExcel->getActiveSheet()
							->getStyle($col.'2') // text b
							->getFont()
							->setBold(true);

						$objPHPExcel->getActiveSheet()
							->getStyle($col.'1') // text b
							->getFont()
							->setBold(true);
					}
					$val = 3;
					foreach ($timeInAndOut->result() as $value) {
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$val, date('M d, Y', strtotime($value->dateAdded)));
						$objPHPExcel->getActiveSheet()->setCellValue('B'.$val, date('h:i A', strtotime($value->timein)));
						$objPHPExcel->getActiveSheet()->setCellValue('C'.$val, date('h:i A', strtotime($value->timeout)));
						$objPHPExcel->getActiveSheet()->setCellValue('D'.$val, $value->late);
						$objPHPExcel->getActiveSheet()->setCellValue('E'.$val, $value->overtime);
						$objPHPExcel->getActiveSheet()->setCellValue('F'.$val, $value->workduration);
						$val ++;
					}
					$objPHPExcel->getActiveSheet()->setTitle($fullname);
					$totalRow = 0;
					$val--;
					$totalRow += $val;

					$styleArray = array(
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						)
					);

					$objPHPExcel->getActiveSheet($worksheetCount)->mergeCells('A1:F1');
					$objPHPExcel->getActiveSheet($worksheetCount)->setCellValue('A1', 'TCAP DAILY TIME RECORD AS OF '.$dateStart.'. to '.$dateEnd.'. '.$year);
					$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
					$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(30);

					$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray(
						array(
							'font'  => array(
								'size'  => 15,
							),
							'alignment' => array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
								'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							)
						)
					);

					$objPHPExcel->getActiveSheet()->getStyle('A2:F'.$totalRow)->applyFromArray($styleArray);
				}else {
					$objPHPExcel->createSheet();
					$objPHPExcel->setActiveSheetIndex($worksheetCount);

					$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Log Date');
					$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Time In');
					$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Time Out');
					$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Late');
					$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Overtime');
					$objPHPExcel->getActiveSheet()->setCellValue('F2', 'Work Duration');

					$style = array(
						'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						)
					);
					$objPHPExcel->getDefaultStyle()->applyFromArray($style);

					$objPHPExcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray(
						array(
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => 'd00f2b')
							),
							'font'  => array(
								'color' => array('rgb' => 'FFFFFF'),
								'size'  => 13,
							)
						)
					);

					for($col = 'A'; $col !== 'G'; $col++) {
						$objPHPExcel->getActiveSheet() // auto resize width of column
							->getColumnDimension($col)
							->setAutoSize(true);

						$objPHPExcel->getActiveSheet()
							->getStyle($col.'2') // text b
							->getFont()
							->setBold(true);

						$objPHPExcel->getActiveSheet()
							->getStyle($col.'1') // text b
							->getFont()
							->setBold(true);
					}
					$val = 3;
					foreach ($timeInAndOut->result() as $value) {
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$val, date('M d, Y', strtotime($value->dateAdded)));
						$objPHPExcel->getActiveSheet()->setCellValue('B'.$val, date('h:i A', strtotime($value->timein)));
						$objPHPExcel->getActiveSheet()->setCellValue('C'.$val, date('h:i A', strtotime($value->timeout)));
						$objPHPExcel->getActiveSheet()->setCellValue('D'.$val, $value->late);
						$objPHPExcel->getActiveSheet()->setCellValue('E'.$val, $value->overtime);
						$objPHPExcel->getActiveSheet()->setCellValue('F'.$val, $value->workduration);
						$val ++;
					}
					$objPHPExcel->getActiveSheet()->setTitle($fullname);
					$totalRow = 0;
					$val--;
					$totalRow += $val;

					$styleArray = array(
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN
							)
						)
					);

					$objPHPExcel->getActiveSheet($worksheetCount)->mergeCells('A1:F1');
					$objPHPExcel->getActiveSheet($worksheetCount)->setCellValue('A1', 'TCAP DAILY TIME RECORD AS OF '.$dateStart.'. to '.$dateEnd.'. '.$year);
					$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
					$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(30);

					$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray(
						array(
							'font'  => array(
								'size'  => 15,
							),
							'alignment' => array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
								'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							)
						)
					);

					$objPHPExcel->getActiveSheet()->getStyle('A2:F'.$totalRow)->applyFromArray($styleArray);
				}
				$worksheetCount ++;
			}
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="Daily Time Record.xls"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');

			$this->load->view('admin/Attendance_monitoring');
		}
	}

	public function generateReport() {
		$dfromRep 		= $this->input->post('dfromRep');
		$dtoRep 		= $this->input->post('dtoRep');
		$departmentRep 	= $this->input->post('departmentRep');
		$positionRep 	= $this->input->post('positionRep');
		$classRep 		= $this->input->post('classRep');
		$shiftRep 		= $this->input->post('shiftRep');
		$employeeFilter = $this->input->post('employeeFilter');
		$btnPrintVal	= $this->input->post('btnPrintVal');


		$query = $this->model->get_generateReport($dfromRep, $dtoRep, $departmentRep, $positionRep, $classRep, $shiftRep, $employeeFilter);


		if($btnPrintVal == 2) {
			$data = array(
				'success' => 2,
				'result'	=> $query->result()
			);
		}else {
			$data = array(
				'success' => 1,
				'result'	=> $query->result()
			);
		}

		// print_r($_POST);
		generate_json($data);
	}

	public function setTimeInAndOut() {
		$userID 	= $this->input->post('userID');
		$dfromRep 	= $this->input->post('dfromRep');
		$dtoRep 	= $this->input->post('dtoRep');

		$query = $this->model->get_setTimeInAndOut($userID, $dfromRep, $dtoRep);
		$data = array(
			'success' => 1,
			'result'	=> $query->result()
		);

		generate_json($data);
	}

	public function getManager() {
		$userID = $this->input->post('userID');

		$query = $this->model->getManager($userID);
		$data = array(
			'success' => 1,
			'result'	=> $query->result()
		);

		generate_json($data);
	}

}