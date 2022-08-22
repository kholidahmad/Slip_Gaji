 <?php
    defined('BASEPATH') or exit('No direct script access allowed');

    //Memanggil file autoload
    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Reader\Csv;
    use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

    class Payroll extends CI_Controller
    {

        /**
         * Index Page for this controller.
         *$individual_info
         * Maps to the following URL
         *      http://example.com/index.php/welcome
         *  - or -
         *      http://example.com/index.php/welcome/index
         *  - or -
         * Since this controller is set as the default controller in
         * config/routes.php, it's displayed at http://example.com/
         *
         * So any other public methods not prefixed with an underscore will
         * map to /index.php/welcome/<method_name>
         * @see https://codeigniter.com/user_guide/general/urls.html
         */
        function __construct()
        {
            parent::__construct();
            $this->load->database();
            $this->load->model('login_model');
            $this->load->model('dashboard_model');
            $this->load->model('employee_model');
            $this->load->model('leave_model');
            $this->load->model('payroll_model');
            $this->load->model('settings_model');
            $this->load->model('organization_model');
            $this->load->model('loan_model');
        }
        public function index()
        {
            #Redirect to Admin dashboard after authentication
            if ($this->session->userdata('user_login_access') == 1)
                redirect('dashboard/Dashboard');
            $data = array();
            #$data['settingsvalue'] = $this->dashboard_model->GetSettingsValue();
            $this->load->view('login');
        }
        public function Salary_Type()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $data['typevalue'] = $this->payroll_model->GetsalaryType();
                $this->load->view('backend/salary_type', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }
        /* public function Salary_List(){
        if($this->session->userdata('user_login_access') != False) { 
        
        $data['salaryvalue'] = $this->payroll_model->GetsalaryValueEm();

        $this->load->view('backend/salary_list',$data);
        }
        else{
            redirect(base_url() , 'refresh');
        }        
    }*/
        public function Add_Sallary_Type()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $id = $this->input->post('id');
                $type = $this->input->post('typename');
                $createdate = $this->input->post('createdate');
                $this->form_validation->set_error_delimiters();
                $this->form_validation->set_rules('typename', 'Type name', 'trim|required|min_length[3]|max_length[120]|xss_clean');

                if ($this->form_validation->run() == FALSE) {
                    echo validation_errors();
                } else {
                    $data = array();
                    $data = array(
                        'salary_type' => $type,
                        'create_date' => $createdate
                    );
                    if (empty($id)) {
                        $success = $this->payroll_model->Add_typeInfo($data);
                        #redirect("leave/Holidays");
                        #$this->session->set_flashdata('feedback','Successfully Added');
                        echo "Successfully Added";
                    } else {
                        $success = $this->payroll_model->Update_typeInfo($id, $data);
                        #$this->session->set_flashdata('feedback','Successfully Updated');
                        #redirect("leave/Holidays");
                        echo "Successfully Updated";
                    }
                }
            } else {
                redirect(base_url(), 'refresh');
            }
        }
        public function GetSallaryTypeById()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $id = $this->input->get('id');
                $data['typevalueid'] = $this->payroll_model->Get_typeValue($id);
                echo json_encode($data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }
        public function GetSallaryById()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $id = $this->input->get('id');
                $data = array();
                // $data['salaryvaluebyid'] = $this->payroll_model->Get_Salary_Value($id);
                // $data['salarypayvaluebyid'] = $this->payroll_model->Get_Salarypay_Value($id);
                $data['salaryvalue'] = $this->payroll_model->GetsalaryValueByID($id);
                $data['loanvaluebyid'] = $this->payroll_model->GetLoanValueByID($id);
                echo json_encode($data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }
        public function Generate_salary()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $data['typevalue'] = $this->payroll_model->GetsalaryType();
                $data['employee'] = $this->employee_model->emselect();
                $data['salaryvalue'] = $this->payroll_model->GetAllSalary();
                $data['department'] = $this->organization_model->depselect();
                $this->load->view('backend/salary_view', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        // Generates the salary
        public function Add_Sallary_Pay()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $id = $this->input->post('id');
                $emid = $this->input->post('emid');
                $month = $this->input->post('month');
                $basic = $this->input->post('basic');
                $totalday = $this->input->post('month_work_hours');
                $totalday = $this->input->post('hours_worked');
                $loan = $this->input->post('loan');
                $loanid = $this->input->post('loan_id');
                $total = $this->input->post('total_paid');
                $paydate = $this->input->post('paydate');
                $status = $this->input->post('status');
                $paid_type = $this->input->post('paid_type');

                $this->form_validation->set_error_delimiters();
                $this->form_validation->set_rules('emid', 'Employee Id', 'trim|required');
                $this->form_validation->set_rules('basic', 'Employee Basic', 'trim|required|min_length[2]|max_length[7]|xss_clean');

                if ($this->form_validation->run() == FALSE) {

                    echo validation_errors();
                } else {

                    $data = array();
                    $data = array(
                        'emp_id' => $emid,
                        'month' => $month,
                        'paid_date' => $paydate,
                        'total_days' => $totalday,
                        'basic' => $basic,
                        'loan' => $loan,
                        'total_pay' => $total,
                        'status' => $status,
                        'paid_type' => $paid_type
                    );
                    if (empty($id)) {
                        $success = $this->payroll_model->insert_Salary_Pay($data);
                        if (empty($loanid)) {
                            #$loaninfo = $this->payroll_model->GetloanInfo($emid);
                            echo "Successfully Added";
                        } else {
                            $loanvalue = $this->loan_model->GetLoanValuebyLId($loanid);
                            #$loaninfo = $this->payroll_model->GetloanInfo($emid);
                            if (!empty($loanvalue)) {
                                $period = $loanvalue->install_period - 1;
                                $number = $loanvalue->loan_number;
                                $data = array();
                                $data = array(
                                    'emp_id' => $emid,
                                    'loan_id' => $loanid,
                                    'loan_number' => $number,
                                    'install_amount' => $loan,
                                    /*'pay_amount' => $payment,*/
                                    'app_date' => $paydate,
                                    /*'receiver' => $receiver,*/
                                    'install_no' => $period
                                    /*'notes' => $notes*/
                                );
                                $success = $this->loan_model->Add_installData($data);
                                $totalpay = $loanvalue->total_pay + $loan;
                                $totaldue = $loanvalue->amount - $totalpay;
                                /*$period = $loanvalue->install_period - 1;*/
                                if ($period == '1') {
                                    $status = 'Done';
                                }
                                $data = array();
                                $data = array(
                                    'total_pay' => $totalpay,
                                    'total_due' => $totaldue,
                                    'install_period' => $period,
                                    'status' => 'Done'
                                );
                                $success = $this->loan_model->update_LoanData($loanid, $data);
                            } else {
                                echo "Successfully added But your Loan number is not available";
                            }
                        }
                        echo "Successfully Added";
                    } else {
                        $success = $this->payroll_model->Update_SalaryPayInfo($id, $data);
                        echo "Successfully Updated";
                    }
                }
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        // From Salary List - Not Sure
        public function Add_Salary()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $sid = $this->input->post('sid');
                $aid = $this->input->post('aid');
                $did = $this->input->post('did');
                $em_id = $this->input->post('emid');
                /*$type = $this->input->post('typeid');*/
                $basic = $this->input->post('basic');
                $medical = $this->input->post('medical');
                $houserent = $this->input->post('houserent');
                $bonus = $this->input->post('bonus');
                $provident = $this->input->post('provident');
                $bima = $this->input->post('bima');
                $tax = $this->input->post('tax');
                $others = $this->input->post('others');
                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters();
                $this->form_validation->set_rules('basic', 'basic', 'trim|required|min_length[3]|max_length[10]|xss_clean');

                if ($this->form_validation->run() == FALSE) {
                    echo validation_errors();
                    #redirect("employee/view?I=" .base64_encode($em_id));
                } else {
                    $data = array();
                    $data = array(
                        'emp_id' => $em_id,
                        /*'type_id' => $type,*/
                        'basic' => $basic
                    );
                    if (!empty($sid)) {
                        $success = $this->employee_model->Update_Salary($sid, $data);
                        #$this->session->set_flashdata('feedback','Successfully Updated');
                        #echo "Successfully Updated";
                        #$success = $this->employee_model->Add_Salary($data);
                        $insertId = $this->db->insert_id();
                        #$this->session->set_flashdata('feedback','Successfully Added');
                        #echo "Successfully Added";
                        $data1 = array();
                        $data1 = array(
                            'salary_id' => $sid,
                            'medical' => $medical,
                            'house_rent' => $houserent,
                            'bonus' => $bonus
                        );
                        $success = $this->employee_model->Update_Addition($aid, $data1);
                        $data2 = array();
                        $data2 = array(
                            'salary_id' => $sid,
                            'provident_fund' => $provident,
                            'bima' => $bima,
                            'tax' => $tax,
                            'others' => $others
                        );
                        $success = $this->employee_model->Update_Deduction($did, $data2);
                        echo "Successfully Updated";
                    } else {
                        $success = $this->employee_model->Add_Salary($data);
                        $insertId = $this->db->insert_id();
                        #$this->session->set_flashdata('feedback','Successfully Added');
                        #echo "Successfully Added";
                        $data1 = array();
                        $data1 = array(
                            'salary_id' => $insertId,
                            'medical' => $medical,
                            'house_rent' => $houserent,
                            'bonus' => $bonus
                        );
                        $success = $this->employee_model->Add_Addition($data1);
                        $data2 = array();
                        $data2 = array(
                            'salary_id' => $insertId,
                            'provident_fund' => $provident,
                            'bima' => $bima,
                            'tax' => $tax,
                            'others' => $others
                        );
                        $success = $this->employee_model->Add_Deduction($data2);
                        echo "Successfully Added";
                    }
                }
            } else {
                redirect(base_url(), 'refresh');
            }
        }
        public function Get_PayrollDetails()
        {
            $depid = $this->input->get('dep_id');
            $dateval = $this->input->get('date_time');

            $orderdate = explode('-', $dateval);
            $month = $orderdate[0];
            $year = $orderdate[1];

            $day = cal_days_in_month(CAL_GREGORIAN, $month, $year);

            $holiday = $this->payroll_model->GetHolidayByYear($dateval);
            $totalday = 0;
            foreach ($holiday as $value) {
                #$start = date_create($value->from_date); 
                #$end = date_create($value->to_date);

                $days = $value->number_of_days;
                #$inday = $days->format("%a");
                #$total = array_sum($inday);

                $totalday = $totalday + $days;
            }
            $totalholiday = $totalday;
            $m = date('m');
            $y = date('Y');
            function getDays($y, $m)
            {
                $allday = cal_days_in_month(CAL_GREGORIAN, $m, $y);
                $wed = array();
                for ($i = 1; $i <= $allday; $i++) {
                    $daye  = date('Y-m-' . $i);
                    $result = date("D", strtotime($daye));
                    if ($result == "Fri") {
                        $fri[] = date("Y-m-d", strtotime($daye)) . " " . $result . "<br>";
                    }
                }
                return  count($fri);
            }
            $fri = getDays($y, $m);
            $totalweekend = $fri;
            $holidays = $totalholiday + $totalweekend;
            $monthday = $day - $holidays;


            $totalmonthhour = $monthday * 8;
            $totalmonthhour;
            $employee = $this->payroll_model->GetDepEmployee($depid);

            foreach ($employee as $value) {
                $hourrate = $value->total / $totalmonthhour;
                echo "<tr>
                    <td>$value->em_code</td>
                    <td>$value->first_name</td>
                    <td>$value->total</td>
                    <td>$hourrate</td>
                    <td>$totalmonthhour</td>
                    <td><a href='' data-id='$value->em_id' class='btn btn-sm btn-info waves-effect waves-light salaryGenerateModal' data-toggle='modal' data-target='#SalaryTypemodel' data-hour='$totalmonthhour'>Generate Salary</a></td>
                </tr>";
            }
        }

        // Original one commented out above
        public function Salary_List()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $data['salary_list'] = $this->payroll_model->getAllDataSalary();
                $this->load->view('backend/salary_list', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        public function coba_email()
        {
            $isiemail1 = '
                <!DOCTYPE html>
                <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
                <head>
                    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
                    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn"t be necessary -->
                    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
                    <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
                    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

                    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700" rel="stylesheet">

                    <!-- CSS Reset : BEGIN -->
                    <style>
                        /* What it does: Remove spaces around the email design added by some email clients. */
                        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
                        html,
                        body {
                            margin: 0 auto !important;
                            padding: 0 !important;
                            height: 100% !important;
                            width: 100% !important;
                            background: #f1f1f1;
                        }

                        /* What it does: Stops email clients resizing small text. */
                        * {
                            -ms-text-size-adjust: 100%;
                            -webkit-text-size-adjust: 100%;
                        }

                        /* What it does: Centers email on Android 4.4 */
                        div[style*="margin: 16px 0"] {
                            margin: 0 !important;
                        }

                        /* What it does: Stops Outlook from adding extra spacing to tables. */
                        table,
                        td {
                            mso-table-lspace: 0pt !important;
                            mso-table-rspace: 0pt !important;
                        }

                        /* What it does: Fixes webkit padding issue. */
                        table {
                            border-spacing: 0 !important;
                            border-collapse: collapse !important;
                            table-layout: fixed !important;
                            margin: 0 auto !important;
                        }

                        /* What it does: Uses a better rendering method when resizing images in IE. */
                        img {
                            -ms-interpolation-mode:bicubic;
                        }

                        /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
                        a {
                            text-decoration: none;
                        }

                        /* What it does: A work-around for email clients meddling in triggered links. */
                        *[x-apple-data-detectors],  /* iOS */
                        .unstyle-auto-detected-links *,
                        .aBn {
                            border-bottom: 0 !important;
                            cursor: default !important;
                            color: inherit !important;
                            text-decoration: none !important;
                            font-size: inherit !important;
                            font-family: inherit !important;
                            font-weight: inherit !important;
                            line-height: inherit !important;
                        }

                        /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
                        .a6S {
                            display: none !important;
                            opacity: 0.01 !important;
                        }

                        /* What it does: Prevents Gmail from changing the text color in conversation threads. */
                        .im {
                            color: inherit !important;
                        }

                        /* If the above doesn"t work, add a .g-img class to any image in question. */
                        img.g-img + div {
                            display: none !important;
                        }

                        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
                        /* Create one of these media queries for each additional viewport size you"d like to fix */

                        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
                        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
                            u ~ div .email-container {
                                min-width: 320px !important;
                            }
                        }
                        /* iPhone 6, 6S, 7, 8, and X */
                        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
                            u ~ div .email-container {
                                min-width: 375px !important;
                            }
                        }

                        @media only screen and (min-device-width: 414px) {
                            u ~ div .email-container {
                                min-width: 414px !important;
                            }
                        }


                    </style>

                    <!-- CSS Reset : END -->

                    <!-- Progressive Enhancements : BEGIN -->
                    <style>
                        .primary{
                        background: #17bebb;
                        }
                        .bg_white{
                            background: #ffffff;
                        }
                        .bg_light{
                            background: #f7fafa;
                        }
                        .bg_black{
                            background: #000000;
                        }
                        .bg_dark{
                            background: rgba(0,0,0,.8);
                        }
                        .email-section{
                            padding:2.5em;
                        }

                        /*BUTTON*/
                        .btn{
                            padding: 10px 15px;
                            display: inline-block;
                        }
                        .btn.btn-primary{
                            border-radius: 5px;
                            background: #17bebb;
                            color: #ffffff;
                        }
                        .btn.btn-white{
                            border-radius: 5px;
                            background: #ffffff;
                            color: #000000;
                        }
                        .btn.btn-white-outline{
                            border-radius: 5px;
                            background: transparent;
                            border: 1px solid #fff;
                            color: #fff;
                        }
                        .btn.btn-black-outline{
                            border-radius: 0px;
                            background: transparent;
                            border: 2px solid #000;
                            color: #000;
                            font-weight: 700;
                        }
                        .btn-custom{
                            color: rgba(0,0,0,.3);
                            text-decoration: underline;
                        }

                        h1,h2,h3,h4,h5,h6{
                            font-family: "Poppins", sans-serif;
                            color: #000000;
                            margin-top: 0;
                            font-weight: 400;
                        }

                        body{
                            font-family: "Poppins", sans-serif;
                            font-weight: 400;
                            font-size: 15px;
                            line-height: 1.8;
                            color: rgba(0,0,0,.4);
                        }

                        a{
                            color: #17bebb;
                        }

                        table{
                        }
                        /*LOGO*/

                        .logo h1{
                            margin: 0;
                        }
                        .logo h1 a{
                            color: #17bebb;
                            font-size: 24px;
                            font-weight: 700;
                            font-family: "Poppins", sans-serif;
                        }

                        /*HERO*/
                        .hero{
                            position: relative;
                            z-index: 0;
                        }

                        .hero .text{
                            color: rgba(0,0,0,.3);
                        }
                        .hero .text h2{
                            color: #000;
                            font-size: 34px;
                            margin-bottom: 0;
                            font-weight: 200;
                            line-height: 1.4;
                        }
                        .hero .text h3{
                            font-size: 24px;
                            font-weight: 300;
                        }
                        .hero .text h2 span{
                            font-weight: 600;
                            color: #000;
                        }

                        .text-author{
                            bordeR: 1px solid rgba(0,0,0,.05);
                            max-width: 50%;
                            margin: 0 auto;
                            padding: 2em;
                        }
                        .text-author img{
                            border-radius: 50%;
                            padding-bottom: 20px;
                        }
                        .text-author h3{
                            margin-bottom: 0;
                        }
                        ul.social{
                            padding: 0;
                        }
                        ul.social li{
                            display: inline-block;
                            margin-right: 10px;
                        }

                        /*FOOTER*/

                        .footer{
                            border-top: 1px solid rgba(0,0,0,.05);
                            color: rgba(0,0,0,.5);
                        }
                        .footer .heading{
                            color: #000;
                            font-size: 12px;
                        }
                        .footer ul{
                            margin: 0;
                            padding: 0;
                        }
                        .footer ul li{
                            list-style: none;
                            margin-bottom: 10px;
                        }
                        .footer ul li a{
                            color: rgba(0,0,0,1);
                        }


                        @media screen and (max-width: 500px) {
                        }

                    </style>
                </head>

                <body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;">
                    <center style="width: 100%; background-color: #f1f1f1;">
                    <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
                    &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
                    </div>
                    <div style="max-width: 1000px; margin: 0 auto;" class="email-container">
                        <!-- BEGIN BODY -->
                    <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
                        <tr>
                            <td valign="top" class="bg_white" style="padding: 1em 1em 0 1em;">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td class="logo" style="text-align: center;">
                                            <img width="170px;" src="' . base_url() . ' "assets/images/nusindoPNG.png" alt="PT Rajawali Nusindo" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="logo" style="text-align: center;padding-top: 10px;background-color: #0054a6;">
                                            <h2 href="#"  class="heading" style="color:#FFFFFF;"><b>E-PAYSLIP </b></h2> <b>' . date("F") . " " . date("Y") . '</b>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
                            <tr>
                                <td valign="middle" class="bg_white footer email-section">
                                    <table>
                                        <tr>
                                            <td valign="top" width="100%" style="padding-top: 5px;">
                                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                    <tr style="background-color: #f2f2f2;">
                                                        <td style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> NIK </b>
                                                        </td>
                                                        <td width="2%" style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> : </b>
                                                        </td>
                                                        <td style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> 123123123 </b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> NAMA </b>
                                                        </td>
                                                        <td width="2%" style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> : </b>
                                                        </td>
                                                        <td style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> AHMAT CHOLID </b>
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color: #f2f2f2;">
                                                        <td style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> JABATAN </b>
                                                        </td>
                                                        <td width="2%" style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> : </b>
                                                        </td>
                                                        <td style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> PELAKSANA SDM </b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> GOLONGAN </b>
                                                        </td>
                                                        <td width="2%" style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> : </b>
                                                        </td>
                                                        <td style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> IV </b>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="100%" style="padding-top: 20px;">
                                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                    <tr>
                                                        <tr style="text-align: left; padding-right: 10px;">
                                                            <td colspan="3" style="background-color: #0054a6;">
                                                                <b class="heading" style="display:flex;align-items:center;color:white;padding-left:5px;"> GAJI NORMATIF </b>
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Gaji Pokok = 5.000.0000 
                                                            </td>
                                                            <td width="2%" style="height: 5px; text-align: left; padding-right: 10px;"></td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;"></td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                TUNJ. KELUARGA = 1000
                                                            </td>
                                                            <td width="2%" style="height: 5px; text-align: left; padding-right: 10px;"></td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;"></td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                FAKTOR = 123123
                                                            </td>
                                                            <td width="2%" style="height: 5px; text-align: left; padding-right: 10px;"></td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;"></td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Gaji Dasar Pensiun 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 123123 
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Tunj. Golongan 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 123123123 
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Tunj. Merit 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 123123
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Tunj. Beras
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 123123
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Tunj. Peralihan 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 12313123 
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Tunj. Operasional 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 123123123
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Tunj. Bantuan Sosial 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 12312234
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Tunj. Kompensasi UMP 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 23453223
                                                            </td>
                                                        </tr>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="100%" style="padding-top: 5px;">
                                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                    <tr style="height:5px;">
                                                        <tr style="text-align: left; padding-right: 10px;">
                                                            <b class="heading" style="display:flex;align-items:center;color:white;padding-left:5px;"> TUNJANGAN </b>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                STRUKTURAL 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 234234234
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                LISTRIK & AIR 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 2342342
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                TRANSPORT 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 234234234
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                PERUMAHAN 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 234234234
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                SKALA 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 234234
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                KEMAHALAN 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 234234234
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                LAIN - LAIN 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 234234234
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                PPH Ps 21 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 234234234
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                PREMI PENSIUN
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 23423423
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                PREMI JAMSOSTEK 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 2342342
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                BPJS KESEHATAN 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 234234
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                BPJS KETENAGAKERJAAN 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 23423423
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                UANG MUKA 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 2342342
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                DPLK 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 2342342
                                                            </td>
                                                        </tr>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="100%" style="padding-top: 5px;">
                                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                    <tr>
                                                        <tr style="text-align: left; padding-right: 10px;">
                                                            <td colspan="3" style="background-color: #0054a6;">
                                                                <b class="heading" style="display:flex;align-items:center;color:white;padding-left:5px;"> JUMLAH PERHITUNGAN GAJI </b>
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                GAJI DASAR PENSIUN
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 234234
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                GAJI KOTOR
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 234234
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                GAJI BERSIH
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 23423423
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                POTONGAN LAIN-LAIN
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 23423423
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                JUMLAH DIBAYAR
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp 2342342234
                                                            </td>
                                                        </tr>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </table>
                    </div>
                    </center>
                </body>
                </html>
                ';
            $this->load->view('backend/coba_email');
        }

        public function kirim_slip()
        {
            // $salary_list[$i]['nik']
            $config = [
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://webmail.nusindo.co.id',
                'smtp_user' => 'rekrutmen@nusindo.co.id',
                'smtp_pass' => 'RNrekrutmen11',
                'smtp_port' => 465,
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'newline' => "\r\n",
                'validation' => TRUE
            ];

            $bulan = [
                '1' => 'JANUARI',
                '2' => 'FEBRUARI',
                '3' => 'MARET',
                '4' => 'APRIL',
                '5' => 'MEI',
                '6' => 'JUNI',
                '7' => 'JULI',
                '8' => 'AGUSTUS',
                '9' => 'SEPTEMBER',
                '10' => 'OKTOBER',
                '11' => 'NOVEMBER',
                '12' => 'DESEMBER'
            ];

            $salary_list = $this->payroll_model->getAllDataSalary();
            // var_dump(count($salary_list));
            // print_r($salary_list[1]['email']);
            // die;
            $jml_email = count($salary_list);
            // var_dump($jml_email);
            // die;
            $totaldata = 0;
            $looping = 0;
            for ($i = 0; $i < $jml_email; $i++) {
                // echo ($salary_list[$i]['email'] . " ");
                // for ($i = 0; $i < 1; $i++) {
                $totaldata++;
                $looping++;

                // SEND EMAIL
                // $this->_kirim_email("tomtravismat@gmail.com", "Slip Gaji Bulan " . date('F'), $isiemail);

                // load email library and install configuration :
                $this->load->library('email', $config);
                $this->email->initialize($config);

                // Email sent from :
                $this->email->from('rekrutmen@nusindo.co.id', 'SLIP GAJI PT. Rajawali Nusindo');
                // $this->email->to('kholidahmad@nusindo.co.id');
                $this->email->to($salary_list[$i]['email']);
                $this->email->subject("Slip Gaji " . $bulan[$salary_list[0]['bulan']] . " " . $salary_list[0]['tahun'] . " ");
                $filename = base_url() . "assets/images/nusindoPNG.png";
                $this->email->attach($filename);
                $cid = $this->email->attachment_cid($filename);
                // ISI EMAIL
                $isiemail = '
                <!DOCTYPE html>
                <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
                <head>
                    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
                    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn"t be necessary -->
                    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
                    <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
                    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

                    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700" rel="stylesheet">

                    <!-- CSS Reset : BEGIN -->
                    <style>
                        /* What it does: Remove spaces around the email design added by some email clients. */
                        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
                        html,
                        body {
                            margin: 0 auto !important;
                            padding: 0 !important;
                            height: 100% !important;
                            width: 100% !important;
                            background: #f1f1f1;
                        }

                        /* What it does: Stops email clients resizing small text. */
                        * {
                            -ms-text-size-adjust: 100%;
                            -webkit-text-size-adjust: 100%;
                        }

                        /* What it does: Centers email on Android 4.4 */
                        div[style*="margin: 16px 0"] {
                            margin: 0 !important;
                        }

                        /* What it does: Stops Outlook from adding extra spacing to tables. */
                        table,
                        td {
                            mso-table-lspace: 0pt !important;
                            mso-table-rspace: 0pt !important;
                        }

                        /* What it does: Fixes webkit padding issue. */
                        table {
                            border-spacing: 0 !important;
                            border-collapse: collapse !important;
                            table-layout: fixed !important;
                            margin: 0 auto !important;
                        }

                        /* What it does: Uses a better rendering method when resizing images in IE. */
                        img {
                            -ms-interpolation-mode:bicubic;
                        }

                        /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
                        a {
                            text-decoration: none;
                        }

                        /* What it does: A work-around for email clients meddling in triggered links. */
                        *[x-apple-data-detectors],  /* iOS */
                        .unstyle-auto-detected-links *,
                        .aBn {
                            border-bottom: 0 !important;
                            cursor: default !important;
                            color: inherit !important;
                            text-decoration: none !important;
                            font-size: inherit !important;
                            font-family: inherit !important;
                            font-weight: inherit !important;
                            line-height: inherit !important;
                        }

                        /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
                        .a6S {
                            display: none !important;
                            opacity: 0.01 !important;
                        }

                        /* What it does: Prevents Gmail from changing the text color in conversation threads. */
                        .im {
                            color: inherit !important;
                        }

                        /* If the above doesn"t work, add a .g-img class to any image in question. */
                        img.g-img + div {
                            display: none !important;
                        }

                        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
                        /* Create one of these media queries for each additional viewport size you"d like to fix */

                        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
                        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
                            u ~ div .email-container {
                                min-width: 320px !important;
                            }
                        }
                        /* iPhone 6, 6S, 7, 8, and X */
                        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
                            u ~ div .email-container {
                                min-width: 375px !important;
                            }
                        }

                        @media only screen and (min-device-width: 414px) {
                            u ~ div .email-container {
                                min-width: 414px !important;
                            }
                        }


                    </style>

                    <!-- CSS Reset : END -->

                    <!-- Progressive Enhancements : BEGIN -->
                    <style>
                        .primary{
                        background: #17bebb;
                        }
                        .bg_white{
                            background: #ffffff;
                        }
                        .bg_light{
                            background: #f7fafa;
                        }
                        .bg_black{
                            background: #000000;
                        }
                        .bg_dark{
                            background: rgba(0,0,0,.8);
                        }
                        .email-section{
                            padding:2.5em;
                        }

                        /*BUTTON*/
                        .btn{
                            padding: 10px 15px;
                            display: inline-block;
                        }
                        .btn.btn-primary{
                            border-radius: 5px;
                            background: #17bebb;
                            color: #ffffff;
                        }
                        .btn.btn-white{
                            border-radius: 5px;
                            background: #ffffff;
                            color: #000000;
                        }
                        .btn.btn-white-outline{
                            border-radius: 5px;
                            background: transparent;
                            border: 1px solid #fff;
                            color: #fff;
                        }
                        .btn.btn-black-outline{
                            border-radius: 0px;
                            background: transparent;
                            border: 2px solid #000;
                            color: #000;
                            font-weight: 700;
                        }
                        .btn-custom{
                            color: rgba(0,0,0,.3);
                            text-decoration: underline;
                        }

                        h1,h2,h3,h4,h5,h6{
                            font-family: "Poppins", sans-serif;
                            color: #000000;
                            margin-top: 0;
                            font-weight: 400;
                        }

                        body{
                            font-family: "Poppins", sans-serif;
                            font-weight: 400;
                            font-size: 15px;
                            line-height: 1.8;
                            color: rgba(0,0,0,.4);
                        }

                        a{
                            color: #17bebb;
                        }

                        table{
                        }
                        /*LOGO*/

                        .logo h1{
                            margin: 0;
                        }
                        .logo h1 a{
                            color: #17bebb;
                            font-size: 24px;
                            font-weight: 700;
                            font-family: "Poppins", sans-serif;
                        }

                        /*HERO*/
                        .hero{
                            position: relative;
                            z-index: 0;
                        }

                        .hero .text{
                            color: rgba(0,0,0,.3);
                        }
                        .hero .text h2{
                            color: #000;
                            font-size: 34px;
                            margin-bottom: 0;
                            font-weight: 200;
                            line-height: 1.4;
                        }
                        .hero .text h3{
                            font-size: 24px;
                            font-weight: 300;
                        }
                        .hero .text h2 span{
                            font-weight: 600;
                            color: #000;
                        }

                        .text-author{
                            bordeR: 1px solid rgba(0,0,0,.05);
                            max-width: 50%;
                            margin: 0 auto;
                            padding: 2em;
                        }
                        .text-author img{
                            border-radius: 50%;
                            padding-bottom: 20px;
                        }
                        .text-author h3{
                            margin-bottom: 0;
                        }
                        ul.social{
                            padding: 0;
                        }
                        ul.social li{
                            display: inline-block;
                            margin-right: 10px;
                        }

                        /*FOOTER*/

                        .footer{
                            border-top: 1px solid rgba(0,0,0,.05);
                            color: rgba(0,0,0,.5);
                        }
                        .footer .heading{
                            color: #000;
                            font-size: 12px;
                        }
                        .footer ul{
                            margin: 0;
                            padding: 0;
                        }
                        .footer ul li{
                            list-style: none;
                            margin-bottom: 10px;
                        }
                        .footer ul li a{
                            color: rgba(0,0,0,1);
                        }


                        @media screen and (max-width: 500px) {
                        }

                    </style>
                </head>

                <body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;">
                    <center style="width: 100%; background-color: #f1f1f1;">
                    <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
                    &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
                    </div>
                    <div style="max-width: 1000px; margin: 0 auto;" class="email-container">
                        <!-- BEGIN BODY -->
                    <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
                        <tr>
                            <td valign="top" class="bg_white" style="padding: 1em 1em 0 1em;">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td class="logo" style="text-align: center;">
                                            <img width="180px;" src="cid:' . $cid . '" alt="PT Rajawali Nusindo" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="logo" style="text-align: center;padding-top: 10px;">
                                            <h2 href="#"  class="heading"><b>E-PAYSLIP ' . $bulan[$salary_list[0]['bulan']] . " " . $salary_list[0]['tahun'] . '</b></h2>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
                            <tr>
                                <td valign="middle" class="bg_white footer email-section">
                                    <table>
                                        <tr>
                                            <td valign="top" width="100%" style="padding-top: 5px;">
                                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                    <tr style="background-color: #f2f2f2;">
                                                        <td style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> NIK </b>
                                                        </td>
                                                        <td width="2%" style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> : </b>
                                                        </td>
                                                        <td style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> ' . $salary_list[$i]['nik'] . ' </b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> NAMA </b>
                                                        </td>
                                                        <td width="2%" style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> : </b>
                                                        </td>
                                                        <td style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> ' . $salary_list[$i]['nama'] . ' </b>
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color: #f2f2f2;">
                                                        <td style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> JABATAN </b>
                                                        </td>
                                                        <td width="2%" style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> : </b>
                                                        </td>
                                                        <td style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> ' . $salary_list[$i]['jabatan_name'] . ' </b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> GOLONGAN </b>
                                                        </td>
                                                        <td width="2%" style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> : </b>
                                                        </td>
                                                        <td style="text-align: left; padding-right: 10px;">
                                                            <b class="heading"> ' . $salary_list[$i]['golongan'] . ' </b>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="100%" style="padding-top: 20px;">
                                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                    <tr>
                                                        <tr style="text-align: left; padding-right: 10px;">
                                                            <td colspan="3" style="background-color: #0054a6;">
                                                                <b class="heading" style="display:flex;align-items:center;color:white;padding-left:5px;"> GAJI NORMATIF </b>
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Gaji Pokok  
                                                            </td>
                                                            <td width="2%" style="height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">' . number_format($salary_list[$i]['gp']) . '</td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                TUNJ. KELUARGA 
                                                            </td>
                                                            <td width="2%" style="height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                ' . number_format($salary_list[$i]['tk']) . ' X ' . number_format($salary_list[$i]['gp']) . ' = ' . number_format($salary_list[$i]['gp'] * $salary_list[$i]['tk']) . '  
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                FAKTOR 
                                                            </td>
                                                            <td width="2%" style="height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                ' . number_format($salary_list[$i]['faktor']) . '
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Gaji Dasar Pensiun 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['gdp_amount']) . ' 
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Tunj. Golongan 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['tj_jabatan']) . ' 
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Tunj. Merit 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['tj_merit']) . ' 
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Tunj. Beras
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['tj_beras']) . ' 
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Tunj. Peralihan 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['tj_peralihan']) . ' 
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Tunj. Operasional 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['tj_ops']) . ' 
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Tunj. Bantuan Sosial 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['tj_bansos']) . ' 
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Tunj. Kompensasi UMP 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['tj_komp_ump']) . ' 
                                                            </td>
                                                        </tr>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="100%" style="padding-top: 5px;">
                                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                    <tr style="height:5px;">
                                                        <tr style="text-align: left; padding-right: 10px;">
                                                            <td colspan="3" style="background-color: #0054a6;">
                                                                <b class="heading" style="display:flex;align-items:center;color:white;padding-left:5px;"> TUNJANGAN </b>
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                STRUKTURAL 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['tj_struktur']) . ' 
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                LISTRIK & AIR 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['tj_listrik']) . ' 
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                TRANSPORT 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['tj_transport']) . ' 
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                PERUMAHAN 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['tj_rumah']) . ' 
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                SKALA 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['tj_skala']) . ' 
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                KEMAHALAN 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['tj_kemahalan']) . ' 
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                LAIN - LAIN 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['tj_lain']) . ' 
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                PPH Ps 21 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['pot_pph']) . ' 
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                PREMI PENSIUN
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['pot_pensiun']) . ' 
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                PREMI JAMSOSTEK 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['pot_jamsostek']) . ' 
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                BPJS KESEHATAN 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['pot_bpjs_kes']) . ' 
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                BPJS KETENAGAKERJAAN 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['pot_bpjs_tkj']) . ' 
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                UANG MUKA 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['pot_uang_muka']) . ' 
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                DPLK 
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['pot_dplk']) . ' 
                                                            </td>
                                                        </tr>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="100%" style="padding-top: 5px;">
                                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                    <tr>
                                                        <tr style="text-align: left; padding-right: 10px;">
                                                            <td colspan="3" style="background-color: #0054a6;">
                                                                <b class="heading" style="display:flex;align-items:center;color:white;padding-left:5px;"> JUMLAH PERHITUNGAN GAJI </b>
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                GAJI DASAR PENSIUN
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['gdp_amount']) . '
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                GAJI KOTOR
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['gaji_kotor']) . '
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                GAJI BERSIH
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['gaji_bersih']) . '
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                POTONGAN LAIN-LAIN
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                Rp ' . number_format($salary_list[$i]['pot_lain']) . '
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 5px; background-color: #f2f2f2;">
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                JUMLAH DIBAYAR
                                                            </td>
                                                            <td style="table-layout: auto;width: 2px; height: 5px; text-align: left; padding-right: 10px;">:</td>
                                                            <td style="height: 5px; text-align: left; padding-right: 10px;">
                                                                <b>Rp ' . number_format($salary_list[$i]['gaji_bayar']) . '</b>
                                                            </td>
                                                        </tr>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </table>
                    </div>
                    </center>
                </body>
                </html>
                ';
                // END
                $this->email->message($isiemail);
                $this->email->send(FALSE);
            }

            $response = [
                "totaldata" => $totaldata,
                "looping" => $looping
            ];
            // echo json_encode($isiemail);
        }

        private function _kirim_email($email, $subject, $isiemail)
        {
            $config = [
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://webmail.nusindo.co.id',
                'smtp_user' => 'rekrutmen@nusindo.co.id',
                'smtp_pass' => 'RNrekrutmen11',
                'smtp_port' => 465,
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'newline' => "\r\n",
                'validation' => TRUE
            ];


            // load email library and install configuration :
            $this->load->library('email', $config);
            $this->email->initialize($config);

            // Email sent from :
            $this->email->from('rekrutmen@nusindo.co.id', 'SLIP GAJI PT. Rajawali Nusindo');
            // Email recieve from this input
            // $this->email->attach(base_url() . "assets/images/nusindoPNG.png", "logoNusindo");
            $this->email->to($email);
            $this->email->subject($subject);
            $filename = base_url() . "assets/images/nusindoPNG.png";
            $this->email->attach($filename);
            $cid = $this->email->attachment_cid($filename);
            $this->email->message('<h1>SLIP GAJI</h1></hr><img src="cid:' . $cid . '" alt="photo1" /><h3>PT Rajawali Nusindo</h3>');
            // $this->email->message($isiemail);
            $r = $this->email->send(FALSE);
            return true;
            // if (!$r) {
            //     $this->email->print_debugger();
            // } else {
            //     return true;
            // }
        }

        function import_excel()
        {
            $this->load->helper('file');

            /* Allowed MIME(s) File */
            $file_mimes = array(
                'application/octet-stream',
                'application/vnd.ms-excel',
                'application/x-csv',
                'text/x-csv',
                'text/csv',
                'application/csv',
                'application/excel',
                'application/vnd.msexcel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            );

            if (isset($_FILES['uploadFile']['name']) && in_array($_FILES['uploadFile']['type'], $file_mimes)) {

                $array_file = explode('.', $_FILES['uploadFile']['name']);
                $extension  = end($array_file);

                if ('csv' == $extension) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }

                $spreadsheet = $reader->load($_FILES['uploadFile']['tmp_name']);
                $sheet_data  = $spreadsheet->getActiveSheet(0)->toArray();
                $array_data  = [];

                for ($i = 1; $i < count($sheet_data); $i++) {
                    $data = array(
                        'nik'       => $sheet_data[$i]['0'],
                        'gp'      => $sheet_data[$i]['1'],
                        'tk'        => $sheet_data[$i]['2'],
                        'gp_tk' => $sheet_data[$i]['3'],
                        'tk_amount' => $sheet_data[$i]['4'],
                        'faktor' => $sheet_data[$i]['5'],
                        'gdp_amount' => $sheet_data[$i]['6'],
                        'tj_jabatan' => $sheet_data[$i]['7'],
                        'tj_struktur' => $sheet_data[$i]['8'],
                        'tj_merit' => $sheet_data[$i]['9'],
                        'tj_beras' => $sheet_data[$i]['10'],
                        'tj_transport' => $sheet_data[$i]['11'],
                        'tj_rumah' => $sheet_data[$i]['12'],
                        'tj_listrik' => $sheet_data[$i]['13'],
                        'tj_ops' => $sheet_data[$i]['14'],
                        'tj_bansos' => $sheet_data[$i]['15'],
                        'tj_lembur' => $sheet_data[$i]['16'],
                        'tj_skala' => $sheet_data[$i]['17'],
                        'tj_peralihan' => $sheet_data[$i]['18'],
                        'tj_kemahalan' => $sheet_data[$i]['19'],
                        'tj_lain' => $sheet_data[$i]['20'],
                        'tj_komp_ump' => $sheet_data[$i]['21'],
                        'tj_pajak' => $sheet_data[$i]['22'],
                        'gaji_kotor' => $sheet_data[$i]['23'],
                        'pot_pph' => $sheet_data[$i]['24'],
                        'pot_pensiun' => $sheet_data[$i]['25'],
                        'pot_jamsostek' => $sheet_data[$i]['26'],
                        'pot_bpjs_kes' => $sheet_data[$i]['27'],
                        'pot_bpjs_tkj' => $sheet_data[$i]['28'],
                        'pot_dplk' => $sheet_data[$i]['29'],
                        'pot_uang_muka' => $sheet_data[$i]['30'],
                        'pot_koperasi' => $sheet_data[$i]['31'],
                        'pot_sumbangan_amount' => $sheet_data[$i]['32'],
                        'pot_lain' => $sheet_data[$i]['33'],
                        'gaji_bersih' => $sheet_data[$i]['34'],
                        'gaji_bayar' => $sheet_data[$i]['35'],
                        'bulan' => $sheet_data[$i]['36'],
                        'tahun' => $sheet_data[$i]['37'],
                    );
                    $array_data[] = $data;
                }

                if ($array_data != '') {
                    $this->payroll_model->insertDataSalaryBatch($array_data);
                }
                echo json_encode("Berhasil Import");
            } else {
                echo "Gagal Import";
            }
            // redirect('/');
        }

        // Start Invoice
        public function Invoice()
        {
            if ($this->session->userdata('user_login_access') != False) {
                /*$data['typevalue'] = $this->payroll_model->GetsalaryType();*/
                $id = $this->input->get('Id');
                $eid = $this->input->get('em');
                $data2 = array();

                $data['salary_info'] = $this->payroll_model->getAllSalaryDataById($id);

                // $data['salary_info']        = $this->payroll_model->getAllSalaryID($id);
                $data['employee_info']      = $this->payroll_model->getEmployeeID($eid);
                $data['salaryvaluebyid']    = $this->payroll_model->Get_Salary_Value($eid); // 24
                $data['salarypaybyid']      = $this->payroll_model->Get_SalaryID($eid);
                $data['salaryvalue']        = $this->payroll_model->GetsalaryValueByID($eid); // 25000
                $data['loanvaluebyid']      = $this->payroll_model->GetLoanValueByID($eid);
                $data['settingsvalue']      = $this->settings_model->GetSettingsValue();

                $data['addition'] = $this->payroll_model->getAdditionDataBySalaryID($data['salaryvalue']->id);
                $data['diduction'] = $this->payroll_model->getDiductionDataBySalaryID($data['salaryvalue']->id);
                //$data['diduction'] = $this->payroll_model->getDiductionDataBySalaryID($data['salaryvalue']->id);

                //$month = date('m');
                //$data['loanInfo']      = $this->payroll_model->getLoanInfoInvoice($id, $month);
                $data['otherInfo']      = $this->payroll_model->getOtherInfo($eid);
                $data['bankinfo']      = $this->payroll_model->GetBankInfo($eid);

                //Count Add/Did
                $month_init = $data['salary_info']->month;

                $month = date("n", strtotime($month_init));
                $year = $data['salary_info']->year;
                $id_em = $data['employee_info']->em_id;

                $data['id_em'] = $id_em;
                $data['month'] = $month;

                if ($month < 10) {
                    $month = '0' . $month;
                }

                //$data['hourlyAdditionDiduction']      = $month;


                $employeePIN = $this->getPinFromID($id_em);

                // Count Friday
                $fridays = $this->count_friday($month, $year);



                $month_holiday_count = $this->payroll_model->getNumberOfHolidays($month, $year);

                // Total holidays and friday count
                $total_days_off = $fridays + $month_holiday_count->total_days;

                // Total days in the month
                $total_days_in_the_month = $this->total_days_in_a_month($month, $year);

                $total_work_days = $total_days_in_the_month - $total_days_off;

                $total_work_hours = $total_work_days * 8;

                //Format date for hours count in the hours_worked_by_employee() function
                $start_date = $year . '-' . $month . '-' . 1;
                $end_date = $year . '-' . $month . '-' . $total_days_in_the_month;

                // Employee actually worked
                $employee_actually_worked = $this->hours_worked_by_employee($employeePIN->em_code, $start_date, $end_date);  // in hours

                //Get his monthly salary
                $employee_salary = $this->payroll_model->GetsalaryValueByID($id_em);
                if ($employee_salary) {
                    $employee_salary = $employee_salary->total;
                }

                // Hourly rate for the month
                $hourly_rate = $employee_salary / $total_work_hours; //15.62

                $work_hour_diff = abs($total_work_hours) - abs($employee_actually_worked[0]->Hours);



                $data['work_h_diff'] = $work_hour_diff;
                $addition = 0;
                $diduction = 0;
                if ($work_hour_diff < 0) {
                    $addition = abs($work_hour_diff) * $hourly_rate;
                } else if ($work_hour_diff > 0) {
                    $diduction = abs($work_hour_diff) * $hourly_rate;
                }
                // Loan
                $loan_amount = $this->payroll_model->GetLoanValueByID($id_em);
                if ($loan_amount) {
                    $loan_amount = $loan_amount->installment;
                }
                // Sending 

                $data['a'] = $addition;
                $data['d'] = $data['salary_info']->diduction;

                $this->load->view('backend/invoice', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        // Start Invoice
        public function load_employee_Invoice_by_EmId_for_pay()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $eid                         = $this->input->get('emid');
                $dateval                     = $this->input->get('date_time');
                $orderdate = explode('-', $dateval);
                $month = $orderdate[0];
                $year = $orderdate[1];
                $month = $this->month_number_to_name($month);
                //die($year); 
                $data2                      = array();
                $salary_info = $this->payroll_model->getAllSalaryDataByMonthYearEm($eid, $month, $year);
                //print_r($salary_info);
                //die();
                if (empty($salary_info)) {
                    echo "No Data Found";
                    die();
                }
                $employee_info      = $this->payroll_model->getEmployeeID($eid);
                $salaryvaluebyid    = $this->payroll_model->Get_Salary_Value($eid); // 24
                $salarypaybyid      = $this->payroll_model->Get_SalaryID($eid);
                $salaryvalue        = $this->payroll_model->GetsalaryValueByID($eid); // 25000
                $loanvaluebyid      = $this->payroll_model->GetLoanValueByID($eid);
                $settingsvalue      = $this->settings_model->GetSettingsValue();

                $addition = $this->payroll_model->getAdditionDataBySalaryID($salaryvalue->id);
                $diduction = $this->payroll_model->getDiductionDataBySalaryID($salaryvalue->id);

                //$data['diduction'] = $this->payroll_model->getDiductionDataBySalaryID($salaryvalue->id);
                //print_r($salary_info);
                //$month = date('m');
                //$data['loanInfo']      = $this->payroll_model->getLoanInfoInvoice($id, $month);
                $otherInfo      = $this->payroll_model->getOtherInfo($eid);
                $bankinfo      = $this->payroll_model->GetBankInfo($eid);
                //print_r($salary_info);
                //Count Add/Did
                $month_init = $salary_info->month;

                $month = date("n", strtotime($month_init));
                $year = $salary_info->year;
                $id_em = $employee_info->em_id;

                if ($month < 10) {
                    $month = '0' . $month;
                }

                //$data['hourlyAdditionDiduction']      = $month;


                $employeePIN = $this->getPinFromID($id_em);

                // Count Friday
                $fridays = $this->count_friday($month, $year);



                $month_holiday_count = $this->payroll_model->getNumberOfHolidays($month, $year);

                // Total holidays and friday count
                $total_days_off = $fridays + $month_holiday_count->total_days;

                // Total days in the month
                $total_days_in_the_month = $this->total_days_in_a_month($month, $year);

                $total_work_days = $total_days_in_the_month - $total_days_off;

                $total_work_hours = $total_work_days * 8;

                //Format date for hours count in the hours_worked_by_employee() function
                $start_date = $year . '-' . $month . '-' . 1;
                $end_date = $year . '-' . $month . '-' . $total_days_in_the_month;

                // Employee actually worked
                $employee_actually_worked = $this->hours_worked_by_employee($employeePIN->em_code, $start_date, $end_date);  // in hours

                //Get his monthly salary
                $employee_salary = $this->payroll_model->GetsalaryValueByID($id_em);
                if ($employee_salary) {
                    $employee_salary = $employee_salary->total;
                }

                // Hourly rate for the month
                $hourly_rate = $employee_salary / $total_work_hours; //15.62

                $work_hour_diff = abs($total_work_hours) - abs($employee_actually_worked[0]->Hours);



                $work_h_diff = $work_hour_diff;
                //$addition = 0;
                //$diduction = 0;
                if ($work_hour_diff < 0) {
                    $addition = abs($work_hour_diff) * $hourly_rate;
                } else if ($work_hour_diff > 0) {
                    $diduction = abs($work_hour_diff) * $hourly_rate;
                }
                // Loan
                $loan_amount = $this->payroll_model->GetLoanValueByID($id_em);
                if ($loan_amount) {
                    $loan_amount = $loan_amount->installment;
                }
                // Sending 

                $obj_merged = (object) array_merge((array) $employee_info, (array) $salaryvaluebyid, (array) $salarypaybyid, (array) $salaryvalue, (array) $loanvaluebyid);

                $dd = date('j F Y', strtotime($salary_info->paid_date));

                $a = $addition;
                $d = $diduction;
                //print_r($addition);
                $base = base_url();
                //echo $otherInfo[0]->dep_name;
                echo "<div class='row payslip_print' id='payslip_print'>
        <div class='col-md-12'>
                        <div class='card card-body'>
                            <div class='row'>
                                <div class='col-md-4 col-xs-6 col-sm-6'>
                                    <img src='$base/assets/images/dri_Logo.png' style=' width:180px; margin-right: 10px;' />
                                </div>
                                <div class='col-md-8 col-xs-6 col-sm-6 text-left payslip_address'>
                                    <p>
                                         $settingsvalue->address
                                    </p>
                                    <p>
                                        $settingsvalue->address2
                                    </p>
                                    <p>
                                        Phone: $settingsvalue->contact, Email: $settingsvalue->system_email
                                    </p>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12 text-left'>
                                    <h5 style='margin-top: 15px;'>Payslip for the period of $salary_info->month $salary_info->year</h5>
                                </div>
                            </div>
                            <div class='row' style='margin-bottom: 5px;'>
                                <div class='col-md-12'>
                                    <table class='table table-condensed borderless payslip_info'>
                                        <tr>
                                            <td>Employee PIN</td>
                                            <td>: $obj_merged->em_code</td>
                                            <td>Employee Name</td>
                                            <td>: $salary_info->first_name $salary_info->last_name</td>
                                        </tr>
                                        <tr>
                                            <td>Department</td>
                                            <td>:" . $otherInfo[0]->dep_name;
                echo "</td>
                                            <td>Designation</td>
                                            <td>:" . $otherInfo[0]->name;
                echo "</td>
                                        </tr>
                                        <tr>
                                            <td>Pay Date</td>
                                            <td>:" . $dd;
                echo "</td>
                                            <td>Date of Joining</td>
                                            <td>:$obj_merged->em_joining_date</td>
                                        </tr>
                                        <tr>
                                            <td>Days Worked</td>
                                            <td>:" .
                    ceil($salary_info->total_days / 8);
                echo "</td>";
                if (!empty($bankinfo->bank_name)) {
                    echo "<td>Bank Name</td>
                                            <td>:$bankinfo->bank_name</td>";
                } else {
                    echo "<td>Pay Type</td>
                                            <td>: Hand Cash</td>";
                }
                echo "</tr>";
                if (!empty($bankinfo->bank_name)) {
                    echo "<tr>
                                            <td>Account Name</td>
                                            <td>: $bankinfo->holder_name </td>
                                            <td>Account Number</td>
                                            <td>: $bankinfo->account_number </td>
                                        </tr>";
                }
                echo "</table>
                                </div>
                            </div>
                            <style>
                                .table-condensed>thead>tr>th, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>tbody>tr>td, .table-condensed>tfoot>tr>td { padding: 2px 5px; }
                            </style>
                            <div class='row'>
                                <div class='col-md-12'>
                                    <table class='table table-condensed borderless' style='border-left: 1px solid #ececec;'>
                                        <thead class='thead-light' style='border: 1px solid #ececec;'>
                                            <tr>
                                                <th>Description</th>
                                                <th class='text-right'>Earnings</th>
                                                <th class='text-right'>Deductions</th>
                                            </tr>
                                        </thead>
                                        <tbody style='border: 1px solid #ececec;'>
                                            <tr>
                                                <td>Basic Salary</td>
                                                <td class='text-right'>" . $addition[0]->basic;
                echo "BDT</td>
                                                <td class='text-right'>  </td>
                                            </tr>
                                            <tr>
                                                <td>Madical Allowance</td>
                                                <td class='text-right'>" . $addition[0]->medical;
                echo "BDT</td>
                                                <td class='text-right'>  </td>
                                            </tr>
                                            <tr>
                                                <td>House Rent</td>
                                                <td class='text-right'>" . $addition[0]->house_rent;
                echo "BDT</td>
                                                <td class='text-right'>  </td>
                                            </tr>
                                            <tr>
                                                <td>Conveyance Allowance</td>
                                                <td class='text-right'>" . $addition[0]->conveyance;
                echo "BDT</td>
                                                <td class='text-right'>  </td>
                                            </tr>
                                            <tr>
                                                <td>Bonus</td>
                                                <td class='text-right'>" . $salary_info->bonus;
                echo "</td>
                                                <td class='text-right'></td>
                                            </tr>
                                            <tr>
                                                <td>Loan</td>
                                                <td class='text-right'> </td>
                                                <td class='text-right'>";
                if (!empty($salary_info->loan)) {
                    echo $salary_info->loan;
                };
                echo "</td>
                                            </tr>
                                            <tr>
                                                <td>Working Hour ($salary_info->total_days hrs)</td>
                                                <td class='text-right'>
                                                </td>
                                                <td class='text-right'>
                                                         $salary_info->diduction BDT 
                                                </td>
                                                <td class='text-right'> </td>
                                            </tr>
                                            
                                            <tr>
                                                <td>Tax</td>
                                                <td class='text-right'> </td>
                                                <td class='text-right'> </td>
                                            </tr>
                                        </tbody>
                                        <tfoot class='tfoot-light'>
                                            <tr>
                                                <th>Total</th>
                                                <th class='text-right'>" . $total_add = $salary_info->basic + $salary_info->medical + $salary_info->house_rent + $salary_info->bonus;
                round($total_add, 2);
                echo "BDT</th>
                                                <th class='text-right'>" . $total_did = $salary_info->loan + $salary_info->diduction;
                round($total_did, 2);
                echo "BDT</th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th class='text-right'>Net Pay</th>
                                                <th class='text-right'>$salary_info->total_pay BDT</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
                        ";
            } else {
                redirect(base_url(), 'refresh');
            }
        }
        // End Invoice

        private function count_friday($month, $year)
        {
            $fridays = 0;
            $total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

            for ($i = 1; $i <= $total_days; $i++) {
                if (date('N', strtotime($year . '-' . $month . '-' . $i)) == 5) {
                    $fridays++;
                }
            }
            return $fridays;
        }

        private function total_days_in_a_month($month, $year)
        {
            return cal_days_in_month(CAL_GREGORIAN, $month, $year);
        }

        // Totals hours worked by an emplyee in a month
        private function hours_worked_by_employee($employeeID, $start_date, $end_date)
        {
            return $this->payroll_model->totalHoursWorkedByEmployeeInAMonth($employeeID, $start_date, $end_date);
        }


        private function getPinFromID($employeeID)
        {
            return $this->payroll_model->getPinFromID($employeeID);
        }

        /*GET WORKHOURS OF ANY MONTH - */
        /*||||| Method has not been used anywhere |||||*/
        public function GetSalaryByWorkdays()
        {

            if ($this->session->userdata('user_login_access') != False) {

                // Get the month and year
                $monthName = $this->input->get('monthName');
                $employeeID = $this->input->get('employeeID');
                $year = date("Y");

                // Count Friday
                $fridays = $this->count_friday($monthName, $year);


                $month_holiday_count = $this->payroll_model->getNumberOfHolidays($monthName, $year);

                // Total holidays and friday count
                $total_days_off = $fridays + $month_holiday_count->total_days;

                // Total days in the month
                $total_days_in_the_month = $this->total_days_in_a_month($monthName, $year);

                $total_work_days = $total_days_in_the_month - $total_days_off;

                $total_work_hours = $total_work_days * 8;

                //Format date for hours count in the hours_worked_by_employee() function
                $start_date = $year . '-' . $monthName . '-' . 1;
                $end_date = $total_days_in_the_month . '-' . $monthName . '-' . $total_days_in_the_month;

                // Employee actually worked
                $employee_actually_worked = $this->hours_worked_by_employee($employeeID, $start_date, $end_date);  // in hours

                //Get his monthly salary
                $employee_salary = $this->payroll_model->GetsalaryValueByID($employeeID);
                if ($employee_salary) {
                    $employee_salary = $employee_salary->total;
                }

                // Hourly rate for the month
                $hourly_rate = $employee_salary / $total_work_hours;

                $work_hour_diff = abs($total_work_hours) - abs($employee_actually_worked[0]->Hours); // 96 - 16 = 80

                $addition = 0;
                $diduction = 0;
                if ($work_hour_diff < 0) {
                    $addition = abs($work_hour_diff) * $hourly_rate;
                } else if ($work_hour_diff > 0) {
                    // 80 is > 0 which means he worked less, so diduction = 80 hrs
                    // so 80 * hourly rate 208 taka = 17500
                    $diduction = abs($work_hour_diff) * $hourly_rate;
                }

                // Loan
                $loan_amount = $this->payroll_model->GetLoanValueByID($employeeID);
                if ($loan_amount) {
                    $loan_amount = $loan_amount->installment;
                }

                // Sending 
                $data = array();
                $data['basic_salary'] = $employee_salary;
                $data['total_work_hours'] = $total_work_hours;
                $data['employee_actually_worked'] = $employee_actually_worked[0]->Hours;
                $data['addition'] = $addition;
                $data['diduction'] = $diduction;
                $data['loan'] = $loan_amount;
                echo json_encode($data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        public function month_number_to_name($month)
        {
            $dateObj   = DateTime::createFromFormat('!m', $month);
            return $dateObj->format('F'); // March
        }

        public function get_full_name($first_name, $last_name)
        {
            return $first_name . ' ' . $last_name;
        }

        // Add or update the salary record
        public function pay_salary_add_record()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $emid = $this->input->post('emid');
                $month = $this->month_number_to_name($this->input->post('month'));
                $basic = $this->input->post('basic');
                $year = $this->input->post('year');
                $hours_worked = $this->input->post('hours_worked');
                $addition = $this->input->post('addition');
                $diduction = $this->input->post('diduction');
                $loan_id = $this->input->post('loan_id');
                $loan = $this->input->post('loan');
                $total_paid = $this->input->post('total_paid');
                $paydate = $this->input->post('paydate');
                $status = $this->input->post('status');
                $paid_type = $this->input->post('paid_type');

                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters();
                $this->form_validation->set_rules('basic', 'basic', 'trim|required|min_length[3]|max_length[10]|xss_clean');

                if ($this->form_validation->run() == FALSE) {
                    echo validation_errors();
                    // redirect("Payroll/Generate_salary");
                } else {

                    $data = array();
                    $data = array(
                        'emp_id' => $emid,
                        'month' => $month,
                        'year' => $year,
                        'paid_date' => $paydate,
                        'total_days' => $hours_worked,
                        'basic' => $basic,
                        'loan' => $loan,
                        'total_pay' => $total_paid,
                        'addition' => $addition,
                        'diduction' => $diduction,
                        'status' => $status,
                        'paid_type' => $paid_type,
                    );

                    // See if record exists
                    $get_salary_record = $this->payroll_model->getSalaryRecord($emid, $month, $year);

                    if ($get_salary_record) {
                        $payID = $get_salary_record[0]->pay_id;
                        $payment_status = $get_salary_record[0]->status;
                    }

                    // If exists, add/edit
                    if (isset($payID) && $payID > 0) {

                        if ($payment_status == "Paid") {

                            echo "Has already been paid";
                        } else {

                            $success = $this->payroll_model->updatePaidSalaryData($payID, $data);

                            // Do the loan update
                            if ($success && $status == "Paid") {
                                $loan_info = $this->loan_model->GetLoanValuebyLId($loan_id);

                                // loan_id and loan fields already grabbed
                                if (!empty($loan_info)) {

                                    $period = $loan_info->install_period - 1;
                                    $number = $loan_info->loan_number;
                                    $data = array();
                                    $data = array(
                                        'emp_id' => $emid,
                                        'loan_id' => $loan_id,
                                        'loan_number' => $number,
                                        'install_amount' => $loan,
                                        /*'pay_amount' => $payment,*/
                                        'app_date' => $paydate,
                                        /*'receiver' => $receiver,*/
                                        'install_no' => $period
                                        /*'notes' => $notes*/
                                    );

                                    $success_installment = $this->loan_model->Add_installData($data);

                                    $totalpay = $loan_info->total_pay + $loan;
                                    $totaldue = $loan_info->amount - $totalpay;
                                    $period = $loan_info->install_period - 1;
                                    $loan_status = $loan_info->status;

                                    if ($period == '1') {
                                        $loan_status = 'Done';
                                    }

                                    $data = array();
                                    $data = array(
                                        'total_pay'         => $totalpay,
                                        'total_due'         => $totaldue,
                                        'install_period'    => $period,
                                        'status'            => $loan_status
                                    );

                                    $success_loan = $this->loan_model->update_LoanData($loan_id, $data);
                                }
                            }

                            echo "Successfully added";
                        }
                    } else {
                        $success = $this->payroll_model->insertPaidSalaryData($data);

                        // Do the loan update
                        if ($success && $status == "Paid") {

                            // Input Status
                            $loan_info = $this->loan_model->GetLoanValuebyLId($loan_id);

                            // loan_id and loan fields already grabbed
                            if (!empty($loan_info)) {

                                $period = $loan_info->install_period - 1;
                                $number = $loan_info->loan_number;
                                $data = array();
                                $data = array(
                                    'emp_id' => $emid,
                                    'loan_id' => $loan_id,
                                    'loan_number' => $number,
                                    'install_amount' => $loan,
                                    /*'pay_amount' => $payment,*/
                                    'app_date' => $paydate,
                                    /*'receiver' => $receiver,*/
                                    'install_no' => $period
                                    /*'notes' => $notes*/
                                );

                                $success_installment = $this->loan_model->Add_installData($data);

                                $totalpay = $loan_info->total_pay + $loan;
                                $totaldue = $loan_info->amount - $totalpay;
                                $period = $loan_info->install_period - 1;
                                $loan_status = $loan_info->status;

                                if ($period == '0') {
                                    $loan_status = 'Done';
                                }

                                $data = array();
                                $data = array(
                                    'total_pay'         => $totalpay,
                                    'total_due'         => $totaldue,
                                    'install_period'    => $period,
                                    'status'            => $loan_status
                                );

                                $success_loan = $this->loan_model->update_LoanData($loan_id, $data);
                            }

                            echo "Successfully added";
                        }
                    }
                }
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        // Generate the list of employees by dept. to generate their payments
        public function load_employee_by_deptID_for_pay()
        {

            if ($this->session->userdata('user_login_access') != False) {

                // Get the month and year
                $date_time = $this->input->get('date_time');
                $dep_id = $this->input->get('dep_id');

                $year = explode('-', $date_time);
                $month = $year[0];
                $year = $year[1];

                $employees = $this->payroll_model->GetDepEmployee($dep_id);

                foreach ($employees as $employee) {

                    $full_name = $this->get_full_name($employee->first_name, $employee->last_name);
                    // Loan
                    $has_loan = $this->payroll_model->hasLoanOrNot($employee->em_id);

                    echo "<tr>
                    <td>$employee->em_code</td>
                    <td>$full_name</td>
                    <td>$employee->total</td>
                    <td><a href=''
                                data-id='$employee->em_id' 
                                data-month='$month' 
                                data-year='$year' 
                                data-has_loan='$has_loan' 
                                class='btn btn-sm btn-info waves-effect waves-light salaryGenerateModal' 
                                data-toggle='modal'
                                data-target='#salaryGenerateModal'>
                        Generate Salary</a></td>
                </tr>";
                }

                // Sending 
                $data = array();
                // $data['basic_salary'] = $employee_salary;
                // $data['total_work_hours'] = $total_work_hours;
                // $data['employee_actually_worked'] = $employee_actually_worked[0]->Hours;
                // $data['addition'] = $addition;
                // $data['diduction'] = $diduction;
                // $data['loan'] = $loan_amount;
                echo json_encode($data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }

        public function generate_payroll_for_each_employee()
        {

            if ($this->session->userdata('user_login_access') != False) {
                // Get the month and year
                $month = $this->input->get('month');
                $year = $this->input->get('year');
                $employeeID = $this->input->get('employeeID');

                // Get employee PIN
                $employeePIN = $this->getPinFromID($employeeID);

                // Count Friday
                $fridays = $this->count_friday($month, $year);

                $month_holiday_count = $this->payroll_model->getNumberOfHolidays($month, $year);

                // Total holidays and friday count
                $total_days_off = $fridays + $month_holiday_count->total_days;

                // Total days in the month
                $total_days_in_the_month = $this->total_days_in_a_month($month, $year);

                $total_work_days = $total_days_in_the_month - $total_days_off;

                $total_work_hours = $total_work_days * 8;
                $sdate = 01;
                //Format date for hours count in the hours_worked_by_employee() function
                //$start_date = $year . '-' . $month . '-' . date('d');
                $result = strtotime("{$year}-{$month}-01");
                $start_date = date('Y-m-d', $result);
                $end_date = $year . '-' . $month . '-' . $total_days_in_the_month;

                // Employee actually worked
                $employee_actually_worked = $this->hours_worked_by_employee($employeePIN->em_code, $start_date, $end_date);  // in hours
                //echo json_encode($start_date);
                //Get his monthly salary
                $employee_salary = $this->payroll_model->GetsalaryValueByID($employeeID);


                if ($employee_salary) {
                    $employee_salary = $employee_salary->total;
                }

                // Hourly rate for the month
                $hourly_rate = $employee_salary / $total_work_hours;

                $work_hour_diff = abs($total_work_hours) - abs($employee_actually_worked[0]->Hours); // 96 - 16 = 80

                $addition = 0;
                $diduction = 0;
                if ($work_hour_diff < 0) {
                    $addition = abs($work_hour_diff) * $hourly_rate;
                } else if ($work_hour_diff > 0) {
                    // 80 is > 0 which means he worked less, so diduction = 80 hrs
                    // so 80 * hourly rate 208 taka = 17500
                    $diduction = abs($work_hour_diff) * $hourly_rate;
                }

                // Loan
                $loan_amount = 0;
                $loan_id = 0;
                $loan_info = $this->payroll_model->GetLoanValueByID($employeeID);
                if ($loan_info) {
                    $loan_amount = $loan_info->installment;
                    $loan_id = $loan_info->id;
                }

                // Final Salary
                $final_salary = $employee_salary + $addition - $diduction - $loan_amount;

                // Sending 
                $data = array();
                $data['basic_salary'] = $employee_salary;
                $data['total_work_hours'] = $total_work_hours;
                $data['employee_actually_worked'] = $employee_actually_worked[0]->Hours;
                $data['wpay'] = $total_work_hours - $employee_actually_worked[0]->Hours;
                $data['addition'] = round($addition, 2);
                $data['diduction'] = round($diduction, 2);
                $data['loan_amount'] = $loan_amount;
                $data['loan_id'] = $loan_id;
                $data['final_salary'] = round($final_salary, 2);
                $data['rate'] = round($hourly_rate, 2);
                echo json_encode($data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }
        public function Payslip_Report()
        {
            if ($this->session->userdata('user_login_access') != False) {
                $data = array();
                $data['employee'] = $this->employee_model->emselect();
                $this->load->view('backend/salary_report', $data);
            } else {
                redirect(base_url(), 'refresh');
            }
        }
    }
