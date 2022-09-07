<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-dollar" aria-hidden="true"></i> Payroll</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"><i class="fa fa-dollar" aria-hidden="true"></i> Payroll</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
                <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#TypeModal" data-whatever="@getbootstrap" class="text-white TypeModal"><i class="" aria-hidden="true"></i> Add Payroll </a></button>
                <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Payroll/Generate_salary" class="text-white"><i class="" aria-hidden="true"></i> Generate Payroll</a></button>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#importPayroll">
                    <i class="fa fa-file"></i>&nbsp; IMPORT PAYROLL
                </button>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#bulkSlipPayroll">
                    <i class="fa fa-file"></i>&nbsp; BULK SLIP
                </button>
                <a href="<?= base_url('Payroll/coba_email') ?>" target="_blank">COBA EMAIL</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">

                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"><i class="fa fa-dollar" aria-hidden="true"></i> Payroll List
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table id="tbl_payroll" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="border">#</th>
                                        <th class="border">NIK</th>
                                        <th class="border">NAMA</th>
                                        <th class="border">JABATAN</th>
                                        <th class="border">LOKASI</th>
                                        <th class="border">G.P.</th>
                                        <th class="border">T.K.(%)</th>
                                        <th class="border">T.K. AMOUNT</th>
                                        <th class="border">GP+TK</th>
                                        <th class="border">FAKTOR</th>
                                        <th class="border">GDP AMOUNT</th>
                                        <th class="border">TUNJ JABATAN</th>
                                        <th class="border">TUNJ STRUKTUR</th>
                                        <th class="border">TUNJ MERIT</th>
                                        <th class="border">TUNJ BERAS</th>
                                        <th class="border">TUNJ TRANSPORT</th>
                                        <th class="border">TUNJ RUMAH</th>
                                        <th class="border">TUNJ LISTRIK</th>
                                        <th class="border">TUNJ OPERASIONAL</th>
                                        <th class="border">TUNJ BANSOS</th>
                                        <th class="border">TUNJ LEMBUR</th>
                                        <th class="border">TUNJ SKALA</th>
                                        <th class="border">TUNJ PERALIHAN</th>
                                        <th class="border">TUNJ KEMAHALAN</th>
                                        <th class="border">TUNJ LAIN</th>
                                        <th class="border">TUNJ KOMP UMP</th>
                                        <th class="border">TUNJ PAJAK</th>
                                        <th class="border">GAJI KOTOR</th>
                                        <th class="border">POT PPH</th>
                                        <th class="border">POT PENSIUN</th>
                                        <th class="border">POT JAMSOSTEK</th>
                                        <th class="border">POT BPJS KES</th>
                                        <th class="border">POT BPJS TKJ</th>
                                        <th class="border">POT DPLK</th>
                                        <th class="border">POT UANG MUKA</th>
                                        <th class="border">GAJI BERSIH</th>
                                        <th class="border">POT KOPERASI</th>
                                        <th class="border">POT SUMBANGAN AMOUNT</th>
                                        <th class="border">POT LAIN2</th>
                                        <th class="border">GAJI BAYAR</th>
                                        <th class="border">BULAN</th>
                                        <th class="border">TAHUN</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="border">#</th>
                                        <th class="border">NIK</th>
                                        <th class="border">NAMA</th>
                                        <th class="border">JABATAN</th>
                                        <th class="border">LOKASI</th>
                                        <th class="border">G.P.</th>
                                        <th class="border">T.K.(%)</th>
                                        <th class="border">T.K. AMOUNT</th>
                                        <th class="border">GP+TK</th>
                                        <th class="border">FAKTOR</th>
                                        <th class="border">GDP AMOUNT</th>
                                        <th class="border">TUNJ JABATAN</th>
                                        <th class="border">TUNJ STRUKTUR</th>
                                        <th class="border">TUNJ MERIT</th>
                                        <th class="border">TUNJ BERAS</th>
                                        <th class="border">TUNJ TRANSPORT</th>
                                        <th class="border">TUNJ RUMAH</th>
                                        <th class="border">TUNJ LISTRIK</th>
                                        <th class="border">TUNJ OPERASIONAL</th>
                                        <th class="border">TUNJ BANSOS</th>
                                        <th class="border">TUNJ LEMBUR</th>
                                        <th class="border">TUNJ SKALA</th>
                                        <th class="border">TUNJ PERALIHAN</th>
                                        <th class="border">TUNJ KEMAHALAN</th>
                                        <th class="border">TUNJ LAIN</th>
                                        <th class="border">TUNJ KOMP UMP</th>
                                        <th class="border">TUNJ PAJAK</th>
                                        <th class="border">GAJI KOTOR</th>
                                        <th class="border">POT PPH</th>
                                        <th class="border">POT PENSIUN</th>
                                        <th class="border">POT JAMSOSTEK</th>
                                        <th class="border">POT BPJS KES</th>
                                        <th class="border">POT BPJS TKJ</th>
                                        <th class="border">POT DPLK</th>
                                        <th class="border">POT UANG MUKA</th>
                                        <th class="border">GAJI BERSIH</th>
                                        <th class="border">POT KOPERASI</th>
                                        <th class="border">POT SUMBANGAN AMOUNT</th>
                                        <th class="border">POT LAIN2</th>
                                        <th class="border">GAJI BAYAR</th>
                                        <th class="border">BULAN</th>
                                        <th class="border">TAHUN</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($salary_list as $key => $sl) { ?>
                                        <tr class="text-center">
                                            <td class="border"><?= $key + 1 ?></td>
                                            <td class="border"><?= $sl['nik'] ?></td>
                                            <td class="border"><?= $sl['nama'] ?></td>
                                            <td class="border"><?= $sl['jabatan'] ?></td>
                                            <td class="border"><?= $sl['cabang'] ?></td>
                                            <td class="border"><?= number_format($sl['gp']) ?></td>
                                            <td class="border"><?= number_format($sl['tk']) ?></td>
                                            <td class="border"><?= number_format($sl['gp_tk']) ?></td>
                                            <td class="border"><?= number_format($sl['tk_amount']) ?></td>
                                            <td class="border"><?= number_format($sl['faktor']) ?></td>
                                            <td class="border"><?= number_format($sl['gdp_amount']) ?></td>
                                            <td class="border"><?= number_format($sl['tj_jabatan']) ?></td>
                                            <td class="border"><?= number_format($sl['tj_struktur']) ?></td>
                                            <td class="border"><?= number_format($sl['tj_merit']) ?></td>
                                            <td class="border"><?= number_format($sl['tj_beras']) ?></td>
                                            <td class="border"><?= number_format($sl['tj_transport']) ?></td>
                                            <td class="border"><?= number_format($sl['tj_rumah']) ?></td>
                                            <td class="border"><?= number_format($sl['tj_listrik']) ?></td>
                                            <td class="border"><?= number_format($sl['tj_ops']) ?></td>
                                            <td class="border"><?= number_format($sl['tj_bansos']) ?></td>
                                            <td class="border"><?= number_format($sl['tj_lembur']) ?></td>
                                            <td class="border"><?= number_format($sl['tj_skala']) ?></td>
                                            <td class="border"><?= number_format($sl['tj_peralihan']) ?></td>
                                            <td class="border"><?= number_format($sl['tj_kemahalan']) ?></td>
                                            <td class="border"><?= number_format($sl['tj_lain']) ?></td>
                                            <td class="border"><?= number_format($sl['tj_komp_ump']) ?></td>
                                            <td class="border"><?= number_format($sl['tj_pajak']) ?></td>
                                            <td class="border"><?= number_format($sl['gaji_kotor']) ?></td>
                                            <td class="border"><?= number_format($sl['pot_pph']) ?></td>
                                            <td class="border"><?= number_format($sl['pot_pensiun']) ?></td>
                                            <td class="border"><?= number_format($sl['pot_jamsostek']) ?></td>
                                            <td class="border"><?= number_format($sl['pot_bpjs_kes']) ?></td>
                                            <td class="border"><?= number_format($sl['pot_bpjs_tkj']) ?></td>
                                            <td class="border"><?= number_format($sl['pot_dplk']) ?></td>
                                            <td class="border"><?= number_format($sl['pot_uang_muka']) ?></td>
                                            <td class="border"><?= number_format($sl['pot_koperasi']) ?></td>
                                            <td class="border"><?= number_format($sl['pot_sumbangan_amount']) ?></td>
                                            <td class="border"><?= number_format($sl['pot_lain']) ?></td>
                                            <td class="border"><?= number_format($sl['gaji_bersih']) ?></td>
                                            <td class="border"><?= number_format($sl['gaji_bayar']) ?></td>
                                            <td class="border"><?= $sl['bulan'] ?></td>
                                            <td class="border"><?= $sl['tahun'] ?></td>
                                        </tr>
                                    <?php } ?>

                                    <!-- Empty State -->
                                    <?php if (empty($salary_list)) { ?>
                                        <tr class="text-center">
                                            <td colspan="6">Data not found</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="importPayroll" tabindex="-1" role="dialog" aria-labelledby="importPayrollLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importPayrollLabel">Upload Payroll</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="form_ImportPayroll">
                        <div class="modal-body">

                            <!-- Progress bar -->
                            <span id="progress-bar" class="badge badge-pill badge-success m-3">0 %</span>

                            <!-- Upload File -->
                            <input name="uploadFile" class="form-control mb-1" type="file" accept=".xls,.xlsx,.csv" required>

                            <!-- Download Template -->
                            <a href="<?= base_url('assets/excel/template.xlsx') ?>" class="float-right" download>Download Template</a>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end -->
        <!-- Modal -->
        <div class="modal fade" id="bulkSlipPayroll" role="dialog" aria-labelledby="bulkSlipPayrollLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bulkSlipPayrollLabel">BULK SLIP Payroll</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="form_bulkSlipPayroll" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col">
                                <div class="form-group col-12 mt-2">
                                    <label for="cabang">Cabang</label>
                                    <select class="select2 form-control custom-select col-12" id="filter_cabang" name="filter_cabang" style="width: 100%;">
                                        <option selected value="">--pilih cabang--</option>
                                        <?php foreach ($cabang_all as $value) : ?>
                                            <option value="<?php echo $value['cabang'] ?>">
                                                <?php echo $value['cabang']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-12 mt-2">
                                    <label for="karyawan">Karyawan</label>
                                    <select class="select2 form-control custom-select col-12" data-placeholder="pilih karyawan" id="filter_karyawan" name="filter_karyawan" style="width: 100%;">
                                        <option selected value="">--pilih karyawan--</option>
                                        <?php foreach ($karyawan_all as $value) : ?>
                                            <option value="<?php echo $value['nik'] ?>">
                                                <?php echo '(' . $value['nik'] . ') ' . $value['nama']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body mr-3">
                            <!-- Progress bar -->
                            <span id="progress-slip" class="badge badge-pill badge-success mr-5">0 %</span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end -->
        <!--  -->
        <div class="modal fade" id="Salarymodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel1">Salary Form</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form method="post" action="Add_Salary" id="salaryform" enctype="multipart/form-data">
                        <div class="modal-body">
                            <!--			                                    <div class="form-group">
			                                     <label>Salary Type</label>
                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="typeid" required>
                                                    <?php #foreach($typevalue as $value): 
                                                    ?>
                                                    <option value="<?php #echo $value->id 
                                                                    ?>"><?php #echo $value->salary_type; 
                                                                        ?></option>
                                                    <?php #endforeach; 
                                                    ?>
                                                </select>
			                                    </div> -->
                            <div class="form-group">
                                <label class="control-label">Employee Id</label>
                                <input type="text" name="emid" class="form-control" id="recipient-name1" value="" readonly>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Basic</label>
                                <input type="text" name="basic" class="form-control" id="recipient-name1" value="">
                            </div>
                            <h4>Addition</h4>
                            <div class="form-group">
                                <label class="control-label">Medical</label>
                                <input type="text" name="medical" class="form-control" id="recipient-name1" value="">
                            </div>
                            <div class="form-group">
                                <label class="control-label">House Rent</label>
                                <input type="text" name="houserent" class="form-control" id="recipient-name1" value="">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Bonus</label>
                                <input type="text" name="bonus" class="form-control" id="recipient-name1" value="">
                            </div>
                            <h4>Deduction</h4>
                            <div class="form-group">
                                <label class="control-label">Provident Fund</label>
                                <input type="text" name="provident" class="form-control" id="recipient-name1" value="">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Bima</label>
                                <input type="text" name="bima" class="form-control" id="recipient-name1" value="">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Tax</label>
                                <input type="text" name="tax" class="form-control" id="recipient-name1" value="">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Others</label>
                                <input type="text" name="others" class="form-control" id="recipient-name1" value="">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="sid" value="" class="form-control" id="recipient-name1">
                            <input type="hidden" name="aid" value="" class="form-control" id="recipient-name1">
                            <input type="hidden" name="did" value="" class="form-control" id="recipient-name1">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $(".SalarylistModal").click(function(e) {
                    e.preventDefault(e);
                    // Get the record's ID via attribute  
                    var iid = $(this).attr('data-id');
                    $('#salaryform').trigger("reset");
                    $('#Salarymodel').modal('show');
                    $.ajax({
                        url: 'GetSallaryById?id=' + iid,
                        method: 'GET',
                        data: '',
                        dataType: 'json',
                    }).done(function(response) {
                        console.log(response);
                        // Populate the form fields with the data returned from server
                        $('#salaryform').find('[name="sid"]').val(response.salaryvalue.id).end();
                        $('#salaryform').find('[name="aid"]').val(response.salaryvalue.addi_id).end();
                        $('#salaryform').find('[name="did"]').val(response.salaryvalue.de_id).end();
                        /* $('#salaryform').find('[name="typeid"]').val(response.salaryvalue.type_id).end();*/
                        $('#salaryform').find('[name="emid"]').val(response.salaryvalue.emp_id).end();
                        $('#salaryform').find('[name="basic"]').val(response.salaryvalue.basic).end();
                        $('#salaryform').find('[name="medical"]').val(response.salaryvalue.medical).end();
                        $('#salaryform').find('[name="houserent"]').val(response.salaryvalue.house_rent).end();
                        $('#salaryform').find('[name="bonus"]').val(response.salaryvalue.bonus).end();
                        $('#salaryform').find('[name="provident"]').val(response.salaryvalue.provident_fund).end();
                        $('#salaryform').find('[name="bima"]').val(response.salaryvalue.bima).end();
                        $('#salaryform').find('[name="tax"]').val(response.salaryvalue.tax).end();
                        $('#salaryform').find('[name="others"]').val(response.salaryvalue.others).end();
                        $('#salaryform').find('[]')
                    });
                });
            });
        </script>
        <script type="text/javascript">
            // FORM IMPORT PAYROLL
            $("#form_ImportPayroll").on('submit', function(e) {
                e.preventDefault();
                $(".progress").attr('hidden', false);
                $.ajax({
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = (Math.ceil((evt.loaded / evt.total) * 100));
                                $("#progress-bar").text(percentComplete + ' %');
                                // $(".progress-bar").width(percentComplete + '%');
                                // $(".progress-bar").html(percentComplete + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    type: 'POST',
                    url: '<?= base_url("Payroll/import_excel") ?>',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#progress-bar").text('0 %');
                    },
                    success: function(response) {
                        console.log(response);
                        $(".message").fadeIn('fast').delay(3000).fadeOut('fast').html(response);
                        $('form').trigger("reset");
                        $(".modal").hide();
                        window.setTimeout(function() {
                            location.reload()
                        }, 1000);
                    },
                    error: function(response) {
                        $(".message").fadeIn('fast').delay(3000).fadeOut('fast').html(response);
                        window.setTimeout(function() {
                            location.reload()
                        }, 1000);
                    }
                });
            });

            $("#form_bulkSlipPayroll").on('submit', function(e) {
                e.preventDefault();
                $(".progress").attr('hidden', false);
                $.ajax({
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = (Math.ceil((evt.loaded / evt.total) * 100));
                                console.log(percentComplete);
                                $("#progress-slip").text(percentComplete + ' %');
                                $("#progress-slip").width(percentComplete + '%');
                                $("#progress-slip").html(percentComplete + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    type: 'POST',
                    url: '<?= base_url("Payroll/kirim_slip") ?>',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#progress-slip").text('0 %');
                    },
                    // success: function(response) {
                    //     console.log(response);
                    //     $(".message").fadeIn('fast').delay(3000).fadeOut('fast').html(response);
                    //     $('form').trigger("reset");
                    //     $(".modal").hide();
                    //     window.setTimeout(function() {
                    //         location.reload()
                    //     }, 1000);
                    // },
                    complete: function(xhr, textStatus) {
                        console.log(xhr.status);
                        $(".message").fadeIn('fast').delay(3000).fadeOut('fast').text('Berhasil');
                        $('form').trigger("reset");
                        $('.modal-body').html('<h1 style="color:green;"><b>BERHASIL!!!</b></h1>');
                        // $(".modal").hide();
                        // window.setTimeout(function() {
                        //     location.reload()
                        // }, 1000);
                    },
                    error: function(response) {
                        // $(".message").fadeIn('fast').delay(3000).fadeOut('fast').html(response);
                        // window.setTimeout(function() {
                        //     location.reload()
                        // }, 1000);
                    }
                });
            });

            $(document).ready(function() {
                $('#tbl_payroll').DataTable({});
                /*var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!
                var yyyy = today.getFullYear();

                if(dd<10) {
                    dd = '0'+dd
                } 

                if(mm<10) {
                    mm = '0'+mm
                }

                today = mm + '/' + dd + '/' + yyyy;*/

                var d = new Date();
                var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                var m = months[d.getMonth()];
                var y = d.getFullYear();
                //document.write(today);    
                var table = $('#example123').DataTable({
                    "aaSorting": [
                        [9, 'desc']
                    ],
                    dom: 'Bfrtip',
                    buttons: [{
                        extend: 'print',
                        title: 'Salary List' + '<br>' + m + ' ' + y,
                        customize: function(win) {
                            $(win.document.body)
                                .css('font-size', '50pt')
                                .prepend(
                                    '<img src="<?php echo base_url() ?>assets/images/dRi_watermark.png" style="position:absolute;background-size:300px 300px; top:35%; left:27%;" />'
                                );
                            $(win.document.body)
                                //.css( 'border', 'inherit' )
                                .prepend(
                                    '<footer class="footer" style="border:inherit"><img src="<?php echo base_url(); ?>assets/images/signature_vice.png" style="position:absolute; top:0; left:0;" /><img src="<?php echo base_url(); ?>assets/images/signature_ceo.png" style="position:absolute; top:0; right:0;height:30px;" /></footer>'
                                );
                            $(win.document.body).find('h1')
                                .addClass('header')
                                .css('display', 'inharit')
                                .css('position', 'relative')
                                .css('float', 'right')
                                .css('font-size', '24px')
                                .css('font-weight', '700')
                                .css('margin-right', '15px');
                            $(win.document.body).find('div')
                                .addClass('header-top')
                                .css('background-position', 'left top')
                                .css('height', '100px')
                                .prepend(
                                    '<img src="<?php echo base_url() ?>assets/images/dri_Logo.png" style="position:absolute;background-size:30%; top:0; left:0;" />'
                                );
                            $(win.document.body).find('div img')
                                .addClass('header-img')
                                .css('width', '300px');
                            $(win.document.body).find('h1')
                                .addClass('header')
                                .css('font-size', '25px');

                            $(win.document.body).find('table thead')
                                .addClass('compact')
                                .css({
                                    color: '#000',
                                    margin: '20px',
                                    background: '#e8e8e8',

                                });

                            $(win.document.body).find('table thead th')
                                .addClass('compact')
                                .css({
                                    color: '#000',
                                    border: '1px solid #000',
                                    padding: '15px 12px',
                                    width: '8%'
                                });

                            $(win.document.body).find('table tr td')
                                .addClass('compact')
                                .css({
                                    color: '#000',
                                    margin: '20px',
                                    border: '1px solid #000'

                                });

                            $(win.document.body).find('table thead th:nth-child(3)')
                                .addClass('compact')
                                .css({
                                    width: '15%',
                                });

                            $(win.document.body).find('table thead th:nth-child(1)')
                                .addClass('compact')
                                .css({
                                    width: '1%',
                                });

                            $(win.document.body).find('table thead th:nth-child(2)')
                                .addClass('compact')
                                .css({
                                    width: '5%',
                                });

                            $(win.document.body).find('table thead th:last-child')
                                .addClass('compact')
                                .css({
                                    display: 'none',

                                });

                            $(win.document.body).find('table tr td:last-child')
                                .addClass('compact')
                                .css({
                                    display: 'none',

                                });
                        }
                    }]
                });
                /*$("#example123 tfoot th").each( function ( i ) {
                		
                		if ($(this).text() !== '') {
                	        var isStatusColumn = (($(this).text() == 'Status') ? true : false);
                			var select = $('<select><option value=""></option></select>')
                	            .appendTo( $(this).empty() )
                	            .on( 'change', function () {
                	                var val = $(this).val();
                					
                	                table.column( i )
                	                    .search( val ? '^'+$(this).val()+'$' : val, true, false )
                	                    .draw();
                	            } );
                	 		
                			// Get the Status values a specific way since the status is a anchor/image
                			if (isStatusColumn) {
                				var statusItems = [];
                				
                                /* ### IS THERE A BETTER/SIMPLER WAY TO GET A UNIQUE ARRAY OF <TD> data-filter ATTRIBUTES? ### 
                				table.column( i ).nodes().to$().each( function(d, j){
                					var thisStatus = $(j).attr("data-filter");
                					if($.inArray(thisStatus, statusItems) === -1) statusItems.push(thisStatus);
                				} );
                				
                				statusItems.sort();
                								
                				$.each( statusItems, function(i, item){
                				    select.append( '<option value="'+item+'">'+item+'</option>' );
                				});

                			}
                            // All other non-Status columns (like the example)
                			else {
                				table.column( i ).data().unique().sort().each( function ( d, j ) {  
                					select.append( '<option value="'+d+'">'+d+'</option>' );
                		        } );	
                			}
                	        
                		}
                    } );*/

            });
        </script>
        <?php $this->load->view('backend/footer'); ?>
        <script>
            $('#salary123').DataTable({
                "aaSorting": [
                    [10, 'desc']
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        </script>