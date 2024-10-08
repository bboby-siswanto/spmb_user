<?php

class Finances extends CI_Model
{
	private $bniCode = 8;
	private $bniIULIProduction = 310;
	private $bniIULIDevelopment = 141;
	private $environment;
	
	private $iuliBNICode;
	private $programId = 1;
	
    function __construct()
    {
		parent::__construct();
		$this->setEnvironment('development');
    }
    
    public function getVaNumber(
		$paymentTypeId,
		$semesterId,
		$nrOfInstallments,
		$studentType,
		$studentNumber = null,
		$yearName = null
		)
	{
		$this->load->model('registration/Registrations');
		
		$vaPaymentType = str_pad($paymentTypeId, 2, '0', STR_PAD_LEFT);
		$vaSemester = str_pad($semesterId, 2, '0', STR_PAD_LEFT);
		
		if($studentType == 'student'){
			$year = substr($studentNumber, 4, 2);
			$studyProgram = substr($studentNumber, 6, 2);
			$sequence = substr($studentNumber, -2);
			
			$studentIdVa = $year.$studyProgram.$sequence;
			$studentIdVa = str_pad($studentIdVa, 6, '0', STR_PAD_LEFT);
		}
		else{
			$activeYear = $this->Registrations->getActiveIntakeYear();
			
			switch($studentType)
			{
				case "candidate":
					$vaSequence = str_pad($activeYear->academic_year_candidates_counter, 4, '0', STR_PAD_LEFT);
					break;
					
				case "participant":
					$vaSequence = str_pad($activeYear->academic_year_pass_counter, 4, '0', STR_PAD_LEFT);
					break;
			}
			
			$vaYear = substr($yearName, 2);
			$studentIdVa = $vaYear.$vaSequence;
		}
		
		$vaNumber = $this->iuliBNICode.$vaPaymentType.$vaSemester.$nrOfInstallments.$this->programId.$studentIdVa;
		
		if(strlen($vaNumber) == 16){
			return $vaNumber;
		}
		else{
			$errorData = array(
				'payment_type_id' => $paymentTypeId,
				'semester_id' => $semesterId,
				'nr_of_installments' => $nrOfInstallments,
				'student_type' => $studentType,
				'student_number' => $studentNumber,
				'year_name' => $yearName
			);
			$errorJsonEncode = json_encode($errorData);
			
			$errorMessage = <<<TEXT
Error getting 16 digits VA Number

BNI Code: {$this->iuliBNICode}
VA Payment Type: {$vaPaymentType}
VA Semester: {$vaSemester}
Number of Installments: {$nrOfInstallments}
Program ID: {$this->programId}
Student ID VA: {$studentIdVa}
Student Type: {$studentType}
VA Number: {$vaNumber}

Data: $errorJsonEncode
TEXT;
			
			$this->email->from('error_log@iuli.ac.id', 'Error Log');
			$this->email->to('harmando.gemilang@iuli.ac.id');
			$this->email->subject('Error Boskuuuuu!!!');
			$this->email->message($errorMessage);
			$this->email->send();
			return FALSE;
		}
	}
    
    public function addInvoiceData($invoiceData)
	{
		$this->db->insert('invoice', $invoiceData);
		$invoiceId = $this->db->insert_id();
		return $invoiceId;
	}
    
    public function getInvoiceNumber($paymentTypeId, $studentId)
	{
		$invoiceNumber = 'INV-'.date('ymd', time()).str_pad($paymentTypeId, 2, '0', STR_PAD_LEFT).str_pad($studentId, 4, '0', STR_PAD_LEFT);
		return $invoiceNumber;
	}

	private function setEnvironment($environment)
	{
		switch($environment)
		{
			case "development":
				$this->iuliBNICode = $this->bniCode.$this->bniIULIDevelopment;
				break;
				
			case "production":
				$this->iuliBNICode = $this->bniCode.$this->bniIULIProduction;
				break;
		}
		$this->environment = $environment;
	}

    public function setUpInvoiceDetails($invoiceDetailsData)
	{	
		$this->db->insert('invoice_details', $invoiceDetailsData);
		return $this->db->insert_id();
	}

