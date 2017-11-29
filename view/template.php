<!DOCTYPE html>
<html>

<head>
    <title>DANX</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-datepicker.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css?v=5">
    <script type="text/javascript" src="../js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/jquery.form.js"></script>
    <script type="text/javascript" src="../js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="../js/custom.js"></script>
</head>

<body>


<div class="container egov-width pg-header bg-colored">
        <div class="row">
            <div class="col-md-9">
                <span class="prof-title"><?php echo $user->company; ?></span>
            </div>
            <div class="col-md-3">
                <div class="hd-right">
                    <span class="hdr-key">VÖEN</span>
                    <span class="hdr-val"><?php echo $user->voen; ?></span>
                </div>
            </div>
        </div>
</div>


<div class="container egov-width main-info">
    <div class="row">

        <div class="col-md-2">
            <figure class="prof-img"> <img src="<?php echo $user->img; ?>"> </figure>
        </div>

        <div class="col-md-10">

            <div class="row">

                <div class="col-md-12 prof-type">
                    <a class="btn btn-<?php echo ($user->type ==2) ? 'danger' : 'success'; ?>"><?php echo ($user->type ==2) ? 'Hüquqi şəxs' : 'Fiziki şəxs'; ?></a>
                </div>

                <p class="vertical-space"></p>

                <div class="col-md-6">


                    <p>Soyadı , adı və atasının adı</p>
                    <p class="text-uppercase"><strong><?php echo $user->name; ?></strong></p>

                    <p class="vertical-space"></p>

                    <p>Doğum tarixi</p>
                    <p><strong><?php echo $user->date; ?></strong></p>

                </div>


                <?php if ($user->type ==2) { ?>

                <div class="col-md-6">

                    <p> VÖEN qeydiyyat adı</p>
                    <p><strong> <?php echo $user->company_long; ?> </strong> </p>

                    <p class="vertical-space"></p>


                    <p> VÖEN qeydiyyat ünvanı</p>
                    <p> <strong><?php echo $user->address; ?> </strong> </p>

                </div>

                <? } ?>

            </div>

        </div>
    </div>
</div>

<div class="container bg-colored egov-width selects">
    <div class="row">
        <div class="col-md-2 sel-title">Əlaqə vasitələri:</div>
        <div class="col-md-10 inputs no-border">

            <label> Tel : <input type="text" name="phone" class="form-control" value="<?php echo $user->phone; ?>"></label>
            <label> E-poçt : <input type="text" name="email" class="form-control" value="<?php echo $user->email; ?>"></label>
            <img class="ad-info-save" src="/images/save.png">
            <span class="ad-info-status"></span>


        </div>
    </div>
</div>

<div class="container egov-width table-div">

    <div class="row">

        <table class="table">
            <thead>
            <tr>
                <th>№</th>
                <th>Avtomobil</th>
                <th>Sürücü</th>
                <th>Nömrəsi</th>
                <th>Növü</th>
                <th>Nəf/ton</th>
                <th>Sənədlər</th>
                <th>Ərazinin növü</th>
                <th>Region</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody id="tbody">

            </tbody>
        </table>


        <div class="under-table clearfix">
            <div class="ut-left"> <a class="add-vehicle" href="javascript:void(0)"> <img src="../images/plus.png"> Avtomobil əlavə et </a> </div>
            <div class="ut-right">  </div>
        </div>

        <form action="/ajax.php?action=vehicle" style="display: none;"  method="post" class="vehicle-form form-horizontal ">

            <img class="close-form" src="/images/close.png">


            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label"></span>
                <div class="col-sm-8 col-lg-9 controls warning-msg"></div>
            </div>


            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Avtomobil</span>
                <div class="col-sm-8 col-lg-9 controls"><input type="text" name="vehicle" class="form-control" value=""></div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Sürücü</span>
                <div class="col-sm-8 col-lg-9 controls"><input type="text" name="driver" class="form-control" value=""></div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Nömrəsi</span>
                <div class="col-sm-8 col-lg-9 controls"><input type="text" name="number" class="form-control half-width" value=""></div>
            </div>

            <div class="form-group types-area">
                <span class="col-sm-4 col-lg-3 control-label">Növü</span>
                <div class="col-sm-8 col-lg-9 controls">
                    <span data-val="1" class="vehicle-ico1 active"></span>
                    <span data-val="2" class="vehicle-ico2"></span>
                    <span data-val="3" class="vehicle-ico3"></span>
                    <input type="hidden" name="type" value="1">
                </div>
            </div>

            <div class="form-group no-taxi">
                <span class="col-sm-4 col-lg-3 control-label">Nəfər / Ton</span>
                <div class="col-sm-8 col-lg-9 controls">
                    <input type="number" step="0.1" name="capacity" class="form-control half-width" value="0">
                </div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Fərqlənmə nişanının növü</span>
                <div class="col-sm-8 col-lg-9 controls">
                    <select class="form-control half-width" name="regiontype">
                        <option data-show="ontype3" value="0">Adi</option>
                        <option data-hide="ontype3" selected="selected" value="1">Şəhərdaxili</option>
                        <option data-hide="ontype3" value="2">Şəhərlərarası</option>
                        <option data-hide="ontype1" value="3">Xüsusi</option>
                        <option data-hide="ontype1" value="4">Sifariş</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Region</span>
                <div class="col-sm-8 col-lg-9 controls">

                    <select class="form-control half-width" name="region">
                        <?php echo $regions->getRegionList('bakı'); ?>
                    </select>

                    <select class="form-control half-width" name="toregion">
                        <?php echo $regions->getRegionList('bakı'); ?>
                    </select>

                </div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Başlanma tarixi</span>
                <div class="col-sm-8 col-lg-9 controls">
                    <input type="text"  name="fromdate" class="form-control datepicker half-width" readonly="" value="<?php echo date('Y.m.d'); ?>">
                </div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Müddət (ay)</span>
                <div class="col-sm-8 col-lg-9 controls">
                    <input type="number" step="1" name="months" class="form-control half-width" value="1">
                </div>
            </div>

            <input type="hidden" name="id" value="">


            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Texpasport (ön)</span>
                <div class="col-sm-8 col-lg-9 controls"><input type="file" name="doc1_1"> <div class="file-exists"></div> </div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Texpasport (arxa)</span>
                <div class="col-sm-8 col-lg-9 controls"><input type="file" name="doc1_2"><div class="file-exists"></div> </div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Sürücülük vəsiqəsi (ön)</span>
                <div class="col-sm-8 col-lg-9 controls"><input type="file" name="doc2_1"><div class="file-exists"></div>  </div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Sürücülük vəsiqəsi (arxa)</span>
                <div class="col-sm-8 col-lg-9 controls"><input type="file" name="doc2_2"><div class="file-exists"></div>  </div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label"></span>
                <div class="col-sm-8 col-lg-9 controls"><h5>Əgər texpasport başqasının adınadırsa</h5></div>
            </div>

            <div class="form-group">
                <span class="col-sm-4 col-lg-3 control-label">Etibarnamə </span>
                <div class="col-sm-8 col-lg-9 controls"><input type="file" name="doc3"><div class="file-exists"></div> </div>
            </div>

            <div class="loading-overlay" style="display: none"></div>

            <div class="final-div"> <div class="message-box"></div>  <button type="submit" class="do-action" href="javascript:void(0)"> Əməliyyatı tamamla </button> </div>

        </form>


    </div>


</div>



</body>

</html>