    public function setUpInvoice($invoiceFeedData)
	{
		$this->load->model('Students');
		$this->load->model('api/Bni_api');
		$this->load->model('registration/Registrations');
		$this->Bni_api->setEnvironment($this->environment);
		
		$nrOfPaymentOptions = $invoiceFeedData['payment_options'];
		$paymentTypeId = $invoiceFeedData['payment_type_id'];
		$semesterId = $invoiceFeedData['semester_id'];
		$studentId = $invoiceFeedData['student_id'];
		$initialDeadline = date('Y-m-d 23:59:59', strtotime($invoiceFeedData['initial_deadline']));
		$nrOfInstallments = $invoiceFeedData['installments'];
		$academicYearId = $invoiceFeedData['academic_year_id'];
		$invoiceAmount = $invoiceFeedData['invoice_amount'];
		$activeYear = $this->Registrations->getActiveIntakeYear();
		
		$invoiceNumber = $this->getInvoiceNumber($paymentTypeId, $studentId);
		
		$invoiceData = array(
			'payment_type_id' => $paymentTypeId,
			'academic_year_id' => $academicYearId,
			'semester_id' => $semesterId,
			'student_id' => $studentId,
			'invoice_number' => $invoiceNumber,
			'invoice_amount' => $invoiceAmount,
			'invoice_number_of_payment_options' => $nrOfPaymentOptions
		);
		$invoiceId = $this->addInvoiceData($invoiceData);
		
		$invoiceSubData = array(
			'invoice_id' => $invoiceId,
			'invoice_sub_total_amount' => $invoiceAmount
		);
		
		$studentData = $this->Students->getStudentByID($studentId);
		
		if($nrOfPaymentOptions > 1){
			$studyProgramId = $invoiceFeedData['study_program_id'];
			
			$invoiceSubInstallmentId = $this->setUpInvoiceSub($invoiceSubData, 'INSTALLMENT');
			$invoiceSubFullId = $this->setUpInvoiceSub($invoiceSubData, 'FULL');
			
			$studentNumber = $studentData->student_number;
			
			$feeData = $this->getFee($paymentTypeId, $academicYearId, $semesterId, $studyProgramId);
			
			$monthlyInstallmentAmount = ($invoiceAmount / $nrOfInstallments);
			
			for($i = 0; $i <= $nrOfInstallments; $i++){
				if($studentData->candidate_student_status == 'student'){
					$vaNumber = $this->getVaNumber(
						$paymentTypeId, 
						$semesterId, 
						$i,
						$studentData->candidate_student_status,
						$studentNumber
					);
				}
				else{
					$vaNumber = $this->getVaNumber(
						$paymentTypeId, 
						$semesterId, 
						$i,
						$studentData->candidate_student_status,
						null,
						$activeYear->academic_year_name
					);
				}
				
				if(!$vaNumber){
					return false;
				}
				
				if($i == 0){
					$invoiceDescription = "Full Payment: ".$feeData->fee_name;
					$invoiceSubDetailsData = array(
						'invoice_sub_id' => $invoiceSubInstallmentId,
						'invoice_sub_details_virtual_account' => $vaNumber,
						'invoice_sub_details_amount' => $invoiceAmount,
						'invoice_sub_details_description' => $invoiceDescription,
						'invoice_sub_details_payment_deadline' => $initialDeadline
					);
					$invoiceSubDetailsId = $this->setUpInvoiceSubDetails($invoiceSubDetailsData);
					
					$displayInvoiceAmount = "Rp. ".number_format($invoiceAmount, 0, ',', '.').",-";
					$displayInitialDeadline = date('j D Y H:i:s', strtotime($initialDeadline));
				}
				else{
					$installmentDeadline = $i - 1;
					$paymentDeadline = date('Y-m-d 23:59:59', strtotime($initialDeadline.' +'.$installmentDeadline.' month'));
					
					$invoiceDescription = "Installment: $i ".$feeData->fee_name;
					$invoiceSubDetailsData = array(
						'invoice_sub_id' => $invoiceSubFullId,
						'invoice_sub_details_virtual_account' => $vaNumber,
						'invoice_sub_details_amount' => $monthlyInstallmentAmount,
						'invoice_sub_details_description' => $invoiceDescription,
						'invoice_sub_details_payment_deadline' => $paymentDeadline
					);
					$invoiceSubdDetailsId = $this->setUpInvoiceSubDetails($invoiceSubDetailsData);
					
					$displayInvoiceAmount = "Rp. ".number_format($monthlyInstallmentAmount, 0, ',', '.').",-";
					$displayInitialDeadline = date('j D Y H:i:s', strtotime($paymentDeadline));
				}
			}
		}
		else{
			$feeData = $this->getFee($paymentTypeId, $academicYearId);
			$vaNumber = $this->getVaNumber(
				$paymentTypeId, 
				$semesterId, 
				$nrOfInstallments,
				$studentData->candidate_student_status,
				null,
				$activeYear->academic_year_name
			);
			
			if(!$vaNumber){
				return FALSE;
			}
			
			$invoiceDescription = $feeData->fee_name;
			
			$invoiceSubFullId = $this->setUpInvoiceSub($invoiceSubData, 'FULL');
			$invoiceSubDetailsData = array(
				'invoice_sub_id' => $invoiceSubFullId,
				'invoice_sub_details_virtual_account' => $vaNumber,
				'invoice_sub_details_amount' => $invoiceAmount,
				'invoice_sub_details_description' => $invoiceDescription,
				'invoice_sub_details_payment_deadline' => date('Y-m-d 23:59:59', strtotime($initialDeadline))
			);
			
			$invoiceSubDetailsId = $this->setUpInvoiceSubDetails($invoiceSubDetailsData);
			
			$bniDeadline = date('Y-m-d 23:59:59', strtotime($initialDeadline.' +1 month'));
			
			$data = array(
				'trx_amount' => $invoiceAmount,
				'billing_type' => 'c',
				'customer_name' => $studentData->personal_data_name,
				'virtual_account' => $vaNumber,
				'description' => $invoiceDescription,
				'datetime_expired' => $bniDeadline,
				'customer_email' => 'bni.finance@iuli.ac.id'
			);
			$createVaResult = $this->Bni_api->create_va($data);
			
			if($createVaResult['status'] !== '000'){
				return FALSE;
			}
			else{
				$bniTransactionId = $createVaResult['bni_transactions_id'];
				
				$updateInvoiceSubDetailsData = array(
					'bni_transactions_id' => $bniTransactionId
				);
				$this->updateInvoiceSubDetails($updateInvoiceSubDetailsData, $invoiceSubDetailsId);
			}
		}
		// var_dump($invoiceId);exit;
		return $invoiceId;
	}
	
	public function setUpInvoiceSub($invoiceSubData, $invoiceSubType)
	{
		$invoiceSubData['invoice_sub_type'] = $invoiceSubType;
		$this->db->insert('invoice_sub', $invoiceSubData);
		$invoiceSubId = $this->db->insert_id();
		return $invoiceSubId;
	}
	
	public function setUpInvoiceSubDetails($invoiceSubDetailsData)
	{
		$this->db->insert('invoice_sub_details', $invoiceSubDetailsData);
		$invoiceSubDetailsId = $this->db->insert_id();
		return $invoiceSubDetailsId;
    }
    
    public function updateInvoiceSubDetails($updateInvoiceSubDetailsData, $updateInvoiceSubDetailsId)
	{
		$this->db->update('invoice_sub_details', $updateInvoiceSubDetailsData, array('invoice_sub_details_id' => $updateInvoiceSubDetailsId));
    }
    
    public function getFee($paymentTypeId, $academicYearId, $semesterId = null, $studyProgramId = null)
	{
		$this->db->select('*');
		$this->db->from('fee f');
		$this->db->join('fee_setting fs', 'fs.fee_id = f.fee_id');
		$this->db->where('f.payment_type_id', $paymentTypeId);
		$this->db->where('fs.academic_year_id', $academicYearId);
		
		if(!is_null($semesterId)){
			$this->db->where('fs.semester_id', $semesterId);
		}
		
		if(!is_null($studyProgramId)){
			$this->db->where('fs.study_program_id', $studyProgramId);
		}
		
		$query = $this->db->get();
		
		if($query->num_rows() == 1){
			return $query->first_row();
		}
		else{
			if($query->num_rows > 1){
				return $query->result();
			}
			else{
				return FALSE;
			}
		}
	}
}
